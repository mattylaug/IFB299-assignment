<?php
	session_start();
	include 'db.php';
	$id = @$_SESSION['id'];
	$name = @$_SESSION['name'];
	$email = @$_SESSION['email'];
	$sql = mysql_query("SELECT status FROM registered_users WHERE user_id ='$id'");
	$current_directory = mysql_fetch_row(mysql_query("SELECT current_directory FROM registered_users WHERE user_id = '$id'"))[0];
	
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
	
?>

<?php
	if(isset($_POST['Submit']))
	{
		
		if($status === 'active')
		
		{
			
			if($_FILES['video_file']['type'] !='video/mp4' || $_FILES['video_file']['type']!='video/wma' || $_FILES['video_file']['type']!='video/avi')
			{
				header("Location:blog.php?message1=Please load mp4, wma, avi files");
				
			}				 
			
			$name= $_POST['name'];
			$file_name = $_FILES['video_file']['name'];
			$file_size = $_FILES['video_file']['size']/1048576;
			
			if($_FILES['video_file']['type']=='video/mp4' || $_FILES['video_file']['type']=='video/wma' || $_FILES['video_file']['type']=='video/avi')
			{ 
				$ext= GetImageExtension($_FILES['video_file']['type']);
				$new_file_name=date("d-m-Y")."-".time().$ext;
				
				if($ext === false){
					
					echo "*Select proper video";
				}
				else{
					
					
					$check = mysql_query("select name from media where name ='$name' AND data_type='$ext'  and user_id = '".$_SESSION['id']."'");
					$SongCount = mysql_num_rows($check);
					
					if($SongCount>0)
					{
						header("Location:blog.php?message1=This file already exists.");
						
					}
					
					else{
						
						
						
						
						$target_path = "videos/".$new_file_name;
						
						if(move_uploaded_file($_FILES['video_file']['tmp_name'], $target_path)) {
							
							
								//insert query if u want to insert file
								$query_insert_users="UPDATE `registered_users` SET `data_uploaded`='$total_data' where user_id='$id'";
								mysql_query($query_insert_users);
								
								
								
								
								//echo filesize($new_file_name);
								
								
								mysql_query($query_insert_users);
								
								//Below is code for folder size

								$a = explode('/',$current_directory);
								$folder_name =$a[sizeof($a)-2]; 
								
								$size_of_folder = $file_size + mysql_query("SELECT data_size FROM media WHERE name = '$folder_name' AND data_type = '.videofolder'");
								
								mysql_query("INSERT INTO `media`(`user_id`, `name`, `data_type`, `data_link`, `data_size`, `media_path`) VALUES ($id,'$name','$ext','$target_path','$file_size','$current_directory')");
								
								$query_insert="UPDATE media SET data_size='$size_of_folder' WHERE user_id='$id' AND name = '$folder_name'";
								if(mysql_query($query_insert)){
									header("Location:blog.php?message=Video uploaded successfully");
								}
							
						}
						//following function will move uploaded file to audios folder. 
					}
				}
			}
		}
		
		else
		{
			
			
			$name= $_POST['name'];
			$file_name = $_FILES['video_file']['name'];
			$file_size = $_FILES['video_file']['size']/1048576;
			
			$check_size = mysql_query("select data_uploaded from registered_users where user_id='$id'");
			while ($row = mysql_fetch_array($check_size)){
				$data_uploaded=$row['data_uploaded'];
			}
			//echo $file_size;
			//echo $data_uploaded;
			$total_data=$data_uploaded+$file_size;
			echo $space = 10 - $data_uploaded;
			if($total_data>10.00){
				header("Location:blog.php?message1=Can't upload,Space available is $space and file size is $file_size.");
			}
			else{
				
				if($_FILES['video_file']['type']=='video/mp4' || $_FILES['video_file']['type']=='video/wma' || $_FILES['video_file']['type']=='video/avi')
				{ 
					$ext= GetImageExtension($_FILES['video_file']['type']);
					$new_file_name=date("d-m-Y")."-".time().$ext;
					
					if($ext === false){
						
						echo "*Select proper video";
					}
					else{
						
						
						$check = mysql_query("select name from media where name ='$name' AND data_type='$ext' and user_id = '".$_SESSION['id']."'");
						$SongCount = mysql_num_rows($check);
						
						if($SongCount>0)
						{
							header("Location:blog.php?message1=This file already exists.");
							
						}
						
						else if ($_FILES["video_file"]["size"] > 10000000) {
							header("Location:blog.php?message1=Sorry, your file is too large.");
						}
						else{
							
							
							
							
							$target_path = "videos/".$new_file_name;
							
							if(move_uploaded_file($_FILES['video_file']['tmp_name'], $target_path)) {
								
								//insert query if u want to insert file
								$query_insert_users="UPDATE `registered_users` SET `data_uploaded`='$total_data' where user_id='$id'";
								mysql_query($query_insert_users);
								
								
								
								
								//echo filesize($new_file_name);
								
								
								mysql_query($query_insert_users);
								
								//Below is code for folder size

								$a = explode('/',$current_directory);
								$folder_name =$a[sizeof($a)-2]; 
								
								$size_of_folder = $file_size + mysql_query("SELECT data_size FROM media WHERE name = '$folder_name' AND data_type = '.videofolder'");
								
								mysql_query("INSERT INTO `media`(`user_id`, `name`, `data_type`, `data_link`, `data_size`, `media_path`) VALUES ($id,'$name','$ext','$target_path','$file_size','$current_directory')");
								
								$query_insert="UPDATE media SET data_size='$size_of_folder' WHERE user_id='$id' AND name = '$folder_name'";
								if(mysql_query($query_insert)){
									header("Location:blog.php?message=Video uploaded successfully");
								}
								
							}
							
						}//following function will move uploaded file to audios folder. 
					}
				}
			}
			
		}
		
	}
?>

