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
       
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css
" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css
">
    <link rel="stylesheet" href="transactionhistoryall.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js
"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js
"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js
"></script>
<link rel="stylesheet" href="3.css">
    <title>Transaction history</title>
</head>
<body><center>
 <div id="all"><center>
  <h1><center>Transaction History</center></h1>
    <div class="container">
      
      <table border="1">
        <tr>
            <th>Transaction form</th>
            <th>Money</th>
            <th>Time/Date</th>
            <th>Note</th>
            
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
             $sql="SELECT * FROM transaction_history ORDER BY date_transaction DESC;";
             $r=	$conn->query($sql);
            
             foreach($r as $row) {
               //echo $row['column_name']; // Print a single column data
               $c1='type_of_transaction';
               $c2='money_of_transaction';
               $c3='date_transaction';
               $c4='note';
               echo "<tr><th>$row[$c1]</th>
                   <th>$row[$c2]</th>
                   <th>$row[$c3]</th>
                   <th>$row[$c4]</th></tr>";       // Print the entire row data
             }
          ?>
          
        </table>
      </div>
    </div>
  
  </div></center>
  </center></body>
   </html>