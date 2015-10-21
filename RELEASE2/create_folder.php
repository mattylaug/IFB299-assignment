<?php
	session_start();
	include 'db.php';
	
	$name = @$_SESSION['name'];
	$email = @$_SESSION['email'];
	
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
		
		$name = $_GET['foldername'];
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
	if(isset($_POST['Folder']))
	{
		CreateFolder();	
	}
	
	function CreateFolder(){
		$current_directory = @$_SESSION['current_directory'];
		$name= $_POST['foldername'];
		$id = @$_SESSION['id'];
		$page = $_GET['page'];
		
		$file_size=0;
		$ext = '.'.$page.'folder';
		
		$new_file_name=date("d-m-Y")."-".time().$ext;
		
		$check = mysql_query("select name from media where name ='$name' AND data_type='$ext' and user_id = '".$_SESSION['id']."'");
		$SongCount = mysql_num_rows($check);
		
		if($SongCount>0)
		{
			header("Location:blog.php?message1=This file already exists.");
			
		}
		if($SongCount>0)
		{
			header("Location:blog.php?message1=This file already exists.");
			
		} 
		else{
			$target_path = "folders/".$new_file_name;
			$query_insert="INSERT INTO `media`(`user_id`, `name`, `data_type`, `data_link`, `data_size`) VALUES ($id,'$name','$ext','$target_path','$file_size')";
			$query="UPDATE media SET media_path = '$current_directory' WHERE user_id = '$id' AND name = $name";
			if(mysql_query($query AND mysql_query($query_insert)))
			header("Location:blog.php?message=Folder created successfully.");
		}
	}
?>

