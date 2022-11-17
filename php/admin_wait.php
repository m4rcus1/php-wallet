<?php 
  $error='';
  function check_id($id){
    $Host='127.0.0.1';
    $user='root';
    $pass='';
    $db='onlinebanking';
 
                                                            
    $conn=new mysqli($Host,$user,$pass,$db) or die("unable to connect to");
    if ($conn->connect_error) {
        echo die("Connection failed: " . $conn->connect_error);
    }
    $r=	mysqli_query($conn,"SELECT id FROM wait_accept_transaction where id='$id'");
    if($r-> num_rows>0){
        return true;
    }
    else{
        return false;
    }
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
      $stm = $conn->prepare("insert into transaction_history(Phonnumber,type_of_transaction,money_of_transaction,date_transaction,note) values(?,?,?,?,?)");
      $t1='Send money';
      $today=date("Y-m-d h:i:sa");
      $note='card to wallet';
      $stm->bind_param('ssdss',$phone,$t1,$money,$today,$note);
      if ($stm->execute()) {
          return true;
      }
      return $stm->error;
  }
    if (isset($_POST['acc'])) {
      $acc =(int) $_POST['acc'];
      if (empty($acc)) {
         $error = 'Please enter the id';
      } else if (!check_id($acc)) {
         $error = 'Id is not exist';
      } else {
            if(isset($_POST['decide'])){
              $decide=$_POST['decide'];
              if(empty($_POST['decide'])){
                  $error='Input your decide';
              }else{
                    if($decide='Agree'){
                      $Host = '127.0.0.1';
                      $user = 'root';
                      $pass = '';
                      $db = 'onlinebanking';
                      $conn = new mysqli($Host, $user, $pass, $db) or die("unable to connect to");
                      if ($conn->connect_error) {
                        echo die("Connection failed: " . $conn->connect_error);
                      }
                      $sql =("SELECT * from wait_accept_transaction where id=$acc");
                      $r=	$conn->query($sql);
                      
                      $rows= mysqli_fetch_assoc($r);
                      print_r($rows);
                      if($rows['type_of_transaction']=='Send money'){
                                    $phone=$rows['vertex'];
                                    $sql="SELECT * FROM Money_card where Phonnumber='$phone'";
                                    $r=	$conn->query($sql);
                                    if($r-> num_rows>0){
                                        $rows= mysqli_fetch_assoc($r);
                                        $m1=$rows['surplus'];
                                        $m1=$m1-$money;
                                    
                                        $r1 = mysqli_query($conn, "UPDATE Money_card SET surplus='$m1' where Phonnumber='$phone'");
                                        $sql="SELECT * FROM Wallet where Phonenumber='$phone'";
                                        $r=	$conn->query($sql);
                                            
                                        $rows= mysqli_fetch_assoc($r);
                                        $m2=$rows['W_surplus'];
                                        $m2=$m2+$money;
                                        $r=mysqli_query($conn, "UPDATE Wallet SET W_surplus='$m2' WHERE Phonenumber='$phone'");
                                        add_tran($money);
                                        $r=mysqli_query($conn, "DELETE from wait_accept_transaction WHERE id='$acc");
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
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="admin1.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
 <div id="all"><center>
  <h1><center>ADMIN PAGE</center></h1>
    <div class="container">
      <form class="form-inline" method="post">
        <input class="form-control mr-sm-2" type="text" placeholder="Input the id of trac" id='acc' name='acc'>
        <input class="form-control mr-sm-2" type="text" placeholder="Agree or Disagree" id='decide' name='decide'>
        <div id="submit">
                <input type="submit" class="btn btn-primary" value="Register" id="submit1">
                <input class="btn btn-danger" type="reset" value="Reset">
        </div>
        <?php
      if ($error != "") {
         echo "<br><div class='alert alert-danger'><center>$error </center></div>";
      }
      ?>
      <br>
      <div class="table">
        <table>
         
          <tr>
          
                 <th>id</th>
                 <th>type of transaction</th>
                 <th>Send</th>
                 <th>Receipt</th>
                 <th>money</th>
                 <th>date</th>
                 <th>note</th>
                 
          </tr>
          <?php
             $Host='127.0.0.1';
             $user='root';
             $pass='';
             $db='onlinebanking';
         
                                                                     
             $conn=new mysqli($Host,$user,$pass,$db) or die("unable to connect to");
             if ($conn->connect_error) {
                 echo die("Connection failed: " . $conn->connect_error);
             }
             $sql="SELECT * FROM wait_accept_transaction";
             $r=	$conn->query($sql);
   
             foreach($r as $row) {
               //echo $row['column_name']; // Print a single column data
                 $a1='id';
         
                 $a2='type_of_transaction';
                 $a3='money_of_transaction';
                 $a4='date_transaction';
                 $a5='note';
                 $a6='source';
                 $a7='vertex';
                 echo "<tr><td>$row[$a1]</td>
                 <td>$row[$a2]</td>
                 <td>$row[$a6]</td>
                 <td>$row[$a7]</td>
                 <td>$row[$a3]</td>
                 <td>$row[$a4]</td>
                 <td>$row[$a5]</td>
                 </tr>"; 
                  // Print the entire row data
             }
           
             
          ?>
          
        </table>
      </div>
    </div>
    
  </div></center>
   </body>
</html>