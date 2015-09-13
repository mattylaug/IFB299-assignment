
<?php
if(count($_POST)>0) {
	/* Form Required Field Validation */
	foreach($_POST as $key=>$value) {
	if(empty($_POST[$key])) {
	$message = ucwords($key) . " field is required";
	break;
	}
	}
	/* Password Matching Validation */
	if($_POST['password'] != $_POST['confirm_password']){ 
	$message = 'Passwords should be same<br>'; 
	}

	/* Email Validation */
	if(!isset($message)) {
	if (!filter_var($_POST["userEmail"], FILTER_VALIDATE_EMAIL)) {
	$message = "Invalid UserEmail";
	}
	}
	

	/* Validation to check if Terms and Conditions are accepted */
	if(!isset($message)) {
	if(!isset($_POST["terms"])) {
	$message = "Accept Terms and conditions before submit";
	}
	}

	if(!isset($message)) {
		require_once("dbcontroller.php");
		$db_handle = new DBController();
		$query = "SELECT * FROM registered_users where email = '" . $_POST["userEmail"] . "'";
		$count = $db_handle->numRows($query);
		
		if($count==0) {
			$query = "INSERT INTO registered_users (first_name, last_name, password ,email) VALUES
			('" . $_POST["firstName"] . "', '" . $_POST["lastName"] . "', '" . md5($_POST["password"]) . "', '" . $_POST["userEmail"] . "')";
			$current_id = $db_handle->insertQuery($query);
			if(!empty($current_id)) {
				$actual_link = "http://$_SERVER[HTTP_HOST]/"."activate.php?id=" . $current_id;
				$toEmail = $_POST["userEmail"];
				$subject = "Faypol Account Activation Email";
				$content = "Click this link to activate your account. <a>" . $actual_link . "</a>";
				$mailHeaders = "From:Faypol\r\n";
				if(mail($toEmail, $subject, $content, $mailHeaders)) {
				header("Location:login.php?message1=You have been registered successfully.Login below to continue...");
				}
				unset($_POST);
			} else {
				$message = "Problem in registration. Try Again!";	
			}
		} else {
			$message = "User Email is already in use.";	
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
		
		<title>Register</title>
		<link rel="stylesheet" href="bootstrap.css">
		<!-- Loading third party fonts -->
		<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,900" rel="stylesheet" type="text/css">
		<link href="fonts/font-awesome.min.css" rel="stylesheet" type="text/css">
		<!-- Loading main css file -->
		<link rel="stylesheet" href="style.css">

		<!--[if lt IE 9]>
		<script src="js/ie-support/html5.js"></script>
		<script src="js/ie-support/respond.js"></script>
		<![endif]-->

	</head>

	<body>
		
		<div id="site-content">
			<header class="site-header">
				<div class="container">
					<a href="index.html" id="branding">
						<img src="dummy/logo.png" alt="Site Title">
						<small class="site-description">Slogan goes here</small>
					</a> <!-- #branding -->
					
					<nav class="main-navigation">
						<button type="button" class="toggle-menu"><i class="fa fa-bars"></i></button>
						<ul class="menu">
							<li class="menu-item"><a href="index.php">Home</a></li>
							<li class="menu-item"><a href="contact.php">Contact</a></li>
						</ul> <!-- .menu -->
					</nav> <!-- .main-navigation -->
					<div class="mobile-menu"></div>
				</div>
				
				<div style="float:right; position:relative;margin-top:-5.5%; margin-right:5%;">
					
					<a href="login.php" class="btn btn-warning">Login</a> 

					
				</div>
			</header> <!-- .site-header -->
			
							<?php if(isset($message)) { ?>
							<div class="alert alert-danger alert-dismissible" role="alert" style="width:400px; margin-left:27px;">
							<?php echo $message; ?></div>
							<?php } ?>
							
							<?php if(isset($message1)) { ?>
							<div class="alert alert-success alert-dismissible" role="alert" style="width:400px; margin-left:27px;">
							<?php echo $message1; ?></div>
							<?php } ?>
							
			<main class="main-content">
				<div class="fullwidth-block inner-content">
					<div class="container">
						<center><h2 class="page-title">Registration</h2></center>
						<div class="row">
						<div class="col-md-3">
						</div>
							<div class="col-md-6">
								<form  name="frmRegistration" action="" method="post" class="contact-form">
									<input type="text" name="firstName" style="width:100%;" placeholder="Your First name">
									<input type="text"  name="lastName" style="width:100%;" placeholder="Your Last name">
									<input type="email"  name="userEmail" style="width:100%;"  placeholder="Email Address">
									<input type="password" name="password"  style="width:100%;" placeholder="Password">
									<input type="password"  name="confirm_password" style="width:100%;" placeholder="Confirm Password">
								
									<br>
													  
									<input type="checkbox" name="terms"  style="float:left;"><p style="margin-top:-1.4%; margin-left:5%;">I accept the terms of services and <a href="" style="color:#fd5927; text-decoration:none;">privacy policy</a></p>
									<input type="submit"  value="Register">

								</form>
							</div>
							
						</div>
					</div>
				</div> <!-- .testimonial-section -->

				
			</main> <!-- .main-content -->

			<footer class="site-footer">
				<div class="container">
					<img src="dummy/logo-footer.png" alt="Site Name">
					
QUT
					
					<form action="#" class="newsletter-form">
						<input type="email" placeholder="Enter your email to join newsletter...">
						<input type="submit" class="button cut-corner" value="Subscribe">
					</form> <!-- .newsletter-form -->
					
					<div class="social-links">
						<a href="#"><i class="fa fa-facebook-square"></i></a>
						<a href="#"><i class="fa fa-twitter"></i></a>
						<a href="#"><i class="fa fa-google-plus"></i></a>
						<a href="#"><i class="fa fa-pinterest"></i></a>
					</div> <!-- .social-links -->
					
					<p class="copy">LENNYFACE</p>
				</div>
			</footer> <!-- .site-footer -->

		</div> <!-- #site-content -->

		<script src="js/jquery-1.11.1.min.js"></script>	
		QUT
		<script src="js/plugins.js"></script>
		<script src="js/app.js"></script>
		
	</body>

</html>