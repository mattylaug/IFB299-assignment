<?php 
include('database_connection.php');
$user_id=35;
?>

<?php
if(isset($_POST['Submit']))
{
$name= $_POST['name'];
$file_name = $_FILES['audio_file']['name'];
 $file_size = $_FILES['audio_file']['size']/1048576;

if($_FILES['audio_file']['type']=='audio/mpeg' || $_FILES['audio_file']['type']=='audio/mpeg3' || $_FILES['audio_file']['type']=='audio/x-mpeg3' || $_FILES['audio_file']['type']=='audio/mp3')
{ 
  $new_file_name=date("d-m-Y")."-".time().'.mp3';




 $check = mysql_query("select name from media where name ='$name'");
 $SongCount = mysql_num_rows($check);
		
		if($SongCount>0)
		{
			echo 'this file already exists';
		}
		
		else if ($_FILES["audio_file"]["size"] > 10000000) {
    echo "Sorry, your file is too large.";
}
 else{
 

 
 
  $target_path = "songs/".$new_file_name;

 if(move_uploaded_file($_FILES['audio_file']['tmp_name'], $target_path)) {

  //insert query if u want to insert file

 
 
 //echo filesize($new_file_name);
$query_insert="INSERT INTO `media`(`user_id`, `name`, `data_type`, `data_link`, `data_size`) VALUES ($user_id,'$name','.mp3','$target_path','$file_size')";
			
if(mysql_query($query_insert))
echo 'success';
}
  //following function will move uploaded file to audios folder. 
}
}
}

?>

<form name="audio_form" id="audio_form" action="upload_mp3.php" method="post" enctype="multipart/form-data">
<fieldset>
<label>Audio File:</label>
<input name="name" id="" type="text"/>

<input name="audio_file" id="audio_file" type="file"/>
<input type="submit" name="Submit" id="Submit" value="Submit"/>
</fieldset>
</form>