<?php 
    session_start();
    $error = '';
    // print_r($_SESSION);
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
    function check_w($money){
        $Host='127.0.0.1';
        $user='root';
        $pass='';
        $db='onlinebanking';
    
                                                                
        $conn=new mysqli($Host,$user,$pass,$db) or die("unable to connect to");
        if ($conn->connect_error) {
            echo die("Connection failed: " . $conn->connect_error);
        }
        $phone=$_SESSION['phone'];
        $sql="SELECT * FROM Wallet where Phonenumber='$phone'";
        $r=	$conn->query($sql);
                if($r-> num_rows>0){
                    $rows= mysqli_fetch_assoc($r);
                    if($money<=$rows['W_surplus']){
                        return true;
                    }else{
                        return false;
                    }
                }
    }
    function add_tran($money)
    {
        $Host='127.0.0.1';
        $user='root';
        $pass='';
        $db='onlinebanking';

                                                                
        $conn=new mysqli($Host,$user,$pass,$db) or die("unable to connect to");
        // $stm=$conn->prepare($sql);
        // $stm->bind_param('s',$ghichu);
        // $stm->execute();
        if ($conn->connect_error) {
            echo die("Connection failed: " . $conn->connect_error);
        }
        // $sql="insert into bangghichu(ghichu) values(?)";
        $stm = $conn->prepare("insert into transaction_history(type_of_transaction,money_of_transaction,date_transaction,note) values(?,?,?,?)");
        $t1='Buy phone card';
        $today=date("Y-m-d h:i:sa");
        $note=$_POST["card_type"];
        $stm->bind_param('sdss',$t1,$money,$today,$note);
        if ($stm->execute()) {
            return true;
        }
        return $stm->error;
    }
    if(isset($_POST["card_type"])){
        if(empty($_POST["card_type"])){
            $error='Input your card type';
        }else{
            $card=$_POST["card_type"];
            if($card!='Viettel' and $card!='vinaphone' and $card!='Mobi'){
                $error='Not exists';
            }else{
                if(isset($_POST["price"])){
                    if(empty($_POST["price"])){
                        $error='Input your card price';
                    }else{
                        $price=(int)$_POST["price"];
                        if($price%10000!=0){
                                $error='Invalid price';
                        }
                        
                        else{
                            if(!check_w($price)){
                                $error='not enough';
                            }
                            else{
                                $Host = '127.0.0.1';
                                $user = 'root';
                                $pass = '';
                                $db = 'onlinebanking';
                                $conn = new mysqli($Host, $user, $pass, $db) or die("unable to connect to");
                                if ($conn->connect_error) {
                                    echo die("Connection failed: " . $conn->connect_error);
                                }
                                $phone=$_SESSION['phone'];
                                $sql="SELECT * FROM Wallet where Phonenumber='$phone'";
                                        $r=	$conn->query($sql);
                                            
                                        $rows= mysqli_fetch_assoc($r);
                                $m2=$rows['W_surplus'];
                               
                                        $m2=(int)$m2-(int)$_POST['price'];
                                        add_tran($_POST['price']);
                                        $r=mysqli_query($conn, "UPDATE Wallet SET W_surplus='$m2' WHERE Phonenumber='$phone'");
                                    $num_card=rand(1000000000,9999999999);
                                    echo "<script>alert('$num_card');window.location='main.php';</script>;
                            
                            ";}
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
    <link rel="stylesheet" href="phone_card.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
                <form method="post">
                    <div class="Phonecard">
                    <div class="form-group">
                        <h1>BUY TO PHONE CARD </h1>
                        <br> 
                           
                        &emsp; &emsp; &emsp;Card:<input type="text" class="form-control" placeholder="Enter your phone card type" id="card_type" name="card_type"> 
                        <br>
                        &nbsp;Price of card:<input type="text" class="form-control" placeholder="Enter your price of card" id="price" name="price">
                    </div>
                    <div class="cards2">
                        <img src="image/mobiphone.png" alt="">
                        <img src="image/viettel.png" alt="">
                        <img src="image/vinaphone.png" alt="">
                     </div>
                   
                    <div id="submit">
                        <input type="submit" class="btn btn-primary" value="Register" id="submit1">
                        <input class="btn btn-danger" type="reset" value="Reset">
                    </div>
                   
                </div>
                </form>
                <?php
				if ($error != "") {
					echo "<br><div class='alert alert-danger'><center>$error </center></div>";
				}
				?>
</body>
</html>