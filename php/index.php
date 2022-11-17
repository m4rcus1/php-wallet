<?php
session_start();
if (!empty($_SESSION)) {

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
	$r=	mysqli_query($conn,"SELECT Phonenumber FROM Account where Phonenumber='$phone'");
	if($r-> num_rows>0){
		return true;
	}
	else{
		return false;
	}
}

function check_email($email){
	$Host='127.0.0.1';
	$user='root';
	$pass='';
	$db='onlinebanking';									
    $conn=new mysqli($Host,$user,$pass,$db) or die("unable to connect to");
    if ($conn->connect_error) {
        echo die("Connection failed: " . $conn->connect_error);
    }	
	$r=	mysqli_query($conn,"SELECT Email FROM Account where Email='$email'");
	if($r-> num_rows>0){
		return true;
	}
	else{
		return false;
	}
}
function add($phone,$email,$fullname,$birthday,$add,$pic1,$pic2)
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
    $stm = $conn->prepare("insert into Account(Phonenumber,Email,Fullname,Pass,Dateofbirth,Diachi,FP,PP,Sts) values(?,?,?,?,?,?,?,?,?)");
	$sts=0;
    $stm->bind_param('ssssssssd',$phone,$email,$fullname,$fullname,$birthday,$add,$pic1,$pic2,$sts);
    if ($stm->execute()) {
        return true;
    }
    return $stm->error;
}


$result='';
$error='';
function isimage($file){

	$extension = pathinfo($file, PATHINFO_EXTENSION);
	if($extension=="jpg" or $extension=="png")
		return true;
	return false;

}

if(isset($_POST['phone']))
{
    if(empty($_POST['phone'])){
        $error = 'Please enter your phone number';
    }
    else{
        $phone=$_POST['phone'];
        if(!preg_match("/^([0-9]{10})$/",$phone)){
			$error = 'Invalid phone number';
		}else if(check_phone($phone)){
			$error	="number have been registered";
		}
		else {
			if (isset($_POST['email']) ) {
				$email = $_POST['email'];
				if (empty($email)) {
					$error = 'Please enter your email';
				}
				else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
					$error = 'This is not a valid email address';
				}
				else if(check_email($email)){
					$error	="email have been registered";
				}
				else {
					if(isset($_POST['fn'])){
						$fullname=$_POST['fn'];
						if (empty($fullname)) {
							$error = 'Please enter your name';
						}
						else{
							if(isset($_POST['birthday'])){
										$birthday=$_POST['birthday'];
										if (empty($birthday)) {
											$error = 'Please enter your birthday';
										}else{
											if(isset($_POST['add'])){
												$add=$_POST['add'];
												if(empty($add)){
													$error = 'Please enter your address';
												}else{
													echo 1;
													if(isset($_POST['pic1'])){
														
														$pic1=$_POST['pic1'];
														if (empty($pic1)) {
															$error = 'input your pic1';
														}else if(!isimage($pic1)){
															$error = 'input wrong type';
														}
														else{
															if(isset($_POST['pic2'])){
																$pic2=$_POST['pic2'];
																if (empty($pic2)) {
																	$error = 'input your pic2';
																}else if(isimage($pic2)===false){
																	$error = 'input wrong type';
																}else{
																	$_SESSION['phone']=$phone;
																	$_SESSION['email']=$email;
																	$_SESSION['fullname']=$fullname;
																	$_SESSION['password']=$fullname;
																	$_SESSION['birthday']=$birthday;
																	$_SESSION['add']=$add;
																	$_SESSION['pic1']=$_POST['pic1'];
																	$_SESSION['pic2']=$_POST['pic2'];
																	$_SESSION['sts']=0;
																	add($phone,$email,$fullname,$birthday,$add,$pic1,$pic2);
																	echo '<script>alert("Successful");
																	window.location="change.php";
																	</script>'; 
																
																}
															}
														}
													}
												}
											}
											
										}
									}
								
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
	<link rel="stylesheet" href="index.css"> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<title>ví điện tử</title>
</head>

<body>

	<div class="container">
		<!-- <img id='image1' src="/images/tdt-logo.png" /> -->
		<h1 align="center">Đăng ký vào ví điện tử</h1>
		<div class="main">
			<form id="main" method="post" >
				<div class="form-group">
					<label for="phone">Phone number:</label>
					<input type="tel" class="form-control" placeholder="Enter your phone number" id="phone" name="phone" 
					value="<?php if(isset($_POST['phone']) and $_POST['phone']!=''){ echo $phone;}?>" style="width:500px">
				</div>
				<div class="form-group">
					<label for="email">Email address:</label>
					<input type="email" class="form-control" placeholder="Enter email" id="email" name="email"
					 value="<?php if(isset($_POST['email'])and $_POST['email']!=''){ echo $_POST['email'];}?>"style="width:500px">
				</div>
				<div class="form-group">
					<label for="fn">Full name:</label>
					<input type="text" class="form-control" placeholder="full name" id="fn" name="fn"
					value="<?php if(isset($_POST['fn'])and $_POST['fn']!=''){ echo $fullname;}?>"
					 style="width:500px">
				</div>
				<div class="form-group">
					<label for="birthday">Birthday:</label><br>
					<input type="date" id="birthday" name="birthday" 
					value="<?php if(isset($_POST['birthday'])and $_POST['birthday']!=''){ echo $birthday;}?>"
					style="width:500px">
				</div>
				<div class="form-group">
					<label for="add">Address:</label><br>
					<input type="text" id="add" name="add"  placeholder="Enter your Address"
					value="<?php if(isset($_POST['add'])and $_POST['add']!=''){ echo $add;}?>"
					style="width:500px">
				</div>
				<div class="form-group">
					<label for="pic1">Upload your front face of your identity card</label>
					<input type="file" name="pic1" id="pic1"><br>
				</div>
				<div class="form-group">
					<label for="pic1">Upload your backside face of your identity card</label>
					<input type="file" name="pic2" id="pic2">
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
				<center><a href='login.php'>Click here if you already have account </a></center>
				<!-- <div class="form-group form-check">
					<label class="form-check-label">
						<input class="form-check-input" type="checkbox"> Remember me
					</label>
				</div> -->
			</form>

		</div>

	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="/main.js"></script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
</body>

</html>