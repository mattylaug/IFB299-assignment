<?php 
include('database_connection.php');

$id1 = $_GET['id']; 
$id = $_GET['id1'];
$page = $_GET['page'];  

		$result = mysql_query("SELECT banned FROM e_books WHERE id='$id1'");
						if(!$result){
						echo "error".mysql_error();
						}




		while($row = mysql_fetch_array($result)){
						  $banned=$row['banned'];
						  }
						  //echo $banned;
		if($banned === '1'){
			mysql_query("UPDATE `e_books` SET `banned`= 0 WHERE id='$id1'");
		}
		else{
			mysql_query("UPDATE `e_books` SET `banned`= '1' WHERE id='$id1'");
		}
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
		


//header("Location: view_media.php?id=$id"); 


?>