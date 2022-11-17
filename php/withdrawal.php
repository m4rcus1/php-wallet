<?php
session_start();
$error = '';
if (empty($_SESSION)) {
   session_destroy();
   echo '<script>
					window.location="index.php";
		</script>';
   
}
function check_id($id){
    $Host='127.0.0.1';
    $user='root';
    $pass='';
    $db='onlinebanking';

                                                            
    $conn=new mysqli($Host,$user,$pass,$db) or die("unable to connect to");
    if ($conn->connect_error) {
        echo die("Connection failed: " . $conn->connect_error);
    }
    $r=	mysqli_query($conn,"SELECT id FROM wait_accept_transaction where id=    '$id'");
    if($r-> num_rows>0){
        return true;
    }
    else{
        return false;
    }
}
function add_wait($money){
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
    $stm = $conn->prepare("insert into wait_accept_transaction(id,type_of_transaction,source,vertex,money_of_transaction,date_transaction,note) values(?,?,?,?,?,?,?)");
    $t1='Send money';
    $today=date("Y-m-d h:i:sa");
    $note=$_POST['card2'];
    $id1=1;
    while(check_id($id1)){
        $id1++;
    }
    $w='wallet';
    $c='card';
    $stm->bind_param('dsssdss',$id1,$t1,$w,$c,$money,$today,$note);
    if ($stm->execute()) {
        return true;
    }
    return $stm->error;
}

function add_tran($phone,$money)
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
    $stm = $conn->prepare("insert into transaction_history(Phonenumber,
        type_of_transaction,
        money_of_transaction,
        date_transaction,
        note) values(?,?,?,?,?)");
    $t1='Send money';
    $today=date("Y-m-d h:i:sa");
    $note='card to wallet';
    $stm->bind_param('ssdss',$phone,$t1,$money,$today,$note);
    if ($stm->execute()) {
        return true;
    }
    return $stm->error;
}
    function check_money($money,$card){
        $Host='127.0.0.1';
        $user='root';
        $pass='';
        $db='onlinebanking';
    
                                                                
        $conn=new mysqli($Host,$user,$pass,$db) or die("unable to connect to");
        if ($conn->connect_error) {
            echo die("Connection failed: " . $conn->connect_error);
        }
        $sql="SELECT * FROM Account where Phonenumber='$card'";
        $r=	$conn->query($sql);
                if($r-> num_rows>0){
                    $rows= mysqli_fetch_assoc($r);
                    if($money<=$rows['surplus']){
                        return true;
                    }else{
                        return false;
                    }
                }
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
    function check_cvv($cvv){
        $Host='127.0.0.1';
        $user='root';
        $pass='';
        $db='onlinebanking';
                                                                
        $conn=new mysqli($Host,$user,$pass,$db) or die("unable to connect to");
        if ($conn->connect_error) {
            echo die("Connection failed: " . $conn->connect_error);
        }
        $phone=$_SESSION['phone'];
        $sql="SELECT * FROM Money_card where Phonenumber='$phone'";
        $r=	$conn->query($sql);
                if($r-> num_rows>0){
                    $rows= mysqli_fetch_assoc($r);
                    if($cvv==$rows['cvv']){
                        return true;
                    }else{
                        return false;
                    }
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
    if (isset($_POST['card'])){
        $card=$_POST['card'];
        if(empty($_POST['card'])){
            $error='Please input your id card';
        }
        else if(!check_card($card)){
            $error='this card is not exist';
        }else{
            if(isset($_POST['monney_send'])){
                $money=(int)$_POST['monney_send'];
           
                if(empty($_POST['monney_send'])){
                    $error='Please input amount of money';
                }else if(!check_w($money)){
                    $error='ban khong du tien';
                }else{
                    if(isset($_POST['cvv'])){
                        $pass=$_POST['cvv'];
                        if(empty($_POST['cvv'])){
                            $error='input your cvv';
                        }else if(!check_cvv($pass)){
                            $error='sai cvv';
                        }
                        else if($money>5000000){
                            add_wait($money);
                            echo '<script>alert("So tien cua ban qua lon can duoc cho duyet");
                                                window.location="main.php";
                                    </script>';
                        }else{
                                    $Host = '127.0.0.1';
                                    $user = 'root';
                                    $pass = '';
                                    $db = 'onlinebanking';
                                    $conn = new mysqli($Host, $user, $pass, $db) or die("unable to connect to");
                                    if ($conn->connect_error) {
                                        echo die("Connection failed: " . $conn->connect_error);
                                    }
                                    $sql="SELECT * FROM Money_card where Cardnumber='$card'";
                                    $r=	$conn->query($sql);
                                    if($r-> num_rows>0){
                                        $rows= mysqli_fetch_assoc($r);
                                        $m1=$rows['surplus'];
                                        $m1=$m1+$money;
                                        $phone=$_SESSION['phone'];
                                        $r1 = mysqli_query($conn, "UPDATE Money_card SET surplus='$m1' WHERE  Cardnumber='$card'");
                                        $sql="SELECT * FROM Wallet where Phonenumber='$phone'";
                                        $r=	$conn->query($sql);
                                            
                                        $rows= mysqli_fetch_assoc($r);
                                        $m2=$rows['W_surplus'];
                                        $m2=$m2-$money;
                                        $r=mysqli_query($conn, "UPDATE Wallet SET W_surplus='$m2' WHERE Phonenumber='$phone'");
                                        add_tran($phone,$money);
                                        echo '<script>alert("Successful");
                                                        window.location="main.php";
                                                </script>';
                                    }
                                    else{
                                        echo 1;
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sendmoney.css">
    <title>Document</title>
</head>
<body>
    <div class="send">
<center> <form id="main" method="post">
     <h1>Withdraw Money</h1>
        <div class="form-group">
            <label for="Card">Card:</label><br>
            <input type="text" id="card" name="card" placeholder="Enter your card" style="width:500px">
        </div>
        <div class="form-group">
            <label for="monney_send">Money:</label><br>
            <input type="text" id="monney_send" name="monney_send" placeholder="Enter your money" style="width:500px">
        </div>
        <div class="form-group">
            <label for="pass">CVV:</label><br>
            <input type="password" id="cvv" name="cvv" placeholder="Enter the CVV:" style="width:500px">
        </div>
        <div id="submit">
            <input type="submit" class="btn btn-primary" value="Register" id="submit1">
            <input class="btn btn-danger" type="reset" value="Reset">
            
        </div>
    </div>
    <div class="sendimg">
        <img src="image/send.png" alt="">
       
     </div>
</div>
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