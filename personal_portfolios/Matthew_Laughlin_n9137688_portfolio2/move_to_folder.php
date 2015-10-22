<?php
	session_start();
	include 'db.php';
	$id = @$_SESSION['id'];
	$name = @$_SESSION['name'];
	$email = @$_SESSION['email'];
	$current_directory = @$_SESSION['current_directory'];
	$sql = mysql_query("SELECT status FROM registered_users WHERE user_id ='$id'");
	
	$row = mysql_fetch_array($sql);
	
	$status = $row['status'];
	if($status === 'Inactive')
	
	{
		$message = "Please activate your account, An activation link is sent to <b>$email</b>";
	}
	else
	{
		// Do Nothing
	}
	
	
	
	
?>
<?php
	
	function GetImageExtension($file_type)
	{
		if(empty($file_type)) return false;
		
		switch($file_type)
		{
			case 'video/mp4': return '.mp4'; break;
			case 'video/wma': return '.wma'; break;
			case 'video/avi': return '.avi'; break;
			default: return false;
		}
		
		
	}
	
	function IsValidFolderName(){
		
		
		$namelen = strlen( $name );
		
		for( $i = 0; $i <= $namelen; $i++ ) {
			$char = substr( $str, $i, 1 );
			if($char == '/'){
				return false;
			}
		}
		return true;
	}
	
?>

<?php  
	/*if(false) //!IsValidFolderName()
		{
		header("Location:blog.php?message1=Folder name cannot have forwardslash.");
		}				 
	*/
	$media_id = $_GET['id']; 
	$name= $_GET['name'];
	$file_size= $_GET['file_size'];
	$ext = '.'.$_GET['page'].'folder';
	
	$is_move = mysql_fetch_row(mysql_query("SELECT to_move FROM 'media' WHERE media_id = '$media_id' AND user_id = '$id'"))[0];
	$new_path = $current_directory.$name.'/';
	$page = $_GET['page'];
	
	$a = explode('/',$current_directory);
	$size_of_folder = $file_size + mysql_fetch_row(mysql_query("SELECT data_size FROM media WHERE media_id = '$media_id' AND data_type = '$ext' AND user_id = '$id'"))[0];  //For folder size. Gets new folder size by adding size of file to be added.
	
	if($page =='video'){
		$sql = "UPDATE media SET media_path = '$new_path' WHERE to_move = 1 AND data_type =('.mp4' || '.wma' || '.avi') AND user_id = '$id'"; 
	} 
	else if ($page =='audio'){
		$sql = "UPDATE media SET media_path = '$new_path' WHERE to_move = 1 AND data_type = '.mp3' AND user_id = '$id'"; 
	} 
	else if ($page == 'ebook'){
	 	$sql = "UPDATE e_books SET media_path = '$new_path' WHERE to_move = 1 AND user_id = '$id'"; 
	} 
	else if($page == 'gallery'){
		$sql = "UPDATE media SET media_path = '$new_path' WHERE to_move = 1 AND (data_type='.png' || data_type='.jpg' || data_type='.bmp') AND user_id = '$id'"; 
	}
	
	if(mysql_query($sql)){
		mysql_query("UPDATE media SET data_size = '$size_of_folder' WHERE data_type = '$ext' AND media_id = '$media_id' AND user_id = '$id'");
		if($page =='ebook'){
			mysql_query("UPDATE e_books SET to_move = '0' WHERE to_move = 1 AND user_id = '$id'");
		} 
		else {
			
			mysql_query("UPDATE media SET to_move = '0' WHERE to_move = 1 AND user_id = '$id'");
		}
		SendMessage("Moved to folder '$name'",$page);
	}
	
	function SendMessage($message,$page){
		if($page === 'audio'){
			header("Location:download.php?message1='$message'");
		}
		else if($page === 'video'){
			
			header("Location:blog.php?message1='$message'");
		}
		else if($page === 'images'){
			header("Location:gallery.php?message1='$message'");
		} 
		else{
			header("Location:about.php?message1='$message'");
		}
	}
?>

