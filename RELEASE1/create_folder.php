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
if(isset($_POST['Folder']))
{

if($status === 'active')
{
			  
		if(!IsValidFolderName())
		{
			 header("Location:blog.php?message1=Folder name cannot have forwardslash.");
		}				 
						 
		$name= $_POST['name'];
		$file_name = $_FILES['video_file']['name'];
		$file_size = 0;

		if(true)  //$_FILES['video_file']['type']=='video/mp4' || $_FILES['video_file']['type']=='video/wma' || $_FILES['video_file']['type']=='video/avi'
		{ 
			$ext= '.videofolder';
			$new_file_name=date("d-m-Y")."-".time().$ext;
			
			//if($ext === false){

						//echo "*Select proper video";
			//}
			$check = mysql_query("select name from media where name ='$name' AND data_type='$ext'  and user_id = '".$_SESSION['id']."'");
			$SongCount = mysql_num_rows($check);
					
			if($SongCount>0)
			{
				header("Location:blog.php?message1=This folder already exists.");

			}
					
			else{
				
				$target_path = "videos/".$new_file_name;

				if(move_uploaded_file($_FILES['video_file']['tmp_name'], $target_path)) {

				//insert query if you want to insert file

				 
				 
				//echo filesize($new_file_name);
				$query_insert="INSERT INTO `media`(`user_id`, `name`, `data_type`, `data_link`, `data_size`) VALUES ($id,'$name','$ext','$target_path','$file_size')";
							
				if(mysql_query($query_insert))
				header("Location:blog.php?message=Folder added successfully");

				}
				  //following function will move uploaded file to audios folder. 
			}
			
		}
}

else
{
	$name= $_POST['name'];
	//$file_name = $_FILES['video_file']['name'];
	//$file_size = $_FILES['video_file']['size']/1048576;

	// echo $file_size=0;
	// echo $data_uploaded=0;
	//$total_data=0;
	//echo $space = 10 - $data_uploaded;

		if(true) //$_FILES['video_file']['type']=='video/mp4' || $_FILES['video_file']['type']=='video/wma' || $_FILES['video_file']['type']=='video/avi'
			{ 
			//$ext= GetImageExtension($_FILES['video_file']['type']);
			
			$ext= '.videofolder';
			$new_file_name=date("d-m-Y")."-".time().$ext;
			
				$check = mysql_query("select name from media where name ='$name' ");
				$SongCount = mysql_num_rows($check);
						
				if($SongCount>0)
				{
					header("Location:blog.php?message1=This file already exists.");

				}		 
					$target_path = "videos/".$new_file_name;


				 //insert query if u want to insert file
				//$query_insert_users="UPDATE `registered_users` SET `data_uploaded`='$total_data' where user_id='$id'";
				//mysql_query($query_insert_users);
				$new_path = $current_directory;
				//echo filesize($new_file_name);
				$query_insert="INSERT INTO `media`(`user_id`, `name`, `data_type`, `data_link`, `data_size`) VALUES ($id,'$name','$ext','$target_path','$file_size')";
							
				if(mysql_query($query_insert))
				header("Location:blog.php?message=Video uploaded successfully");
			
				$query="UPDATE media SET media_path = '$new_path' WHERE user_id = '$id' AND name = $name";
				mysql_query($query);
				
			
				//following function will move uploaded file to audios folder. 
			
		}
	

}

}
?>

