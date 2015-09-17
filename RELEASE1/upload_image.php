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
function GetImageExtension($imagetype)
{
    if(empty($imagetype)) return false;

    switch($imagetype)
    {
        case 'image/bmp': return '.bmp'; break;
        case 'image/jpeg': return '.jpg'; break;
        case 'image/png': return '.png'; break;
        default: return false;
    }

}
?>

<?php



if($_FILES['ref_img']['type'] !='image/bmp' || $_FILES['ref_img']['type']!='image/jpeg' || $_FILES['ref_img']['type']!='image/png')
 {
	 header("Location:gallery.php?message1=Please load bmp, jpeg, png files");
 }

if(isset( $_POST['Submit'] )){

	$name=$_POST['name'];
	$file_size = $_FILES['ref_img']['size']/1048576;

	if(empty($_FILES["ref_img"]["name"])){
		$error="*Image is Mandatory";
	}
	else{
			
		$file_name=$_FILES["ref_img"]["name"];

		$temp_name=$_FILES["ref_img"]["tmp_name"];

		$file_type=$_FILES["ref_img"]["type"];

		$ext= GetImageExtension($file_type);
								
		if($ext === false){
			echo "*Select proper image";
		}
								
		else{

			$imagename=date("d-m-Y")."-".time().$ext;

			$ref_img = "images/".$imagename;
 
			if(!$ref_img)
			{
				echo " path not found";
			}


			if(!move_uploaded_file($temp_name, $ref_img)) {

				die("Error While uploading image on the server");
			}
			else{
			
				$query_insert="INSERT INTO `media`(`user_id`, `name`, `data_type`, `data_link`, `data_size`) VALUES ($id,'$name','$ext','$ref_img','$file_size')";
			
				if(mysql_query($query_insert))
				
				header("Location:gallery.php?message=Image uploaded successfully");
			
			}
		}

	}
}
?>

