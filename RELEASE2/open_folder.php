<?php
	session_start ();
	include 'db.php';
	
	/*if(false) //!IsValidFolderName()
		{
		header("Location:blog.php?message1=Folder name cannot have forwardslash.");
		}				 
	*/
	
	//$folder_directory = "SELECT to_move FROM 'media' WHERE media_id = '$id'";
	function CreateNewPathAndChangePath($name,$page){
		$current_dir = @$_SESSION['current_directory'];
		
		$new_path = $current_dir.$name.'/';
		
		$_SESSION['current_directory'] = $new_path;
		header("Location:blog.php?message=Current Directory is now: $new_path");
		
	}
	
	if (isset($_GET['page']) AND isset($_GET['name'])) {
		CreateNewPathAndChangePath($_GET['name'],$_GET['page']);
    }
	
	
	/*
		$sql = "UPDATE registered_users SET current_directory = '$new_path' WHERE user_id = '$id'"; 
		
		mysql_query($sql);
		
		
		
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
	*/
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

