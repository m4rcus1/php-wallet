<?php 
    session_start();
    $error = '';
  
    if (empty($_SESSION)) {
       session_destroy();
       echo '<script>
                        window.location="index.php";
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
        $r=	mysqli_query($conn,"SELECT Phonenumber FROM Account where Phonenumber='$phone'");
        if($r-> num_rows>0){
            return true;
        }
        else{
            return false;
        }
    }
    if(isset($_POST['phone'])){
        $phone=$_POST['phone'];
        if(empty($phone)){
            $error='Please input your phone number';
        }else if($phone!=$_SESSION['phone']){
            $error='Your phone number is incorrect';
        }
        else{
            if(isset($_POST['pass1'])){
                $pass1=$_POST['pass1'];
                if(empty($_POST['pass1'])){
                $error='Please input your password';}
                else if (strlen($pass1) < 6) {
                    $error = 'Your password must be at least 6 characters';
                 } else {
                    if (isset($_POST['pass2'])) {
                       $pass2 = $_POST['pass2'];
                       if (empty($pass2)) {
                          $error = 'Please enter your password for the second time';
                       } else if ($pass1 != $pass2) {
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
                          $r =("UPDATE Account SET Pass='$pass2' WHERE  Phonenumber ='$phone'");
                          if ($conn->query($r) === TRUE) {
                            
                                   echo '<script>alert("Successful");window.location="main.php";</script>';
                           
                             
                            
                          } else {
                             echo '<script>alert("that bai")</script>';
                          }
                       }
                    }
                 }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="reset.css"
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <div class="change">
            <h1> Change Password </h1>
                    <br> <p>
                        Information 
                    </p>
                    <input type="text" id='phone' name='phone' placeholder="Enter Phonenumber" required>
            <br> <p>
                    New password
                </p>
                <br>
            <input type="password" id='pass1' name='pass1' placeholder="Enter New Password" required>
            <br> <p>
                Retype new password
            </p>
            <br>
    
            <input type="password" id='pass2' name='pass2' placeholder="Retype New Password" required>
            <input type="submit" name="nopform" value="Submit">
        <input type="reset" name="datlai" value="Reset">
        </div>
    </form>
</body>
</html>