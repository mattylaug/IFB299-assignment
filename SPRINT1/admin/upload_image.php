<?php 
include('database_connection.php');
$user_id=35;
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
			
				$query_insert="INSERT INTO `media`(`user_id`, `name`, `data_type`, `data_link`, `data_size`) VALUES ($user_id,'$name','$ext','$ref_img','$file_size')";
			
				if(mysql_query($query_insert))
				
				echo "posted easily";
			
			}
		}

	}
}
?>

<form name="add_ref" enctype="multipart/form-data" action="upload_image.php" method="post" >
	<div id="uploadphoto">
		Name: <input type="text" name="name"/>
		Attach Photo: <input type="file" name="ref_img">
	</div>
	
	<button type="submit" name="Submit">Upload</button>
	
</form>