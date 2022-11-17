<?php 
  $error='';
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
  function check_sts($phone){
    $Host='127.0.0.1';
    $user='root';
    $pass='';
    $db='onlinebanking';
 
                                                            
    $conn=new mysqli($Host,$user,$pass,$db) or die("unable to connect to");
    if ($conn->connect_error) {
        echo die("Connection failed: " . $conn->connect_error);
    }
    $r=	mysqli_query($conn,"SELECT sts FROM Account where Phonenumber='$phone'");
    foreach($r as $row){
      echo $row['sts'];
      if ($row['sts']>1){
        return false;
      }
      return true;
    }
   
  }
    if (isset($_POST['active'])) {
      $active = $_POST['active'];
      if (empty($active)) {
         $error = 'Please enter the phone with you need to active';
      } else if (!check_phone($active)) {
         $error = 'Phone is not exist';
      } else if(!check_sts($active)){
        $error = 'this account have been active before';
      }else {
            $Host = '127.0.0.1';
            $user = 'root';
            $pass = '';
            $db = 'onlinebanking';
            $conn = new mysqli($Host, $user, $pass, $db) or die("unable to connect to");
            if ($conn->connect_error) {
               echo die("Connection failed: " . $conn->connect_error);
            }
            $sts=2;
            $r =("UPDATE Account SET sts='$sts' WHERE  Phonenumber ='$active'");
            if ($conn->query($r) === TRUE){
          
                echo '<script>alert("Successful")</script>';}
      }
    }
    if (isset($_POST['delete'])) {
      $delete = $_POST['delete'];
      if (empty($delete)) {
         $error = 'Please enter the phone with you need to delete';
      } else if (!check_phone($delete)) {
         $error = 'Phone is not exist';
      }else {
            $Host = '127.0.0.1';
            $user = 'root';
            $pass = '';
            $db = 'onlinebanking';
            $conn = new mysqli($Host, $user, $pass, $db) or die("unable to connect to");
            if ($conn->connect_error) {
               echo die("Connection failed: " . $conn->connect_error);
            }
            $sts=2;
            $r=("DELETE from Account where Phonenumber ='$delete'");
       
            if ($conn->query($r) === TRUE){
          
                echo '<script>alert("Successful")</script>';}
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
        <input class="form-control mr-sm-2" type="text" placeholder="Input the the phone number to active the new account" id='active' name='active'>
        <div id="submit">
                <input type="submit" class="btn btn-primary" value="Register" id="submit1">
                <input class="btn btn-danger" type="reset" value="Reset">
        </div>
     
      <br>
      <div class="table">
        <table>
         
          <tr>
                 <th>Phonenumber</th>
                 <th>Email</th>
                 <th>Full name</th>
                 <th>Date of birth</th>
                 <th>Address</th>
                 <th>Status of account</th>
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
             $sql="SELECT * FROM Account";
             $r=	$conn->query($sql);
   
             foreach($r as $row) {
               //echo $row['column_name']; // Print a single column data
                 $a1='Phonenumber';
                 $a2='Email';
                 $a3='Fullname';
                 $a4='Dateofbirth';
                 $a5='Diachi';
                 $a6='sts';
         
                 if($row[$a6]==2){
                 echo "<tr><th>$row[$a1]</th>
                 <td>$row[$a2]</td>
                 <td>$row[$a3]</td>
                 <td>$row[$a4]</td>
                 <td>$row[$a5]</td>
                 <td>$row[$a6]</td></tr>"; 
                }    // Print the entire row data
             }
           
             
          ?>
          
        </table>
      </div>
    </div>

  </div></center>
   </body>
</html>