<?php
	error_reporting(0);
	session_start();
	include 'db.php';
	$id = @$_SESSION['id'];
	$name = @$_SESSION['name'];
	$email = @$_SESSION['email'];
	$sql = mysql_query("SELECT status FROM registered_users WHERE user_id ='$id'");
	
	$row = mysql_fetch_array($sql);
	
	$status = $row['status'];
	if($status === 'Inactive')
	
	{
		$message = "Please activate your account, An activation link is sent to <b>$email</b>";
	}
	else
	{
		// Do Nothing
	}
?>
<?php 
	if(isset($_FILES['text_file']['name'])){
		$folder_path = "book/";
		$length = 15;
		$randomString = time();
		$ext = new SplFileInfo($_FILES['text_file']['name']);
		$ext = pathinfo($ext, PATHINFO_EXTENSION);
		$file_name = $randomString . "_" . rand().".".$ext;
		move_uploaded_file($_FILES["text_file"]["tmp_name"], $folder_path . $file_name);	
		}else {
		$file_name = '1424160670_3697.pdf';
	}
	$query=mysql_query("INSERT INTO `e_books`( `book_name`,
	`author_name`, 
	`description`,
	`book_path_name`, 
	`upload_date`) 
	VALUES ('".addslashes($_POST['book_name'])."',
	'".addslashes($_POST['book_author'])."',
	'".addslashes($_POST['description'])."',
	'".addslashes($file_name)."',
	'".date('Y-m-d')."'
	)");
	
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
		
		<title>Ebooks</title>
		
		<link rel="stylesheet" href="bootstrap.css">
		
		<!-- Loading third party fonts -->
		<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,900" rel="stylesheet" type="text/css">
		<link href="fonts/font-awesome.min.css" rel="stylesheet" type="text/css">
		<!-- Loading main css file -->
		<link rel="stylesheet" href="style.css">
		
		<style type="text/css">
			
			.discography-list li{
			width: 40%;
			float: left;
			margin-left: 3em;
		}</style>
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
								<li class="menu-item current-menu-item"><a href="about.php">Ebooks</a></li>
								<li class="menu-item"><a href="gallery.php">Gallery</a></li>
								<li class="menu-item"><a href="profile.php">My Profile</a></li>
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
			
			<main class="main-content">
				<div class="fullwidth-block inner-content">
					<div class="container">
						<div class="row">
							<div class="col-md-7">
								<div class="content">
									<form action=""  method="post" id="book_form" enctype="multipart/form-data">
										<h2 class="entry-title">Digital Library</h2>
										<div class="form-group">
											<label class="col-md-3 control-label">Book Name</label>
											<div class="col-md-9"><input class="form-control" type="text" name="book_name" id="book_name" placeholder="Book Name">
											</div>
										</div>
										
										<div class="form-group" style="margin-top:5em">
											<label class="col-md-3 control-label">Book Author</label>
											<div class="col-md-9"><input class="form-control" type="text" name="book_author" id="book_author" placeholder="Book Author">
											</div>
										</div>
										
										<div class="form-group" style="margin-top:8em">
											<label class="col-md-3 control-label">About Book</label>
											<div class="col-md-9"><textarea class="form-control" type="text" name="description" id="description" data-placeholder="Book Author">
											</textarea>
											</div>
										</div>
										
										<div class="form-group"style="margin-top:14em">
											<label class="col-md-3 control-label">Upload File:</label>
											<div class="col-md-9"><input class="form-control col-md-9 btn-primary" type="file" style="height:3em" name="text_file" id="text_file" >
												<input class="col-md-3 btn btn-success form-control" type="submit" style="height:3em" value="save" name="save_file" id="save_file"> 
											</div>
										</div>
									</form>
									<form method="post" action="">
										<h2 class="entry-title" style="text-align:center;margin-top:8em">Search Book</h2>
										<div class="form-group">
											<label class="col-md-2 control-label">Book Name</label>
											<div class="col-md-10"><input class=" col-md-10 form-control" type="text" name="search_book_name" id="search_book_name" placeholder="Book Name">
												<input class=" col-md-2 form-control btn btn-primary" type="submit" name="search" id="search" value="search">
											</div>
										</div>
										
									</form>
									
									<h2 class="widget-title" style="margin-top:2em">Book List</h2>
									<ul class="discography-list">
										<?PHP 
											if(isset($_POST['search_book_name'])){
												$search_val=$_POST['search_book_name'];
												$query=mysql_query("SELECT * FROM `e_books`where book_name like '%".$search_val."%'");
												
												}else{
												$query=mysql_query("SELECT * FROM `e_books`");
											}
											$book_path="book/";$i=0;
											while($result=mysql_fetch_assoc($query)){
												
												if($i>0){
												?>
												<li>
													<div class="detail">
														<a href="<?php echo $book_path.$result['book_path_name']?>"><h3><label>Book Name:<?php echo ucfirst($result['book_name']);?></label></h3></a>
														<span class="year"><label>Upload Date:</label><?php echo $result['upload_date'];?></span>
														<span class="track"><label>About Book:</label><?php echo $result['description'];?></span>
													</div>
												</li>
											<?php }$i++;} ?>
											
											
											
									</ul>
									
								</div>
							</div>
							<div class="col-md-4 col-md-push-1">
								<aside class="sidebar">
									<div class="widget">
										<h3 class="widget-title">Book List</h3>
										<ul class="discography-list">
											<?PHP 
												$query=mysql_query("SELECT * FROM `e_books`  order by id limit 5");
												$book_path="book/";$i=0;
												while($result=mysql_fetch_assoc($query)){
													
													if($i>0){
													?>
													<li>
														<div class="detail">
															<a href="<?php echo $book_path.$result['book_path_name']?>"><h3><label>Book Name:<?php echo ucfirst($result['book_name']);?></label></h3></a>
															<span class="year"><label>Upload Date:</label><?php echo $result['upload_date'];?></span>
															<span class="track"><label>About Book:</label><?php echo $result['description'];?></span>
														</div>
													</li>
												<?php }$i++;} ?>
												
												
												
										</ul>
									</div>
								</aside>
							</div>
						</div>
					</div>
				</div> <!-- .testimonial-section -->
				
				
			</main> <!-- .main-content -->
			
			<footer class="site-footer">
				<div class="container">
					<img src="dummy/logo-footer.png" alt="Site Name">
					
					<address>
						<p>LENNYFACE<br><a href="tel:354543543">(563) 429 234 890</a> <br> <a href="mailto:info@bandname.com">info@bandname.com</a></p> 
					</address> 
					
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
		<script type="text/javascript">
			window.onload=function(){
				alert("hey");
				$("#save_file").click(function(){
					if($("#file").val()==""){
						alert("Please SELECT a File");
					});
				}
			}
		</script>
		
	</body>
	
</html>								