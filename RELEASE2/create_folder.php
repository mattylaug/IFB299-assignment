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
		$name = $_POST['name']; 
		$id = @$_SESSION['id'];
		$page = $_GET['page'];
		
		$file_size=0;
		$ext = '.'.$page.'folder';
		
		$new_file_name=date("d-m-Y")."-".time().$ext;
		
		$check = mysql_query("select name from media where name = '$name' AND data_type='$ext' and user_id = '$id'");
		$SongCount = mysql_num_rows($check);
		
		if($SongCount>0)
		{
			header("Location:blog.php?message1=This file already exists '$name' '$ext'.");
			
		}
		
		else{
			$target_path = "folders/".$new_file_name;
			if($page != 'ebook'){
				$query_insert="INSERT INTO `media`(`user_id`, `name`, `data_type`, `data_link`, `data_size`) VALUES ($id,'$name','$ext','$target_path','$file_size')";
				$query="UPDATE media SET media_path = '$current_directory' WHERE user_id = '$id' AND name = '$name'";
				if(mysql_query($query_insert)){
					mysql_query($query);
					SendMessage("Folder created successfully.",$page);
				}
			}
			else if ($page == 'ebook') {
				$query_insert="INSERT INTO `e_books`(`book_name`, `author_name`, `description`, `book_path_name`, `media_path`,`user_id`,`data_type`) VALUES ('$name', '' , '' ,'$target_path', '$current_directory','$id', '$ext')";
				$query="UPDATE e_books SET media_path = '$current_directory' WHERE user_id = '$id' AND book_name = '$name'";
				if(mysql_query($query_insert)){
					mysql_query($query);
					SendMessage("Folder created successfully.",$page);
				}
			}
		}
	}
	function SendMessage($message,$page){
		if($page === 'audio'){
			header("Location:download.php?message='$message'");
		}
		else if($page === 'video'){
			
			header("Location:blog.php?message='$message'");
		}
		else if($page === 'images'){
			header("Location:gallery.php?message='$message'");
		} 
		else{
			header("Location:about.php?message='$message'");
		}
	}
?>

