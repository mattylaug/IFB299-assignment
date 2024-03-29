<?php
include ('database_connection.php');
session_start();
if(!isset($_SESSION['name'])){
header("Location: login.php");
}


$id=$_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title>Admin Panel</title>
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
				<a class="brand" href="index.html"><span>Metro</span></a>
								
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
								<li><a class="submenu" href="#"><i class="icon-file-alt"></i><span class="hidden-tablet"> E-Books</span></a></li>
							</ul>	
						</li>
					</ul>
				</div>
			</div>
			<!-- end: Main Menu -->
			
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
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
				<li><a href="#">Tables</a></li>
			</ul>

			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon music"></i><span class="break"></span>On Air Media</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					
					<?php
					
						// ----------- Query to get users information   ----------//
						
						$result = mysql_query("SELECT * FROM media where user_id=$id AND banned=0  AND(data_type='.jpg' OR data_type='.png' OR data_type='.bmp')");
						if(!$result){
						echo "error".mysql_error();
						}
					
					
					?>
					
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>No.</th>
								  <th>Name</th>
								  <th>Type</th>
								  <th>Size</th>
								  <th>Preview</th>
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						  <?php
						  $i=1;
						  while($row = mysql_fetch_array($result)):
						  ?>
							<tr>
								<td><?php echo $i++; ?></td>
								<td><?php echo $row['name']; ?></td>
								<td><?php echo $row['data_type']; ?></td>
								<td><?php echo $row['data_size']."MB"; ?></td>
								
								<td>
									<?php  if($row['data_type'] == '.mp3'){ ?>
									
									<audio controls>
										<source src="<?php echo "../".$row['data_link']; ?>" type="audio/mpeg">
									</audio>
									<?php }
									else if($row['data_type'] == '.bmp' || $row['data_type'] == '.jpg' || $row['data_type'] == '.png'){
									?>
									<img src="<?php echo "../".$row['data_link']; ?>" width="300" height="300">
									<?php
									}
									else { 
									?>
									<video width="320" height="240" controls>
										<source src="<?php echo"../".$row['data_link']; ?>" type="video/mp4">
									</video>
									<?php } ?>
									
								</td>
								<td class="center">
									
									<a class="btn btn-info" href="ban_media.php?id=<?php echo $row['media_id']; ?>&id1=<?php echo $id; ?>&page=image">
										
										<i class="halflings-icon white ban-circle" title="Ban/Active"></i>  
									</a>
									<a class="btn btn-danger" href="delete_media.php?id=<?php echo $row['media_id']; ?>&id1=<?php echo $id; ?>&page=image">
										<i class="halflings-icon white trash" title="Delete"></i> 
									</a>
								</td>
							</tr>
							<?php
							endwhile;
							?>
							
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->

			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon music"></i><span class="break"></span>Banned Media</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					
					<?php
					
						// ----------- Query to get users information   ----------//
						
						$result = mysql_query("SELECT * FROM media where user_id=$id AND banned=1  AND(data_type='.jpg' OR data_type='.png' OR data_type='.bmp')");
						if(!$result){
						echo "error".mysql_error();
						}
					
					
					?>
					
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>No.</th>
								  <th>Name</th>
								  <th>Type</th>
								  <th>Size</th>
								  <th>Preview</th>
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						  <?php
						  $i=1;
						  while($row = mysql_fetch_array($result)):
						  ?>
							<tr>
								<td><?php echo $i++; ?></td>
								<td><?php echo $row['name']; ?></td>
								<td><?php echo $row['data_type']; ?></td>
								<td><?php echo $row['data_size']."MB"; ?></td>
								
								<td>
									<?php  if($row['data_type'] == '.mp3'){ ?>
									
									<audio controls>
										<source src="<?php echo "../".$row['data_link']; ?>" type="audio/mpeg">
									</audio>
									<?php }
									else if($row['data_type'] == '.bmp' || $row['data_type'] == '.jpg' || $row['data_type'] == '.png'){
									?>
									<img src="<?php echo "../".$row['data_link']; ?>" width="300" height="300">
									<?php
									}
									else { 
									?>
									<video width="320" height="240" controls>
										<source src="<?php echo "../".$row['data_link']; ?>" type="video/mp4">
									</video>
									<?php } ?>
									
								</td>
								<td class="center">
									
									<a class="btn btn-info" href="ban_media.php?id=<?php echo $row['media_id']; ?>&id1=<?php echo $id; ?>&page=image">
										
										<i class="halflings-icon white ban-circle" title="Ban/Active"></i>  
									</a>
									<a class="btn btn-danger" href="delete_media.php?id=<?php echo $row['media_id']; ?>&id1=<?php echo $id; ?>&page=image">
										<i class="halflings-icon white trash" title="Delete"></i> 
									</a>v
								</td>
							</tr>
							<?php
							endwhile;
							?>
							
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
			
			
			
			
    

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
			<p>Here settings can be configured...</p>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Close</a>
			<a href="#" class="btn btn-primary">Save changes</a>
		</div>
	</div>
	
	<div class="clearfix"></div>
	
	<footer>

		<p>
			<span style="text-align:left;float:left">&copy; 2013 <a href="http://jiji262.github.io/Bootstrap_Metro_Dashboard/" alt="Bootstrap_Metro_Dashboard">Bootstrap Metro Dashboard</a></span>
			
		</p>

	</footer>
	
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
