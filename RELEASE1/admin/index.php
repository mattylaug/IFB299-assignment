<?php
include ('database_connection.php');
session_start();
if(!isset($_SESSION['name'])){
header("Location: login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title>Admin Panel</title>
	<meta name="description" content="Bootstrap Admin Home Dashboard">
	//QUT LENNYFACE
	<!-- end: Meta -->
	
	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- end: Mobile Specific -->
	
	<!-- start: CSS -->
	<link id="bootstrap-style" href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	<link id="base-style" href="css/style.css" rel="stylesheet">
	<link id="base-style-responsive" href="css/style-responsive.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
	<!-- end: CSS -->
	

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<link id="ie-style" href="css/ie.css" rel="stylesheet">
	<![endif]-->
	
	<!--[if IE 9]>
		<link id="ie9style" href="css/ie9.css" rel="stylesheet">
	<![endif]-->
		
	<!-- start: Favicon -->
	<link rel="shortcut icon" href="img/favicon.ico">
	<!-- end: Favicon -->
	
		
		
		
</head>

<body>
		<!-- start: Header -->
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="index.php"><span>Admin Home</span></a>
								
				<!-- start: Header Menu -->
				<div class="nav-no-collapse header-nav">
					<ul class="nav pull-right">
						<!-- start: User Dropdown -->
						<li class="dropdown">
							<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
								<i class="halflings-icon white user"></i> Hi, Admin
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								
								<li><a href="logout.php"><i class="halflings-icon off"></i> Logout</a></li>
							</ul>
						</li>
						<!-- end: User Dropdown -->
					</ul>
				</div>
				<!-- end: Header Menu -->
				
			</div>
		</div>
	</div>
	<!-- start: Header -->
	
		<div class="container-fluid-full">
		<div class="row-fluid">
				
			<!-- start: Main Menu -->
			<div id="sidebar-left" class="span2">
				<div class="nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li><a href="index.php"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Dashboard</span></a></li>
						<li><a href="users.php"><i class="icon-bar-users" ></i><span class="hidden-tablet"> Users</span></a></li>	
						
						<li>
							<a class="dropmenu" href="#"><i class="icon-folder-close-alt"></i><span class="hidden-tablet"> Media</span><span class="label label-important"> 4 </span></a>
							<ul>
								<li><a class="submenu" href="view_mp3.php"><i class="icon-file-alt"></i><span class="hidden-tablet"> Audios</span></a></li>
								<li><a class="submenu" href="view_mp4.php"><i class="icon-file-alt"></i><span class="hidden-tablet"> Videos</span></a></li>
								<li><a class="submenu" href="view_images.php"><i class="icon-file-alt"></i><span class="hidden-tablet"> Gallery</span></a></li>
								<li><a class="submenu" href="view_ebook_for_user.php"><i class="icon-file-alt"></i><span class="hidden-tablet"> E-Books</span></a></li>
							</ul>	
						</li>
						
					</ul>
				</div>
			</div>
			<!-- end: Main Menu -->
			
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
			QUT TEAM LENNYFACEYou need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>
			
			<!-- start: Content -->
			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="index.html">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="#">Dashboard</a></li>
			</ul>

			<!------------------- queries  -------------------- -->
			
			<?php
			$result = mysql_query("SELECT * FROM registered_users");
						if(!$result){
						echo "error".mysql_error();
						}
						
			$number_of_users = mysql_num_rows($result);
			?>
			<?php
			$result = mysql_query("SELECT * FROM registered_users where banned='1'");
						if(!$result){
						echo "error".mysql_error();
						}
						
			$number_of_banned_users = mysql_num_rows($result);
			?>
			<?php
			$result = mysql_query("SELECT * FROM media where data_type='.mp3'");
						if(!$result){
						echo "error".mysql_error();
						}
						
			$number_of_mp3= mysql_num_rows($result);
			?>
			<?php
			$result = mysql_query("SELECT * FROM media where data_type='.bmp' OR data_type='.jpg' OR data_type='.png'");
						if(!$result){
						echo "error".mysql_error();
						}
						
			$number_of_images= mysql_num_rows($result);
			?>
			<?php
			$result = mysql_query("SELECT * FROM media where data_type='.mp4' OR data_type='.wma' OR data_type='.avi'");
						if(!$result){
						echo "error".mysql_error();
						}
						
			$number_of_videos= mysql_num_rows($result);
			?>

			
			
			<div class="row-fluid hideInIE8 circleStats">
				
				<div class="span2" onTablet="span4" onDesktop="span2">
                	<div class="circleStatsItemBox yellow">
						<div class="header">Total Users</div>
						<span class="percent" style="font-size:70px;"><?php echo $number_of_users; ?></span>
								
						
                	</div>
				</div>
				
				<div class="span2" onTablet="span4" onDesktop="span2">
                	<div class="circleStatsItemBox purple">
						<div class="header">Total Banned Users</div>
						<span class="percent" style="font-size:70px;"><?php echo $number_of_banned_users; ?></span>
								
						
                	</div>
				</div>
						
			</div>	

			<div class="row-fluid hideInIE8 circleStats">
				
				<div class="span2" onTablet="span4" onDesktop="span2">
                	<div class="circleStatsItemBox red">
						<div class="header">Audio Songs</div>
						<span class="percent" style="font-size:70px;"><?php echo $number_of_mp3; ?></span>
								
						
                	</div>
				</div>
				
				<div class="span2" onTablet="span4" onDesktop="span2">
                	<div class="circleStatsItemBox blue">
						<div class="header">Video Songs</div>
						<span class="percent" style="font-size:70px;"><?php echo $number_of_videos; ?></span>
								
						
                	</div>
				</div>
				
				<div class="span2" onTablet="span4" onDesktop="span2">
                	<div class="circleStatsItemBox green">
						<div class="header">Images</div>
						<span class="percent" style="font-size:70px;"><?php echo $number_of_images; ?></span>
								
						
                	</div>
				</div>
						
			</div>	
			
						
			
		
			
			
			
       

	</div><!--/.fluid-container-->
	
			<!-- end: Content -->
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
		
	<div class="modal hide fade" id="myModal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">�</button>
			<h3>Settings</h3>
		</div>
		<div class="modal-body">
	QUT TEAM LENNYFACEHere settings can be configured...</p>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Close</a>
			<a href="#" class="btn btn-primary">Save changes</a>
		</div>
	</div>
	
	<div class="clearfix"></div>
	
	
	<!-- start: JavaScript-->

		<script src="js/jquery-1.9.1.min.js"></script>
	<script src="js/jquery-migrate-1.0.0.min.js"></script>
	
		<script src="js/jquery-ui-1.10.0.custom.min.js"></script>
	
		<script src="js/jquery.ui.touch-punch.js"></script>
	
		<script src="js/modernizr.js"></script>
	
		<script src="js/bootstrap.min.js"></script>
	
		<script src="js/jquery.cookie.js"></script>
	
		<script src='js/fullcalendar.min.js'></script>
	
		<script src='js/jquery.dataTables.min.js'></script>

		<script src="js/excanvas.js"></script>
	<script src="js/jquery.flot.js"></script>
	<script src="js/jquery.flot.pie.js"></script>
	<script src="js/jquery.flot.stack.js"></script>
	<script src="js/jquery.flot.resize.min.js"></script>
	
		<script src="js/jquery.chosen.min.js"></script>
	
		<script src="js/jquery.uniform.min.js"></script>
		
		<script src="js/jquery.cleditor.min.js"></script>
	
		<script src="js/jquery.noty.js"></script>
	
		<script src="js/jquery.elfinder.min.js"></script>
	
		<script src="js/jquery.raty.min.js"></script>
	
		<script src="js/jquery.iphone.toggle.js"></script>
	
		<script src="js/jquery.uploadify-3.1.min.js"></script>
	
		<script src="js/jquery.gritter.min.js"></script>
	
		<script src="js/jquery.imagesloaded.js"></script>
	
		<script src="js/jquery.masonry.min.js"></script>
	
		<script src="js/jquery.knob.modified.js"></script>
	
		<script src="js/jquery.sparkline.min.js"></script>
	
		<script src="js/counter.js"></script>
	
		<script src="js/retina.js"></script>

		<script src="js/custom.js"></script>
	<!-- end: JavaScript-->
	
</body>
</html>
