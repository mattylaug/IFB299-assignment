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
		
		SendMessage("Opened folder.",$page);
		
	}
	
	if (isset($_GET['page']) AND isset($_GET['name'])) {
		CreateNewPathAndChangePath($_GET['name'],$_GET['page']);
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
	
	function SendMessage($message,$page){
		if($page === 'audio'){
			header("Location:download.php?message='$message1'");
		}
		else if($page === 'video'){
			
			header("Location:blog.php?message='$message1'");
		}
		else if($page === 'gallery'){
			header("Location:gallery.php?message='$message1'");
		} 
		else{
			header("Location:about.php?message='$message1'");
		}
	}
	
?>

