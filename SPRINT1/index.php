<?php
session_start();
include 'db.php';
$id = @$_SESSION['id'];
$name = @$_SESSION['name'];
$email = @$_SESSION['email'];
$banned = @$_SESSION['banned'];
$sql = mysql_query("SELECT status,banned FROM registered_users WHERE user_id ='$id'");

$row = mysql_fetch_array($sql);
			
		$status = $row['status'];
		$banned = $row['banned'];
		
		if($status === 'Inactive')
			 
				 {
						$message = "Please activate your account, An activation link is sent to <b>$email</b>";
				}
			else if($banned === '1')
			 
				 {
						$message = "Your account has been blocked due to violation of terms and services";
				 }
			else
				 {
				// Do Nothing
				}




?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
		
		<title>Home</title>
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
	<center>
		<?php if(isset($message)) { ?>
							<div class="alert alert-danger alert-dismissible" role="alert" style=" position: fixed; z-index: 1;   width:100%">
							<?php echo $message; ?></div>
							<br><br>
							<?php } ?>
							
		</center>
		
		<div id="site-content">
		
			<header class="site-header">
				<div class="container" >
					<a href="index.html" id="branding">
						<img src="dummy/logo.png" alt="Site Title">
						<small class="site-description">Slogan goes here</small>
					</a> <!-- #branding -->
					
					<nav class="main-navigation">
						<button type="button" class="toggle-menu"><i class="fa fa-bars"></i></button>
						<ul class="menu">
						
							<li class="menu-item current-menu-item"><a href="index.php">Home</a></li>
							
							
							
							
							
							<?php
							if(isset($_SESSION['id']))
							{
							?>
							<li class="menu-item"><a href="download.php">Audio</a></li>
							<li class="menu-item"><a href="blog.php">Videos</a></li>
							<li class="menu-item"><a href="about.php">Ebooks</a></li>
							<li class="menu-item"><a href="gallery.php">Gallery</a></li>
							
							<?php
							}
							else{}
							?>
							
							<li class="menu-item"><a href="contact.php">Contact Us</a></li>
						</ul> <!-- .menu -->
						
					
						
					</nav> <!-- .main-navigation -->
				
					<div class="mobile-menu"></div>
					
					
					
				</div>
				<?php
				if(isset($_SESSION['id']))
				{
				?>
				
				<div style="float:right; position:relative;margin-top:-5.5%; margin-right:5%;">
					
					<a href="logout.php" class="btn btn-warning">Logout</a> 

					
				</div>
				<?php
				
				}
				else{
				
				?>
				<div style="float:right; position:relative;margin-top:-5.5%; margin-right:5%;">
					
					<a href="login.php" class="btn btn-warning">Login</a> 
					<a href="registration.php" class="btn btn-warning">Sign Up</a>

					
					</div>
				<?php
				}
				?>
			</header> <!-- .site-header -->
			
			<div class="hero" >
				<div class="slider">
					<ul class="slides">
						<li class="lazy-bg" data-background="dummy/slide-1.jpg">
							<div class="container">
								<h2 class="slide-title">Header goes here</h2>
								<h3 class="slide-subtitle">Less important text goes here</h3>
								<p class="slide-desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br>Fugiat aliquid minus nemo sed est.</p>

								<a href="#" class="button cut-corner">Read More</a>
							</div>
						</li>
						<li class="lazy-bg" data-background="dummy/slide-2.jpg">
							<div class="container">
									<h2 class="slide-title">Header goes here</h2>
									<h3 class="slide-subtitle">Less important text goes here</h3>
									<p class="slide-desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br>Fugiat aliquid minus nemo sed est.</p>

									<a href="#" class="button cut-corner">Read More</a>
							</div>
						</li>
						<li class="lazy-bg" data-background="dummy/slide-3.jpg">
							<div class="container">
									<h2 class="slide-title">Header goes here</h2>
									<h3 class="slide-subtitle">Less important text goes here</h3>
									<p class="slide-desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br>Fugiat aliquid minus nemo sed est.</p>

									<a href="#" class="button cut-corner">Read More</a>
							</div>
						</li>
					</ul>
				</div>
			</div>
			
			<main class="main-content">
				<div class="fullwidth-block testimonial-section">
					<div class="container">
						<div class="quote-slider">
							<ul class="slides">
								<li>
									<blockquote>
										<p>"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium totam rem aperiam eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo"</p>
										<cite>John Smith</cite>
										<span>Corporation CEO, books author</span>
									</blockquote>
								</li>
								<li>
									<blockquote>
										<p>"Iste natus error sit voluptatem accusantium doloremque laudantium totam rem aperiam eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo"</p>
										<cite>John Smith</cite>
										<span>Corporation CEO, books author</span>
									</blockquote>
								</li>
							</ul>
						</div>
					</div>
				</div> <!-- .testimonial-section -->


				<div class="fullwidth-block why-chooseus-section">
					<div class="container">
						<h2 class="section-title">Why choose us?</h2>

						<div class="row">
							<div class="col-md-4">
								<div class="feature">
									<figure class="cut-corner">
										<img src="dummy/medium-image-1.jpg" alt="">
									</figure>
									<h3 class="feature-title">Similique sunt in culpa qui officia deserunt mollitia animi laborum dolorum</h3>
									<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident.</p>
								</div> <!-- .feature -->
							</div>
							<div class="col-md-4">
								<div class="feature">
									<figure class="cut-corner">
										<img src="dummy/medium-image-2.jpg" alt="">
									</figure>
									<h3 class="feature-title">Similique sunt in culpa qui officia deserunt mollitia animi laborum dolorum</h3>
									<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident.</p>
								</div> <!-- .feature -->
							</div>
							<div class="col-md-4">
								<div class="feature">
									<figure class="cut-corner">
										<img src="dummy/medium-image-3.jpg" alt="">
									</figure>
									<h3 class="feature-title">Similique sunt in culpa qui officia deserunt mollitia animi laborum dolorum</h3>
									<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident.</p>
								</div> <!-- .feature -->
							</div>
						</div>
					</div> <!-- .container -->
				</div> <!-- .why-chooseus-section -->
			</main> <!-- .main-content -->

			<footer class="site-footer">
				<div class="container">
					<img src="dummy/logo-footer.png" alt="Site Name">
				
					
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
		<script src="js/plugins.js"></script>
		<script src="js/app.js"></script>
		
	</body>

</html>