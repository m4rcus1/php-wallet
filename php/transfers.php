<?php
    session_start();
    if (empty($_SESSION)) {
        session_destroy();
        echo '<script>
                         window.location="index.php";
            </script>';
     }
    $error="";
    function check_money($money,$phone){
        $Host='127.0.0.1';
        $user='root';
        $pass='';
        $db='onlinebanking';
    
                                                                
        $conn=new mysqli($Host,$user,$pass,$db) or die("unable to connect to");
        if ($conn->connect_error) {
            echo die("Connection failed: " . $conn->connect_error);
        }
        $sql="SELECT * FROM Wallet where Phonenumber ='$phone'";
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
        $t1='Tranfers';
        $today=date("Y-m-d h:i:sa");
        $note=$_POST['card2'];
        $id1=1;
        while(check_id($id1)){
            $id1++;
        }
        $s=$_POST['card'];
        $c=$_POST['card2'];
        $stm->bind_param('dsssdss',$id1,$t1,$s,$c,$money,$today,$note);
        if ($stm->execute()) {
            return true;
        }
        return $stm->error;
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
        $stm = $conn->prepare("insert into transaction_history(Phonenumber,
        type_of_transaction,
        money_of_transaction,
        date_transaction,
        note) values(?,?,?,?,?)");
        $t1='Transfer';
        $today=date("Y-m-d h:i:sa");
        $note='card to wallet';
        $stm->bind_param('ssdss',$phone,$t1,$money,$today,$note);
        if ($stm->execute()) {
            return true;
        }
        return $stm->error;
    }
    if(isset($_POST['phone'])){
        $phone_s=$_POST['phone'];
        if(empty($_POST['phone'])){
            $error='Please input phone';
        }else if(!check_phone($phone_s)){
            $error='this phone is not exist';
        }else{ 
            if(isset($_POST['monney_send'])){
            $money=(int)$_POST['monney_send'];
       
            if(empty($_POST['monney_send'])){
                $error='Please input amount of money';
            }else if(!check_money($money,$phone_s)){
                $error='ban khong du tien';
            }else{
                    if(isset($_POST['note'])){
                        $note=$_POST['note'];
                    if(empty($_POST['note'])){
                        $error='input your note';
                    }else if($money>5000000){
                        add_wait($money);
                        echo '<script>alert("So tien cua ban qua lon can duoc cho duyet");
                                            window.location="main.php";
                                </script>';
                    }
                    else{
                       $Host='127.0.0.1';
        $user='root';
        $pass='';
        $db='onlinebanking';
    
                                                                
        $conn=new mysqli($Host,$user,$pass,$db) or die("unable to connect to");
        if ($conn->connect_error) {
            echo die("Connection failed: " . $conn->connect_error);
        }
                        $sql="SELECT * FROM Wallet where Phonenumber='$phone_s'";
                        $r=	$conn->query($sql);
                     
                        if($r-> num_rows>0){
                            $rows= mysqli_fetch_assoc($r);
                            $m1=$rows['W_surplus'];
                            $m1=$m1-$money;
                            $r1 = mysqli_query($conn, "UPDATE Wallet SET W_surplus='$m1' WHERE  Phonenumber='$phone_s'");
                        
                            $sql="SELECT * FROM Money_card where Cardnumber='$card2'";
                            $r=	$conn->query($sql);
                                
                            $rows= mysqli_fetch_assoc($r);
                            $m2=$rows['surplus'];
                            $m2=$m2+$money;
                            $r1 = mysqli_query($conn, "UPDATE Wallet SET W_surplus='$m1' WHERE  Phonenumber='$phone_s'");
                            add_tran($money);
                            echo '<script>alert("Successful");
                                            window.location="main.php";
                                </script>';
                                
                            
                           
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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="transfers.css">
    <title>Transfer</title>
</head>

<body>
  <center> <form id="main" method="post">
      <div class="form-group">
         <label for="phone">Phone:</label><br>
         <input type="text" id="phone" name="phone" placeholder="Enter phone" style="width:500px">
      </div>
      <div class="form-group">
         <label for="money_send">The amount of money you want to send:</label><br>
         <input type="text" id="money_send" name="monney_send" placeholder="Enter the money:" style="width:500px">
      </div>
      <div class="form-group">
         <label for="note">Note:</label><br>
         <input type="text" id="note" name="note" placeholder="Enter the note:" style="width:500px">
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