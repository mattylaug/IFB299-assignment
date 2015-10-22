<?php
	session_start();
	include 'db.php';
	$id = @$_SESSION['id'];
	$name = @$_SESSION['name'];
	$email = @$_SESSION['email'];
	$current_directory = @$_SESSION['current_directory'];
	
	$move_id = $_GET['move_id'];
	$page = $_GET['page'];
	
	if($page != 'ebook'){
		$is_move =  mysql_fetch_array(mysql_query("SELECT to_move FROM media WHERE media_id = '$move_id' AND user_id = '" . $_SESSION ['id'] . "'"))[0];
		if ($is_move == '0') {
			$sql = "UPDATE media SET to_move = 1 WHERE media_id = '$move_id' AND user_id = '" . $_SESSION ['id'] . "' ";
			
			if(mysql_query( $sql )){
				SendMessage("Ready to move file.",$page);
			}
			
		} 
		else {
			
			$sql1 = "UPDATE media SET to_move = 0 WHERE media_id =' $move_id' AND user_id = '" . $_SESSION ['id'] . "' ";
			if(mysql_query($sql1)){
				SendMessage("Removed file to move.",$page);
			}
		}
	}
	else{
		$is_move =  mysql_fetch_array(mysql_query("SELECT to_move FROM e_books WHERE id = '$move_id' AND user_id = '" . $_SESSION ['id'] . "'"))[0];	
		
		if ($is_move == '0') {
			$sql = "UPDATE e_books SET to_move = 1 WHERE id = '$move_id' AND user_id = '" . $_SESSION ['id'] . "' ";
			
			if(mysql_query( $sql )){
				SendMessage("Ready to move file.",$page);
			}
			
		} 
		else {
			
			$sql = "UPDATE e_books SET to_move = 0 WHERE id = '$move_id' AND user_id = '" . $_SESSION ['id'] . "' ";
			if(mysql_query($sql1)){
				SendMessage("Removed file to move.",$page);
			}
		}
	}
	
	
	
	function SendMessage($message,$page){
		if($page === 'audio'){
			header("Location:download.php?message='$message'");
		}
		else if($page === 'video'){
			
			header("Location:blog.php?message='$message'");
		}
		else if($page === 'images'){
			header("Location:gallery.php?message='$message'");
			} else{
			header("Location:about.php?message='$message'");
		}
	}
	
?>

