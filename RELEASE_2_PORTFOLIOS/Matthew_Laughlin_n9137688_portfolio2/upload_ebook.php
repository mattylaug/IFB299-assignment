<?php
	session_start();
	include 'db.php';
	$id = @$_SESSION['id'];
	$name = @$_SESSION['name'];
	$email = @$_SESSION['email'];
	$sql = mysql_query("SELECT status FROM registered_users WHERE user_id ='$id'");
	$current_directory = @$_SESSION['current_directory'];
	
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
			case 'application/pdf': return '.pdf'; break;
			case 'application/msword': return '.doc'; break;
			case 'text/plain': return '.txt'; break;
			default: return false;
		}
		
		
	}
	//application/pdf  application/msword  text/plain  
?>

<?php
	if(isset($_POST['Submit']))
	{
		echo $_FILES['video_file']['type'];
		
		if($_FILES['video_file']['type'] !='application/pdf' || $_FILES['video_file']['type']!='application/msword' || $_FILES['video_file']['type']!='text/plain')
		{
			header("Location:about.php?message1=Please load pdf, msword, txt files");
		}
		
		
		$book_name= ($_POST['name']);
		$author_name= addslashes($_POST['author']);
		$description= addslashes($_POST['description']);
		$file_name = $_FILES['video_file']['name'];
		$file_size = $_FILES['video_file']['size']/1048576;
		
		if($_FILES['video_file']['type']=='application/pdf' || $_FILES['video_file']['type']=='application/msword' || $_FILES['video_file']['type']=='text/plain')
		{ 
			$ext= GetImageExtension($_FILES['video_file']['type']);
			$new_file_name=date("d-m-Y")."-".time().$ext;
			
			if($ext === false){
				
				echo "*Select proper video";
			}
			else{
				
				
				$check = mysql_query("select book_name from e_books where book_name ='$book_name' AND author_name='$author_name'  and user_id = '".$_SESSION['id']."'");
				$SongCount = mysql_num_rows($check);
				
				if($SongCount>0)
				{
					header("Location:about.php?message1=This file already exists.");
					
				}
				
				else{
					
					
					
					
					$target_path = "ebooks/".$new_file_name;
					
					if(move_uploaded_file($_FILES['video_file']['tmp_name'], $target_path)) {
						
						//insert query if u want to insert file
						
						
						
						//echo filesize($new_file_name);
						$query_insert="INSERT INTO `e_books`(`book_name`, `author_name`, `description`, `book_path_name`,`user_id`) VALUES ('$book_name','$author_name','$description','$target_path','$id')";
						
						if(mysql_query($query_insert))
						header("Location:about.php?message=E-book uploaded successfully");
						
						$query_insert_users="UPDATE `registered_users` SET `data_uploaded`='$total_data' where user_id='$id'";
						mysql_query($query_insert_users);
						
						//Below is code for getting the folder name so later the size can be deduced
						$exploded_dir = explode('/',$current_directory);
						$folder_name =$exploded_dir[sizeof($exploded_dir)-2]; //gets current folder name
						
						$insertquery ="INSERT INTO `e_books`(`book_name`, `author_name`, `description`, `book_path_name`, `media_path`,`user_id`,`data_type`) VALUES ('$book_name', '$author_name' , '$description' ,'$target_path', '$current_directory','$id', '$ext')";
						if(mysql_query($insertquery)){
							header("Location:about.php?message=Uploaded ebook successfully.");
							
						}
						
					}
					//following function will move uploaded file to audios folder. 
				}
			}
		}
		
		
		
		
	}
?>

