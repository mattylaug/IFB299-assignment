<?php
	session_start();
	include 'db.php';
	
	function DirectoryStringWithCurrentFolderRemoved(){
		$current_dir = @$_SESSION['current_directory'];
		$strlen = strlen($current_dir)-1; //0 indexed
		
		for( $i = $strlen-1; $i >4 ; $i-- ) {
			$char = substr( $current_dir, $i, 1 );
			if($char == '/'){
				return substr($current_dir,0,$i+1);
			}
			}
		return null;
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
	
	function PreviousFolder(){
		
		$current_directory = @$_SESSION['current_directory'];
		if($current_directory != '/main/'){ //Will not go back a folder if
			/*if(false) //!IsValidFolderName()
				{
				header("Location:blog.php?message1=Folder name cannot have forwardslash.");
				}				 
			*/
			
			//$folder_directory = "SELECT to_move FROM 'media' WHERE media_id = '$id'";
			$page = $_GET['page'];
			
			$new_path = DirectoryStringWithCurrentFolderRemoved();
			
			$_SESSION["current_directory"] = $new_path;
			header("Location:blog.php?message=Went back one directory to: $new_path");
			
			/*
				$sql = "UPDATE registered_users SET current_directory = '$new_path' WHERE user_id = '$id'"; 
				
				mysql_query($sql);
				header("Location:blog.php?message=Current Directory: $new_path  $id");
				
				if($page === 'mp3'){
				$sql = "UPDATE 'registered_users' SET 'current_directory' = '$new_path' WHERE id = '$id' "; 
				
				if(mysql_query($sql))
				header("Location:blog.php?message=Media moved to $name folder successfully");
				}
				
				else if($page === 'video'){
				$sql = "UPDATE registered_users SET current_directory = '$new_path' WHERE id = '$id'"; 
				
				if(mysql_query($sql))
				header("Location:blog.php?message=Current Directory: $new_path");
				}
				
				else if($page === 'images'){
				$sql = "UPDATE 'registered_users' SET 'current_directory' = '$new_path' WHERE id = '$id'"; 
				
				if(mysql_query($sql))
				header("Location:blog.php?message=Media moved to $name folder successfully");
				}
			*/
			
			//$sql = "UPDATE 'media' SET 'media_path' = '$new_path' WHERE to_move = 1"; 
			
		}
	}
	
if (isset($_GET['page'])) {
		PreviousFolder();
 }	
?>

