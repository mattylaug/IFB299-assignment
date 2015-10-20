<?php 
	//include('dbcontroller.php');
	include('database_connection.php');
	$id = @$_SESSION['id'];
	$id1 = $_GET['id']; 
	$page = $_GET['page'];
	$name = $_GET['name'];
	
	$media_path = $_GET['media_path'].$name.'/';
	
	mysql_query("DELETE FROM `media` WHERE media_id='$id1' AND user_id = '" . $_SESSION ['id'] . "'");
	
	mysql_query("DELETE FROM `media` WHERE media_path='$media_path' AND user_id = '" . $_SESSION ['id'] . "'");
	
	if($page === 'mp3'){
		header("Location: download.php");
	}
	else if($page === 'video'){
		header("Location: blog.php");
	}
	else if($page === 'images'){
		header("Location: gallery.php");
	}
	else{
		header("Location: index.php");
	}
	
	
	
	
?>