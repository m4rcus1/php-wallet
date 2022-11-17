<?php
session_start();
$error = '';

if (empty($_SESSION)) {
   session_destroy();
   echo '<script>
					window.location="index.php";
			</script>';
   
}
if(count($_SESSION)<9){
   session_destroy();
   echo '<script>
					window.location="index.php";
			</script>';
}
if($_SESSION['sts']!=0){
   echo '<script>
					window.location="main.php";
			</script>';
}
function check_phone($phone){
   $Host='127.0.0.1';
   $user='root';
   $pass='';
   $db='onlinebanking';

                                                           
   $conn=new mysqli($Host,$user,$pass,$db) or die("unable to connect to");
   if ($conn->connect_error) {
       echo die("Connection failed: " . $conn->connect_error);
   }
   $r=	mysqli_query($conn,"SELECT Phonenumber FROM wallet where Phonenumber='$phone'");
   if($r-> num_rows>0){
       return true;
   }
   else{
       return false;
   }
}
function change_pass($phone, $pass)
{
   $Host = '127.0.0.1';
   $user = 'root';
   $pass = '';
   $db = 'onlinebanking';

   echo $pass;
   $conn = new mysqli($Host, $user, $pass, $db) or die("unable to connect to");
   if ($conn->connect_error) {
      echo die("Connection failed: " . $conn->connect_error);
   }
   $r = mysqli_query($conn, "UPDATE Account SET Pass='$pass' WHERE  Phonenumber ='$phone'");
   if ($r->num_rows > 0) {
      return true;
   } else {
      return false;
   }
}

if (isset($_POST['pass'])) {
   $pass = $_POST['pass'];
   if (empty($pass)) {
      $error = 'Please enter your new password';
   } else if (strlen($pass) < 6) {
      $error = 'Your password must be at least 6 characters';
   } else {
      if (isset($_POST['pass2'])) {
         $pass2 = $_POST['pass2'];
         if (empty($pass2)) {
            $error = 'Please enter your password for the second time';
         } else if ($pass != $pass2) {
            $error = 'NOT SAME';
         } else {
            $Host = '127.0.0.1';
            $user = 'root';
            $pass = '';
            $db = 'onlinebanking';

            echo $pass;
            $conn = new mysqli($Host, $user, $pass, $db) or die("unable to connect to");
            if ($conn->connect_error) {
               echo die("Connection failed: " . $conn->connect_error);
            }
            $phone=$_SESSION['phone'];
            $sts=1;
            $r =("UPDATE Account SET Pass='$pass2',Sts='$sts' WHERE  Phonenumber ='$phone'");

            if ($conn->query($r) === TRUE) {
               $_SESSION['password'] = $pass;
               $_SESSION['sts']=1;
               $stm = $conn->prepare("insert into Wallet(Phonenumber,W_surplus) values(?,?)");
	            $w=0;
               if(!check_phone($_SESSION['phone'])){
               $stm->bind_param('sd',$phone,$w);}
               if ($stm->execute()) {
                     session_destroy();
                     echo '<script>alert("Successful");window.location="login.php";</script>';
                     return true;
               }
               
              
            } else {
               echo '<script>alert("that bai")</script>';
            }
         }
      }
   }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   <link rel="stylesheet" href="change.css">
   <title>Document</title>
</head>

<body>
  <center> <form id="main" method="post">
      <div class="form-group">
         <label for="pass">Pass:</label><br>
         <input type="password" id="pass" name="pass" placeholder="Enter your new password" value="<?php if (isset($_POST['pass']) and $_POST['pass'] != '') {
                                                                                                      echo $_POST['pass'];
                                                                                                   } ?>" style="width:500px">
      </div>
      <div class="form-group">
         <label for="pass">Pass:</label><br>
         <input type="password" id="pass2" name="pass2" placeholder="Enter your new password again" value="<?php if (isset($_POST['pass2']) and $_POST['pass2'] != '') {
                                                                                                               echo $_POST['pass2'];
                                                                                                            } ?>" style="width:500px">
      </div>
      <div id="submit">
         <input type="submit" class="btn btn-primary" value="Register" id="submit1">
         <input class="btn btn-danger" type="reset" value="Reset">
      </div>
      <?php
      if ($error != "") {
         echo "<br><div class='alert alert-danger'><center>$error </center></div>";
      }
      ?>
   </form>
   </center>
</body>

</html>