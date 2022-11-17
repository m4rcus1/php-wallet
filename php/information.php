<?php 
    session_start();
    $error = '';


    
    if (empty($_SESSION)) {
       session_destroy();
       echo '<script>
                        window.location="index.php";
                </script>';
       
    }
    $phone=$_SESSION['phone'];
    $name=$_SESSION['fullname'];
    $pic1=$_SESSION['pic1'];
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="infor.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Customer's information</title>
</head>
<body>
<div class="container">
		<!-- <img id='image1' src="/images/tdt-logo.png" /> -->
		<h1 align="center">Information</h1>
		<center><div class="main">
			<form id="main" method="post" enctype='multipart/form-data'>
				<div class="form-group">
					<label for="phone">Phone number:</label>
					<input type="tel" class="form-control" placeholder="Enter your phone number" id="phone" name="phone" 
					value="<?php echo $_SESSION['phone']?>" style="width:500px">
				</div>
				<div class="form-group">
					<label for="email">Email address:</label>
					<input type="email" class="form-control" placeholder="Enter email" id="email" name="email"
          value="<?php echo $_SESSION['email']?>"style="width:500px">
				</div>
				<div class="form-group">
					<label for="fn">Full name:</label>
					<input type="text" class="form-control" placeholder="full name" id="fn" name="fn"
					value="<?php echo $_SESSION['fullname']?>"
					 style="width:500px">
				</div>
				<div class="form-group">
					<label for="add">Address:</label><br>
					<input type="text" id="add" name="add"  placeholder="Enter your Address"
					value="<?php echo $_SESSION['add']?>"
					style="width:500px">
				</div>
		
				<?php
						if ($error != "") {
								echo "<br><div class='alert alert-danger'><center>$error </center></div>";
						}
				?>
		
			</form>

		</div></center>

	</div>
</body>
</html>