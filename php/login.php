<?php 
    session_start();
   
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
    if(!isset($_SESSION['count'])){
        $_SESSION['count']=0;                
    }
    $Host='127.0.0.1';
	$user='root';
	$pass='';
	$db='onlinebanking';
    $error='';														
    $conn=new mysqli($Host,$user,$pass,$db) or die("unable to connect to");
    if ($conn->connect_error) {
        echo die("Connection failed: " . $conn->connect_error);
    }
    if(isset($_POST['phone'])){
        if(empty($_POST['phone'])){
            $error = 'Please enter your phone number';
        }else{
            $phone=$_POST['phone'];
            $pass=$_POST['pwd'];
            if(check_phone($phone)==False){
                $error='ban chua dky';
            }else{
                $sql="SELECT * FROM Account where Phonenumber='$phone'";
                $r=	$conn->query($sql);
                if($r-> num_rows>0){
                    $rows= mysqli_fetch_assoc($r);
                    $phone1=$rows['Phonenumber'];
                    $pass_c=$rows['Pass'];
                    if($pass!=$pass_c){
                        $_SESSION['count']+=1;
                        $error='Wrong pass';
                    }else{
                        $_SESSION['phone']=$phone1;
						$_SESSION['email']=$rows['Email'];
						$_SESSION['fullname']=$rows['Fullname'];
						$_SESSION['password']=$pass_c;
						$_SESSION['birthday']=$rows['Dateofbirth'];
						$_SESSION['add']=$rows['Diachi'];
						$_SESSION['pic1']=$rows['FP'];
						$_SESSION['pic2']=$rows['PP'];
                        $_SESSION['sts']=$rows['sts'];
                        echo '<script>
								window.location="main.php";
						</script>';
                    }
                }
                else{
                    
                    echo "false";
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
    <link rel="stylesheet" href="login.css">
    <title>Log in</title>
</head>
<body>
<form name="loginForm" method="post" >
<table width="500" height="200"bgcolor="586597" align="center">

<tr>
<td colspan=2><center><font size=6><b>LOG IN</b></font></center></td>
</tr>

<tr>
<td>Phonenumber:</td>
<td><input type="text" placeholder="Please enter your mobile phone" size=50 name="phone" id="phone"></td>
</tr>

<tr>
<td>Password:</td>
<td><input type="Password" placeholder="Please enter your password" size=50 name="pwd" id="pwd"></td>
</tr>

<tr>
    <td colspan="2" aligin="center">
        <input type="submit" name="nopform" value="Submit">
        <input type="reset" name="datlai" value="Reset">
        
    </td>
    <?php
				if ($error != "") {
					echo "<br><div class='alert alert-danger'><center>$error </center></div>";
				}
				?>
</tr>

</table>
</form>
</body>
</html>