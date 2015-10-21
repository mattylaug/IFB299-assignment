<?php 
	//include('dbcontroller.php');
	session_start();
	include('database_connection.php');
	
	$media_id = $_GET['id']; 
	/*$id = $_GET['id1']; */
	$page = $_GET['page'];
	$size = $_GET['size'];
	$id= $_SESSION ['id'];
	
	mysql_query("DELETE FROM `media` WHERE media_id='$media_id' AND user_id = '$id'");

	$uploaded = mysql_fetch_row(mysql_query("SELECT data_uploaded FROM registered_users WHERE user_id = '$id'"))[0];
	
	if(($uploaded - $size)>=0){
		$uploaded_new = $uploaded - $size;
		mysql_query("UPDATE registered_users SET data_uploaded = '$uploaded_new' WHERE user_id = '" . $_SESSION ['id'] . "' ");
	}
	
	
	if($page === 'mp3'){
		header("Location: download.php");
	}
	else if($page === 'video'){
		header("Location: blog.php?");
	}
	else if($page === 'images'){
		header("Location: gallery.php'");
	}
	else{
		header("Location: library.php");
	}
	
	
	
	
?>