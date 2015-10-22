<?php 
	//include('dbcontroller.php');
	session_start();
	include('database_connection.php');
	$id = $_SESSION['id'];
	
	$id1 = $_GET['id']; 
	$page = $_GET['page'];
	$name = $_GET['name'];
	$size = $_GET['size'];
	
	$media_path = $_GET['media_path'].$name.'/';
    if($page != 'ebook'){
		mysql_query("DELETE FROM `media` WHERE media_id = '$id1' AND user_id = '$id'");
		
		mysql_query("DELETE FROM `media` WHERE media_path = '$media_path' AND user_id = '$id'");
		
		$uploaded=mysql_fetch_row(mysql_query("SELECT data_uploaded FROM registered_users WHERE user_id = '$id' "))[0];
		
		if(($uploaded - $size)>=0){
			$uploaded_new = $uploaded - $size;
			mysql_query("UPDATE registered_users SET data_uploaded = '$uploaded_new' WHERE user_id = '" . $_SESSION ['id'] . "' ");
		}
	} else if ($page == 'ebook') {
		mysql_query("DELETE FROM `e_books` WHERE id = '$id1' AND user_id = '$id'");
		
		mysql_query("DELETE FROM `e_books` WHERE media_path = '$media_path' AND user_id = '$id'");

	}
	if($page === 'audio'){
		header("Location: download.php");
	}
	else if($page === 'video'){
		header("Location: blog.php");
	}
	else if($page === 'images'){
		header("Location: gallery.php");
	}
	else{
		header("Location: about.php");
	}
	
	
	
	
?>