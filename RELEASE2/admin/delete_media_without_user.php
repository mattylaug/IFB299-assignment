<?php 
include('database_connection.php');

$id1 = $_GET['id']; 
 
$page = $_GET['page'];


mysql_query("DELETE FROM `media` WHERE media_id='$id1'");

if($page === 'mp3'){
		header("Location: view_mp3.php");
		}
		else if($page === 'video'){
		header("Location: view_mp4.php");
		}
		else if($page === 'image'){
		header("Location: view_images.php");
		}
		else{
		header("Location: view_ebook.php");
		}




?>