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
		
		$name = $_GET['name'];
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
			//$ext= GetImageExtension($_FILES['video_file']['type']);
			$current_directory = @$_SESSION['current_directory'];
			$name= $_POST['name'];
			$id = @$_SESSION['id'];
			
			$file_size=0;
			$ext= '.videofolder';
			$new_file_name=date("d-m-Y")."-".time().$ext;
			
			$check = mysql_query("select name from media where name ='$name' AND user_id = '$id'");
			$SongCount = mysql_num_rows($check);
			
			if($SongCount>0)
			{
				header("Location:blog.php?message1=This file already exists.");
				
			}
			$target_path = "videos/".$new_file_name;
			
			
			//insert query if u want to insert file
			//$query_insert_users="UPDATE `registered_users` SET `data_uploaded`='$total_data' where user_id='$id'";
			//mysql_query($query_insert_users);
			//echo filesize($new_file_name);
			
			
			
			
			$query_insert="INSERT INTO `media`(`user_id`, `name`, `data_type`, `data_link`, `data_size`) VALUES ($id,'$name','$ext','$target_path','$file_size')";
			mysql_query($query_insert);
			
			$query="UPDATE media SET media_path = '$current_directory' WHERE user_id = '$id' AND name = $name";
			if(mysql_query($query))
			header("Location:blog.php?message=Folder created successfully.");
			
			header("Location:blog.php?message= '$name' '$current_directory'");
			
			
			//following function will move uploaded file to audios folder. 	
	}
?>

