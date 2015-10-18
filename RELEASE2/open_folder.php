<?php
	session_start();
	include 'db.php';
	$id = @$_SESSION['id'];
	$name = @$_SESSION['name'];
	$email = @$_SESSION['email'];
	$current_directory = mysql_fetch_row(mysql_query("SELECT current_directory FROM registered_users WHERE user_id = '$id'"))[0];
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
	
	/*if(false) //!IsValidFolderName()
		{
		header("Location:blog.php?message1=Folder name cannot have forwardslash.");
		}				 
	*/
	
	//$folder_directory = "SELECT to_move FROM 'media' WHERE media_id = '$id'";
	$name = $_GET['name'];
	
	$page = $_GET['page'];
	
	$new_path = $current_directory.$name.'/';
	
	$sql = "UPDATE registered_users SET current_directory = '$new_path' WHERE user_id = '$id'"; 
	
	mysql_query($sql);
	header("Location:blog.php?message=Current Directory is now: $new_path");
	
	if($page === 'mp3'){
		$sql = "UPDATE 'registered_users' SET 'current_directory' = '$new_path' WHERE 'id' = '$id' AND 'data_type' =('.mp3')"; 
		
		if(mysql_query($sql))
		header("Location:blog.php?message=Current Directory: $new_path");
	}
	
	else if($page === 'vid'){
		$sql = "UPDATE 'registered_users' SET 'current_directory' = '$new_path' WHERE 'id' = '$id' AND 'data_type' =('.mp4' OR '.wma' OR '.avi')"; 
		
		if(mysql_query($sql))
		header("Location:blog.php?message=Current Directory: $new_path");
	}
	
	else if($page === 'images'){
		$sql = "UPDATE 'registered_users' SET 'current_directory' = '$new_path' WHERE 'id' = '$id' AND 'data_type' =('.jpeg')"; 
		
		if(mysql_query($sql))
		header("Location:blog.php?message=Media moved to $name folder successfully");
	}
	
	else{
		$sql = "UPDATE 'registered_users' SET 'current_directory' = '$new_path' WHERE 'id' = '$id' AND 'data_type' =('.pdf')"; 
		
		if(mysql_query($sql))
		header("Location:blog.php?message=Media moved to $name folder successfully");
	}
	
	//$sql = "UPDATE 'media' SET 'media_path' = '$new_path' WHERE to_move = 1 AND 'data_type' =('.mp4' OR '.wma' OR '.avi')"; 
	
	
	
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

