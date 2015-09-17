<?php
session_start();
include 'db.php';
$id = @$_SESSION['id'];
$name = @$_SESSION['name'];
$email = @$_SESSION['email'];
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
if(isset($_POST['Submit']))
{
 if($status === 'active')
			 
				 {
				 
				 $name= $_POST['name'];
$file_name = $_FILES['audio_file']['name'];
 $file_size = $_FILES['audio_file']['size']/1048576;
 
 if($_FILES['audio_file']['type'] != 'audio/mpeg')
 {
	 header("Location:download.php?message1=Please load audio file");
 }
 
 if(empty($_POST['name'])||empty($file_size))
 {
			
			header("Location:download.php?message1=Please fill all the fields");
			}
			else{

if($_FILES['audio_file']['type']=='audio/mpeg' || $_FILES['audio_file']['type']=='audio/mpeg3' || $_FILES['audio_file']['type']=='audio/x-mpeg3' || $_FILES['audio_file']['type']=='audio/mp3')
{ 
  $new_file_name=date("d-m-Y")."-".time().'.mp3';




 $check = mysql_query("select name from media where name ='$name' AND data_type='.mp3' and user_id = '".$_SESSION['id']."'");
 $SongCount = mysql_num_rows($check);
		
		if($SongCount>0)
		{
			header("Location:download.php?message1=File with the name $name already exists.");
		}
		
 else{
 

 
 
  $target_path = "songs/".$new_file_name;

 if(move_uploaded_file($_FILES['audio_file']['tmp_name'], $target_path)) {

  //insert query if u want to insert file

 
 
 //echo filesize($new_file_name);
$query_insert="INSERT INTO `media`(`user_id`, `name`, `data_type`, `data_link`, `data_size`) VALUES ($id,'$name','.mp3','$target_path','$file_size')";
			
if(mysql_query($query_insert))
header("Location:download.php?message=File uploaded successfully");}
  //following function will move uploaded file to audios folder. 
}
}
}
				 
				 
				 }
				 else     						//      ------------  unregistered users
				 {

$name= $_POST['name'];
$file_name = $_FILES['audio_file']['name'];
 $file_size = $_FILES['audio_file']['size']/1048576;
 
 $check_size = mysql_query("select data_uploaded from registered_users where user_id='$id'");
 while ($row = mysql_fetch_array($check_size)){
 $data_uploaded=$row['data_uploaded'];
 }
 //echo $file_size;
 //echo $data_uploaded;
 $total_data=$data_uploaded+$file_size;
  echo $space = 10 - $data_uploaded;
 
 if($total_data>10.00){
 header("Location:download.php?message1=Can't upload,Space available is $space and file size is $file_size");
 }
 else{
 if(empty($_POST['name'])||empty($file_size))
 {
			
			header("Location:download.php?message1=Please fill all the fields");
			}
			else{

if($_FILES['audio_file']['type']=='audio/mpeg' || $_FILES['audio_file']['type']=='audio/mpeg3' || $_FILES['audio_file']['type']=='audio/x-mpeg3' || $_FILES['audio_file']['type']=='audio/mp3')
{ 
  $new_file_name=date("d-m-Y")."-".time().'.mp3';




 $check = mysql_query("select name from media where name ='$name' AND data_type='.mp3'");
 $SongCount = mysql_num_rows($check);
		
		if($SongCount>0)
		{
			header("Location:download.php?message1=File with the name $name already exists.");
		}
		
		else if ($_FILES["audio_file"]["size"] > 10000000) {
		header("Location:download.php?message1=File is larger than 10mb");
}
 else{
 

 
 
  $target_path = "songs/".$new_file_name;

 if(move_uploaded_file($_FILES['audio_file']['tmp_name'], $target_path)) {

  //insert query if u want to insert file

 
 
 //echo filesize($new_file_name);
$query_insert_users="UPDATE `registered_users` SET `data_uploaded`='$total_data' where user_id='$id'";
mysql_query($query_insert_users);
 

$query_insert="INSERT INTO `media`(`user_id`, `name`, `data_type`, `data_link`, `data_size`) VALUES ($id,'$name','.mp3','$target_path','$file_size')";
			
if(mysql_query($query_insert))
header("Location:download.php?message=File uploaded successfully");}
  //following function will move uploaded file to audios folder. 
}
}
}
}
}
}
?>

