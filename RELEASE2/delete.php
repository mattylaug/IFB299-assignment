<?php 
	//include('dbcontroller.php');
	session_start();
	include('database_connection.php');
	
	$id1 = $_GET['id']; 
	/*$id = $_GET['id1']; */
	$page = $_GET['page'];
	
	
	mysql_query("DELETE FROM `media` WHERE media_id='$id1' AND user_id = '" . $_SESSION ['id'] . "'");
	
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