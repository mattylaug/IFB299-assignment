<?php 
include('database_connection.php');

$id1 = $_GET['id']; 
$id = $_GET['id1']; 
$page = $_GET['page'];


mysql_query("DELETE FROM `media` WHERE media_id='$id1'");

if($page === 'mp3'){
		header("Location: view_mp3_for_user.php?id=$id");
		}
		else if($page === 'video'){
		header("Location: view_video_for_user.php?id=$id");
		}
		else if($page === 'image'){
		header("Location: view_images_for_user.php?id=$id");
		}
		else{
		header("Location: view_ebook_for_user.php?id=$id");
		}




?>