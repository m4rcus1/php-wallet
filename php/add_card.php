<?php
session_start();
$error = '';

if (empty($_SESSION)) {
   session_destroy();
   echo '<script>
                    window.location="index.php";
            </script>';
}
if($_SESSION['sts']==0){
  echo '<script>
                    window.location="change.php";
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
function check_card($card){
    $Host='127.0.0.1';
    $user='root';
    $pass='';
    $db='onlinebanking';

                                                            
    $conn=new mysqli($Host,$user,$pass,$db) or die("unable to connect to");
    if ($conn->connect_error) {
        echo die("Connection failed: " . $conn->connect_error);
    }
    $r=	mysqli_query($conn,"SELECT Cardnumber FROM Money_card where Cardnumber='$card'");
    if($r-> num_rows>0){
        return true;
    }
    else{
        return false;
    }
}
if(isset($_POST['cvv'])){
    $cvv=$_POST['cvv'];
    if(empty($_POST['cvv'])){
        $error = 'Please enter your CVV';
    }else{
        if (isset($_POST['card'])) {
            $card = $_POST['card'];
            if (empty($_POST['card'])) {
               $error = 'Please enter your id card';
            } else if (strlen($card) != 6) {
               $error = 'invalid';
            } 
            else{
                $today = date("Y-m-d");
                if(isset($_POST['end'])){
                    $end=$_POST['end'];
                    if(empty($_POST['end'])){
                        $error='pls input end day';
                    }else if($end<=$today){
                        $error='invalid date';
                    }else{
                        $Host = '127.0.0.1';
                        $user = 'root';
                        $pass = '';
                        $db = 'onlinebanking';
                        $conn = new mysqli($Host, $user, $pass, $db) or die("unable to connect to");
                        if ($conn->connect_error) {
                           echo die("Connection failed: " . $conn->connect_error);
                        }
                        $phone=$_SESSION['phone'];
                        if(check_phone($phone)){
                            if(check_card($card)){
                                $error = 'Id is already in use';
                            }
                            else{
                            $stm = $conn->prepare("insert into Money_card( Cardnumber,Phonenumber,surplus,cvv,date_at_exp) values(?,?,?,?,?)");
                            $money=10000000;
                            $stm->bind_param('ssdds',$card,$phone,$money,$cvv,$end);
                            if ($stm->execute()) {
                                $_SESSION['card']=$card;
                                echo '<script>alert("Successful");
                                window.location="main.php";</script>';
                            }
                                return $stm->error;
                            }
                        }
                         else {
                           echo 'Fail';
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
    <link rel="stylesheet" href="add_card.css"
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="transfer">
    <form id="main" method="post">
            <h1> Confirm Your Payment </h1>
                    
            <br><p>
                CVV
            </p>
            <br>
            <input type="password" id="cvv" name="cvv" style="width:450px">
            <br><p>
                Card Number
            </p>
            <br>
            <input type="text" id="card" name="card" style="width:450px">
            <br> <p>
            <label for="end">Expiration Date:</label><br>
            </p>
            <input type="date" id="end" name="end" style="width:450px">

            <div class="cards">
                <img src="image/mc.png" alt="">
                <img src="image/vi.png" alt="">
                <img src="image/pp.png" alt="">
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
    </div>

</body>