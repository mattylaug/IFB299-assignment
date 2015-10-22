<?php 
	include('database_connection.php');
	
	$id1 = $_GET['id']; 
	/*$id = $_GET['id1'];*/ 
	$page = $_GET['page'];
	
	
	mysql_query("DELETE FROM `e_books` WHERE id='$id1'");
	
	if($page === 'ebook'){
		header("Location: about.php");
	}
	else{
		header("Location: index.php");
	}
	
	
	
	
?>