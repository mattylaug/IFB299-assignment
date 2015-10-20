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
	
	$is_move = mysql_query("SELECT to_move FROM 'media' WHERE media_id = '$media_id' AND user_id = '$id'");
	$new_path = $current_directory.$name.'/';
	$page = $_GET['page'];
	
	
	$a = explode('/',$current_directory);
	$folder_name =$a[sizeof($a)-2]; 
	$size_of_folder = $file_size + mysql_query("SELECT data_size FROM media WHERE name = '$name' AND data_type = '.videofolder' AND user_id = '$id'");  //For folder size. Gets new folder size by adding size of file to be added.
	
	$sql = "UPDATE media SET media_path = '$new_path' WHERE to_move = 1 AND data_type =('.mp4' || '.wma' || '.avi') AND user_id = '$id'"; 
	
	if(mysql_query($sql)){
		mysql_query("UPDATE media'SET to_move = '0' WHERE to_move = 1 AND 'data_type' =('.mp4' || '.wma' || '.avi') AND user_id = '$id'");
		mysql_query("UPDATE media SET data_size = '$size_of_folder' WHERE to_move = 1 AND 'data_type' =('.mp4' || '.wma' || '.avi') AND user_id = '$id'");
		header("Location:blog.php?message=Media moved to folder successfully");
	}
	header("Location:blog.php?message='$name' '$new_path'");
	
	
	/*  The following statements check which page
		if($page === 'mp3'){
		
		}
		
		else if($page === 'video'){
		
		}
		
		else if($page === 'images'){
		
		}
		
		else{
		
		}
	*/
	
	//$sql = "UPDATE 'media' SET 'media_path' = '$new_path' WHERE to_move = 1 AND 'data_type' =('.mp4' OR '.wma' OR '.avi')"; 
?>

