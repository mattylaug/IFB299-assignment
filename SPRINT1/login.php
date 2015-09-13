
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
		
		<title>Login</title>
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
							
							<li class="menu-item"><a href="contact.php">Contact Us</a></li>
						</ul> <!-- .menu -->
					</nav> <!-- .main-navigation -->
					<div class="mobile-menu"></div>
				</div>
				
				<div style="float:right; position:relative;margin-top:-5.5%; margin-right:5%;">
					
					<a href="registration.php" class="btn btn-warning">Sign Up</a>

					
				</div>
				
			</header> <!-- .site-header -->
			
			<main class="main-content">
				<div class="fullwidth-block inner-content">
					<div class="container">
						<center><h2 class="page-title">Login Form</h2></center>
						<div class="row">
						<div class="col-md-3">
						</div>
							<div class="col-md-6">
							<center>
							<?php
							$message =@$_GET['message'];
							if(isset($message)) { ?>
							<div class="alert alert-danger alert-dismissible" role="alert">
							<?php echo $message; ?></div>
							<?php } ?>
							</center>
							<center>
							<?php
							$message1 =@$_GET['message1'];
							if(isset($message1)) { ?>
							<div class="alert alert-success alert-dismissible" role="alert">
							<?php echo $message1; ?></div>
							<?php } ?>
							</center>
								<form  action="abc.php" method="post" class="contact-form">
									
									<input type="email"  name="email" style="width:100%;"  placeholder="Email Address">
									<input type="password" name="password" style="width:100%;" placeholder="Password">
								
									<br>
													  
									<input type="submit" name="submit" value="Login">

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