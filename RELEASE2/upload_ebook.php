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

}
  //following function will move uploaded file to audios folder. 
}
}
}




}
?>

