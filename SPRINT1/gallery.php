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
		
		<title>Gallery</title>
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
				<div class="container">
					<a href="index.html" id="branding">
						<img src="dummy/logo.png" alt="Site Title">
						<small class="site-description">Slogan goes here</small>
					</a> <!-- #branding -->
					
						<nav class="main-navigation">
						<button type="button" class="toggle-menu"><i class="fa fa-bars"></i></button>
						<ul class="menu">
						
							<li class="menu-item"><a href="index.php">Home</a></li>
							
							
							
							
							
							<?php
							if(isset($_SESSION['id']))
							{
							?>
							<li class="menu-item"><a href="download.php">Audio</a></li>
							<li class="menu-item"><a href="blog.php">Videos</a></li>
							<li class="menu-item"><a href="about.php">Ebooks</a></li>
							<li class="menu-item current-menu-item"><a href="gallery.php">Gallery</a></li>
							<?php
							}
							else{}
							?>
							
							<li class="menu-item"><a href="contact.php">Contact Us</a></li>
						</ul> <!-- .menu -->
						
					
						
					</nav> <!-- .main-navigation -->
					
					<div class="mobile-menu"></div>
				</div>
				
				<div style="float:right; position:relative;margin-top:-5.5%; margin-right:5%;">
					
					<a href="logout.php" class="btn btn-warning">Logout</a> 

					
				</div>
				
			</header> <!-- .site-header -->
			
						<br>
			<!-- .site-header -->
			
		<?php
		
		$sql = mysql_query("SELECT banned FROM registered_users WHERE user_id ='$id'");

		$row = mysql_fetch_array($sql);
			
		$banned = $row['banned'];
		if($banned === '1')
			 
				 {	
		?>
		<div class="row">
		<div class="col-md-4">	
		</div>	
		<div class="col-md-4">
		
			<center>
		<div class="alert alert-danger alert-dismissible" role="alert">
		<?php echo "You are not allowed to upload any media."; ?></div>
			</center>
			
		</div>
		</div>			
							
		<?php
		}
		else
		{
		?>		
			
			
		<div class="row">
<div class="col-md-3">	
</div>	
<div class="col-md-6">
<h2 class="page-title">Upload Images</h2>	
							<center>
							<?php
							$message1 =@$_GET['message1'];
							if(isset($message1)) { ?>
							<div class="alert alert-danger alert-dismissible" role="alert">
							<?php echo $message1; ?></div>
							<?php } ?>
							</center>
							<center>
							<?php
							$message =@$_GET['message'];
							if(isset($message)) { ?>
							<div class="alert alert-success alert-dismissible" role="alert">
							<?php echo $message; ?></div>
							<?php } ?>
							</center>

	<form name="add_ref"  action="upload_image.php" method="post"  class="contact-form" enctype="multipart/form-data">
	<input name="name" id="" style="width:100%;" type="text" placeholder="Enter Name"/>

	<input  type="file" name="ref_img"  type="text"  style="width:100%;" id="audio_file"/>
	<input type="submit" name="Submit"  id="Submit" value="Upload"/>
	</form>
	</div>	
	</div>	
	<?php
	}
	?>	
			
			<br><br>
			
			<main class="main-content">
				<div class="fullwidth-block gallery">
					<div class="container">
						<div class="content fullwidth">
							<h2 class="entry-title">Gallery</h2>
						
							<div class="filterable-items">
							<?php
							
							$query = mysql_query("SELECT * FROM media where banned=0 AND (data_type='.png' || data_type='.jpg' || data_type='.bmp') and user_id = '".$_SESSION['id']."'");
									while ($row = mysql_fetch_array($query))
									{
									$name = $row['name'];
									$link = $row['data_link'];
									
							?>
							
							
							
								<div class="filterable-item concert">
								    <a href="<?php echo $link; ?>"><figure><img src="<?php echo $link; ?>" alt="<?php echo $name;?>"></figure></a>
									<br/><a  class="btn btn-warning"  href="delete.php?id=<?php echo $row['media_id'];?>&page=images">Delete</a>
									
                                    
                                    
								</div>
								
								<?php
								}
								?>
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
		<script src="js/plugins.js"></script>
		<script src="js/app.js"></script>
		
	</body>

</html>