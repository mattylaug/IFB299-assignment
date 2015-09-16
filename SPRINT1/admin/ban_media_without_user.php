<?php 
include('database_connection.php');

$id1 = $_GET['id']; 

$page = $_GET['page'];  

		$result = mysql_query("SELECT banned FROM media WHERE media_id='$id1'");
						if(!$result){
						echo "error".mysql_error();
						}




		while($row = mysql_fetch_array($result)){
						  $banned=$row['banned'];
						  }
						  //echo $banned;
		if($banned === '1'){
			mysql_query("UPDATE `media` SET `banned`= 0 WHERE media_id='$id1'");
		}
		else{
			mysql_query("UPDATE `media` SET `banned`= '1' WHERE media_id='$id1'");
		}
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
		


//header("Location: view_media.php?id=$id"); 


?>