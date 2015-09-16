<?php 
include('database_connection.php');
$user_id=35;
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
$name= $_POST['name'];
$file_name = $_FILES['video_file']['name'];
 $file_size = $_FILES['video_file']['size']/1048576;

if($_FILES['video_file']['type']=='video/mp4' || $_FILES['video_file']['type']=='video/wma' || $_FILES['video_file']['type']=='video/avi')
{ 
	$ext= GetImageExtension($_FILES['video_file']['type']);
	if($ext === false){
echo 'Unknown Format';
}
  


else
{
$new_file_name=date("d-m-Y")."-".time().$ext;

 $check = mysql_query("select name from media where name ='$name'");
 $SongCount = mysql_num_rows($check);
		
		if($SongCount>0)
		{
			echo 'this file already exists';
		}
		
		else if ($_FILES["video_file"]["size"] > 10000000) {
    echo "Sorry, your file is too large.";
}
 else{
 

 
 
  $target_path = "videos/".$new_file_name;

 if(move_uploaded_file($_FILES['video_file']['tmp_name'], $target_path)) {

  //insert query if u want to insert file

 
 
 //echo filesize($new_file_name);
$query_insert="INSERT INTO `media`(`user_id`, `name`, `data_type`, `data_link`, `data_size`) VALUES ($user_id,'$name','$ext','$target_path','$file_size')";
			
if(mysql_query($query_insert))
echo 'success';
}
  //following function will move uploaded file to audios folder. 
}
}
}
}

?>

<form name="audio_form" id="audio_form" action="upload_video.php" method="post" enctype="multipart/form-data">
<fieldset>
<label>Video File:</label>
<input name="name" id="" type="text"/>

<input name="video_file" id="video_file" type="file"/>
<input type="submit" name="Submit" id="Submit" value="Submit"/>
</fieldset>
</form>