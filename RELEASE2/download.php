<?php
	session_start();
	include 'db.php';
	$id = @$_SESSION['id'];
	$name = @$_SESSION['name'];
	$email = @$_SESSION['email'];
	$banned = @$_SESSION['banned'];
	$sql = mysql_query("SELECT status,banned FROM registered_users WHERE user_id ='$id'");
	$page = 'audio';
	
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
		
		<title>Audio</title>
		<!-- Loading third party fonts -->
		<link rel="stylesheet" href="assets/css/bootstrap.css">
		
		<link href="assets/css/custom.css" rel="stylesheet" />
		<!-- GOOGLE FONTS-->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
		<!-- TABLE STYLES-->
		<link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
		
		
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
								<li class="menu-item current-menu-item"><a href="download.php">Audio</a></li>
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
				
				<div style="float:right; position:relative;margin-top:-5.5%; margin-right:5%;">
					
					<a href="logout.php" class="btn btn-warning">Logout</a> 
					
					
				</div>
				
			</header> 
			
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
						<h2 class="page-title">Upload Audio</h2>	
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
						
						<form name="audio_form" id="audio_form" action="upload_mp3.php" method="post"  class="contact-form" enctype="multipart/form-data">
							<input name="name" id="" style="width:100%;" type="text" placeholder="Enter Name"/>
							
							<input  type="file" name="audio_file"  type="text"  style="width:100%;" id="audio_file"/>
							<input type="submit" name="Submit"  id="Submit" value="Upload"/>
						</form>
					</div>	
				</div>	
				<?php
				}
			?>	
			
			<br><br>
			
			<div class="row">
				<div class="col-md-2">
				</div>
                <div class="col-md-8">
					<center><h2 class="page-title">Audio Library</h2></center>	
					
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
							Audio List
						</div>
						
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Size</th>
                                            <th>Type</th>
                                            <th>Play</th>
                                            <th>Download</th>
											<th>Delete</th>
										</tr>
									</thead>
                                    <tbody>
										<?php
											
											$query = mysql_query("select * from media where data_type ='.mp3' and banned = '0' and user_id = '".$_SESSION['id']."'");
											while ($row = mysql_fetch_array($query))
											{
												$name = $row['name'];
												$size = $row['data_size'];
												$type = $row['data_type'];
												$data_link = $row['data_link'];
												
											?>
											<tr class="odd gradeX">
												<td><?php echo $name;?></td>
												<td><?php echo $size;?>Mb</td>
												<td>mp3</td>
												<td class="center"><a target="_blank"href="play_mp3.php?id=<?php echo $data_link; ?>" class="btn btn-warning">Play</a></td>
												
												<?php
													$check_size = mysql_query("select data_downloaded from registered_users where user_id='$id'");
													while ($row1 = mysql_fetch_array($check_size)){
														$data_downloaded=$row1['data_downloaded'];
													}
													$total_data=$data_downloaded+$size;
													if($banned=='1'){
													?>
													<td class="center">You are banned.Can't download.</td>
													<?php
													}
													else if($status == 'Inactive' && $total_data>10){
														
													?>
													<td class="center">Your download limit exceeds.</td>
													<?php
														
													}
													else{
													?>
													<td class="center"><a target="_blank"  class="btn btn-warning" on_click='' href="<?php echo $data_link;?>" download>Download</a></td>
													<td><a  class="btn btn-warning"  href="delete.php?id=<?php echo $row['media_id'];?>&page=mp3">Delete</a></td>
													<?php
													}
													
												?>
												
											</tr>
											
											<?php
												
											}
										?>
									</tbody>
								</table>
							</div>
							
						</div>
					</div>
					<!--End Advanced Tables -->
				</div>
			</div>
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
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
		
		<script src="assets/js/jquery-1.10.2.js"></script>
		<!-- BOOTSTRAP SCRIPTS -->
		<script src="assets/js/bootstrap.min.js"></script>
		<!-- METISMENU SCRIPTS -->
		<script src="assets/js/jquery.metisMenu.js"></script>
		<!-- DATA TABLE SCRIPTS -->
		<script src="assets/js/dataTables/jquery.dataTables.js"></script>
		<script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
		<script>
			$(document).ready(function () {
				$('#dataTables-example').dataTable();
			});
		</script>
		<!-- CUSTOM SCRIPTS -->
		<script src="assets/js/custom.js"></script>
		
	</body>
	
</html>																													