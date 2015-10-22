Artifact 1: Creating folders

For the folder system, the first thing I needed to do was create a folder in the db.
This creates an entry in the media, which represents a folder. This is independent of
what media page you're calling for, so if you're uploading a video or audio file
it will be able to tell which type it is giving it a .videofile or .audiofile data type.

After it's done it will redirect to the correct page.

From create_folder.php
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
		
		$name = $_POST['name']; 
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
		if(IsValidFolderName()){
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

Artifact 2: Deleting files and folders

This deletes all files within a folder. It is independent of page type, so can be called
from any media page.

From delete_folder.php

<?php 
	//include('dbcontroller.php');
	session_start();
	include('database_connection.php');
	$id = $_SESSION['id'];
	
	$id1 = $_GET['id']; 
	$page = $_GET['page'];
	$name = $_GET['name'];
	$size = $_GET['size'];
	
	$media_path = $_GET['media_path'].$name.'/';
    if($page != 'ebook'){
		mysql_query("DELETE FROM `media` WHERE media_id = '$id1' AND user_id = '$id'");
		
		mysql_query("DELETE FROM `media` WHERE media_path = '$media_path' AND user_id = '$id'");
		
		$uploaded=mysql_fetch_row(mysql_query("SELECT data_uploaded FROM registered_users WHERE user_id = '$id' "))[0];
		
		if(($uploaded - $size)>=0){
			$uploaded_new = $uploaded - $size;
			mysql_query("UPDATE registered_users SET data_uploaded = '$uploaded_new' WHERE user_id = '" . $_SESSION ['id'] . "' ");
		}
	} else if ($page == 'ebook') {
		mysql_query("DELETE FROM `e_books` WHERE id = '$id1' AND user_id = '$id'");
		
		mysql_query("DELETE FROM `e_books` WHERE media_path = '$media_path' AND user_id = '$id'");

	}
	if($page === 'audio'){
		header("Location: download.php");
	}
	else if($page === 'video'){
		header("Location: blog.php");
	}
	else if($page === 'images'){
		header("Location: gallery.php");
	}
	else{
		header("Location: about.php");
	}
	
?>

Artifact 3 Moving files from folder to folder

From to_move.php: Sets the to_move in the database of the media file to 1 or 0,
this depends on the current state. This allows it to be toggled on and off, so
on one click it turns it off, on the 2nd click back on again and so on. 

When it is set to 1, the system knows that is the file it needs to move to the folder
when clicking 'move to' on a folder.<?php
	session_start();
	include 'db.php';
	$id = @$_SESSION['id'];
	$name = @$_SESSION['name'];
	$email = @$_SESSION['email'];
	$current_directory = @$_SESSION['current_directory'];
	
	$move_id = $_GET['move_id'];
	$page = $_GET['page'];
	
	if($page != 'ebook'){
		$is_move =  mysql_fetch_array(mysql_query("SELECT to_move FROM media WHERE media_id = '$move_id' AND user_id = '" . $_SESSION ['id'] . "'"))[0];
		if ($is_move == '0') {
			$sql = "UPDATE media SET to_move = 1 WHERE media_id = '$move_id' AND user_id = '" . $_SESSION ['id'] . "' ";
			
			if(mysql_query( $sql )){
				SendMessage("Ready to move file.",$page);
			}
			
		} 
		else {
			
			$sql1 = "UPDATE media SET to_move = 0 WHERE media_id =' $move_id' AND user_id = '" . $_SESSION ['id'] . "' ";
			if(mysql_query($sql1)){
				SendMessage("Removed file to move.",$page);
			}
		}
	}
	else{
		$is_move =  mysql_fetch_array(mysql_query("SELECT to_move FROM e_books WHERE id = '$move_id' AND user_id = '" . $_SESSION ['id'] . "'"))[0];	
		
		if ($is_move == '0') {
			$sql = "UPDATE e_books SET to_move = 1 WHERE id = '$move_id' AND user_id = '" . $_SESSION ['id'] . "' ";
			
			if(mysql_query( $sql )){
				SendMessage("Ready to move file.",$page);
			}
			
		} 
		else {
			
			$sql = "UPDATE e_books SET to_move = 0 WHERE id = '$move_id' AND user_id = '" . $_SESSION ['id'] . "' ";
			if(mysql_query($sql1)){
				SendMessage("Removed file to move.",$page);
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
			} else{
			header("Location:about.php?message='$message'");
		}
	}
	
?>


From move_to_folder.php 

After clicking To move next to a media file and clicking Move to next to a folder,
this is run, so all the selected media files will be moved into the folder.
This is independent of what media page it was called from.

<?php
	session_start();
	include 'db.php';
	$id = @$_SESSION['id'];
	$name = @$_SESSION['name'];
	$email = @$_SESSION['email'];
	$current_directory = @$_SESSION['current_directory'];
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
	$media_id = $_GET['id']; 
	$name= $_GET['name'];
	$file_size= $_GET['file_size'];
	$ext = '.'.$_GET['page'].'folder';
	
	$is_move = mysql_fetch_row(mysql_query("SELECT to_move FROM 'media' WHERE media_id = '$media_id' AND user_id = '$id'"))[0];
	$new_path = $current_directory.$name.'/';
	$page = $_GET['page'];
	
	$a = explode('/',$current_directory);
	$size_of_folder = $file_size + mysql_fetch_row(mysql_query("SELECT data_size FROM media WHERE media_id = '$media_id' AND data_type = '$ext' AND user_id = '$id'"))[0];  //For folder size. Gets new folder size by adding size of file to be added.
	
	if($page =='video'){
		$sql = "UPDATE media SET media_path = '$new_path' WHERE to_move = 1 AND data_type =('.mp4' || '.wma' || '.avi') AND user_id = '$id'"; 
	} 
	else if ($page =='audio'){
		$sql = "UPDATE media SET media_path = '$new_path' WHERE to_move = 1 AND data_type = '.mp3' AND user_id = '$id'"; 
	} 
	else if ($page == 'ebook'){
	 	$sql = "UPDATE e_books SET media_path = '$new_path' WHERE to_move = 1 AND user_id = '$id'"; 
	} 
	else if($page == 'gallery'){
		$sql = "UPDATE media SET media_path = '$new_path' WHERE to_move = 1 AND (data_type='.png' || data_type='.jpg' || data_type='.bmp') AND user_id = '$id'"; 
	}
	
	if(mysql_query($sql)){
		mysql_query("UPDATE media SET data_size = '$size_of_folder' WHERE data_type = '$ext' AND media_id = '$media_id' AND user_id = '$id'");
		if($page =='ebook'){
			mysql_query("UPDATE e_books SET to_move = '0' WHERE to_move = 1 AND user_id = '$id'");
		} 
		else {
			
			mysql_query("UPDATE media SET to_move = '0' WHERE to_move = 1 AND user_id = '$id'");
		}
		SendMessage("Moved to folder '$name'",$page);
	}
	
	function SendMessage($message,$page){
		if($page === 'audio'){
			header("Location:download.php?message1='$message'");
		}
		else if($page === 'video'){
			
			header("Location:blog.php?message1='$message'");
		}
		else if($page === 'images'){
			header("Location:gallery.php?message1='$message'");
		} 
		else{
			header("Location:about.php?message1='$message'");
		}
	}
?>

Arifact 4: Navigating folders

From open folder.php. This opens the folder by setting the current path in the session to the new path.
It runs independently of which media page it's ran from.

<?php
	session_start ();
	include 'db.php';
	
	/*if(false) //!IsValidFolderName()
		{
		header("Location:blog.php?message1=Folder name cannot have forwardslash.");
		}				 
	*/
	
	//$folder_directory = "SELECT to_move FROM 'media' WHERE media_id = '$id'";
	function CreateNewPathAndChangePath($name,$page){
		$current_dir = @$_SESSION['current_directory'];
		
		$new_path = $current_dir.$name.'/';
		
		$_SESSION['current_directory'] = $new_path;
		
		SendMessage("Opened folder.",$page);
		
	}
	
	if (isset($_GET['page']) AND isset($_GET['name'])) {
		CreateNewPathAndChangePath($_GET['name'],$_GET['page']);
	}
	
	
?>
<?php
	
	function SendMessage($message,$page){
		if($page === 'audio'){
			header("Location:download.php?message='$message1'");
		}
		else if($page === 'video'){
			
			header("Location:blog.php?message='$message1'");
		}
		else if($page === 'gallery'){
			header("Location:gallery.php?message='$message1'");
		} 
		else{
			header("Location:about.php?message='$message1'");
		}
	}
	
?>

From previous_folder.php. This gets the current folder directory, removes the current
folder name, and sets it to the new path. It's independent of what media page it's run from.
This is run when previous folder button is pressed.

<?php
	session_start();
	include 'db.php';
	
	function DirectoryStringWithCurrentFolderRemoved(){
		$current_dir = @$_SESSION['current_directory'];
		$strlen = strlen($current_dir)-1; //0 indexed
		
		for( $i = $strlen-1; $i >4 ; $i-- ) {
			$char = substr( $current_dir, $i, 1 );
			if($char == '/'){
				return substr($current_dir,0,$i+1);
			}
		}
		return null;
	}
	
?>
<?php
	function PreviousFolder(){
		$page = $_GET['page'];
		
		$current_directory = @$_SESSION['current_directory'];
		
		if($current_directory != '/main/' ){ //Will not go back a folder if
			/*if(false) //!IsValidFolderName()
				{
				header("Location:blog.php?message1=Folder name cannot have forwardslash.");
				}				 
			*/
			
			//$folder_directory = "SELECT to_move FROM 'media' WHERE media_id = '$id'";
			
			$new_path = DirectoryStringWithCurrentFolderRemoved();
			$_SESSION["current_directory"] = $new_path;
			header("Location:blog.php?message=Went back one directory to: $new_path");
			$sql = "UPDATE registered_users SET current_directory = '$new_path' WHERE user_id = '$id'"; 
			
			if(mysql_query($sql)){
				header("Location:blog.php?message=Current Directory: $new_path  $id");
				SendMessage('Created Folder successfully.',$page);
			} 
			
			
			
			
		} 
		else{
			SendMessage('Cannot go back from main directory.',$page);
		}
	}
	
	if (isset($_GET['page'])) {
		PreviousFolder();
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

Artifact 4, UI for using folders and etc. From blog.php. Added create folder form, and various other UI changes to support the new folders. Changes are also in download.php 
and about.php. 

	
				<!--Form for creating folder -->
				<div class="row">
					<div class="col-md-3"></div>
					<div class="col-md-6">
						<h2 class="page-title">Create Folder</h2>
						<center>
							<?php
								$message2 = @$_GET ['message2'];
								if (isset ( $message2 )) {
								?>
								<div class="alert alert-danger alert-dismissible" role="alert">
								<?php echo $message2; ?></div>
							<?php } ?>
						</center>
						<center>
							<?php
								$message = @$_GET ['message'];
								if (isset ( $message3 )) {
								?>
								<div class="alert alert-success alert-dismissible"
								role="alert">
								<?php echo $message3; ?></div>
							<?php } ?>
						</center>
						
						<!--Form for creating folder -->
						<form name="folder_form" id="folder_form" action="create_folder.php?page=video"
						method="post" class="contact-form" enctype="multipart/form-data">
							
							<input name="name" id="name" style="width: 100%;" type="text" 
							placeholder="Enter Folder Name" /> <input type="submit"
							name="Folder" id="Folder" value="Create folder" />
						</form>
					</div>
					
				</div>
				
				<?php
				}
			?>	
			
			<br>
			<br>
			
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<center>
						<h2 class="page-title">Video Library. Current directory: <?php echo @$_SESSION ['current_directory'];  ?></h2>
					</center>
					
					<!-- Advanced Tables -->
					<div class="panel panel-default">
						<div class="panel-heading">Video List</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover"
								id="dataTables-example">
									<thead>
										<tr>
											<th>Name</th>
											<th>Size</th>
											<th>Type</th>
											<th>Play</th>
											<th>Download</th>
											<th>Delete</th>
											<th>Move</th>
											<th>Open</th>
										</tr>
									</thead>
									<tbody>
										<?php
											
											$query = mysql_query ( "select * from media where banned = '0' and (data_type ='.mp4' || data_type ='.wma' || data_type ='.avi' || data_type = '.videofolder') and user_id = '" . $_SESSION ['id'] . "' and media_path = '" . $_SESSION ['current_directory'] . "' " ); //
											if (! $query) { // add this check.
												die ( 'Invalid query: ' . mysql_error () );
											}
											
											while ( $row = mysql_fetch_array ( $query ) ) {
												$id1 = $row ['media_id'];
												$name = $row ['name'];
												$size = $row ['data_size'];
												$type = $row ['data_type'];
												$data_link = $row ['data_link'];
												$to_move = $row ['to_move'];
												$media_path = $row['media_path'];
												
											?>
											<tr class="odd gradeX">
												<td><?php echo $name;?></td>
												<td><?php echo $size;?>Mb</td>
												<td><?php echo $type;?></td>	
												<?php
													$check_size = mysql_query ( "select data_downloaded from registered_users where user_id='$id'" );
													while ( $row1 = mysql_fetch_array ( $check_size ) ) {
														$data_downloaded = $row1 ['data_downloaded'];
													}
													$total_data = $data_downloaded + $size;
													
													if ($banned == '1') {
													?>
													<td class="center">You are banned.Can't download.</td>
													<?php
														} else if ($status == 'Inactive' && $total_data > 10) {
														
													?>
													<td class="center">Your download limit exceeds.</td>
													<?php
														} else {
													?>
													
													
													<?php
														if ($type == ".videofolder") {
															// Is a folder
														?>
														<td class="center"><a class="btn btn-warning" id="btn-id" href="" disabled></a></td>
														<td class="center"><a class="btn btn-warning" id="btn-id" href="" disabled></a></td>
														<td class="center"><a class="btn btn-warning" href="delete_folder.php?id=<?php echo $id1;?>&page=video&media_path=<?php echo $media_path; ?>&name=<?php echo $name;?>&size=<?php echo $size;?>">Delete</a></td>
														
														<td class="center"><a class="btn btn-warning" href='move_to_folder.php?id=<?php echo $row['media_id'];?>&name=<?php echo $row['name'];?>&page=video&file_size = <?php echo $size;?>'>Move to</a></td>
														
														<td class="center"><a class="btn btn-warning" href='open_folder.php?name=<?php echo $name?>&page=video'>Open Folder</a></td>
														<?php
														} 
														else {
															// Is not a folder
														?>
														<td class="center"><a target="_blank" href="play_mp4.php?id=<?php echo $data_link; ?>" class="btn btn-warning">Play</a></td>
														<td class="center"><a target="_blank" class="btn btn-warning" on_click='' href="<?php echo $data_link;?>" download>Download</a></td>
														<td class="center"><a class="btn btn-warning" href="delete.php?id=<?php echo $row['media_id'];?>&page=video&size=<?php echo $size;?>">Delete</a></td>
														
														<?php
															if($to_move=='0'){
																//When button is clicked, sets to_move on media file in database to 1.
															?>
															<td class="center"><a class="btn btn-warning" id="btn-id"  href='to_move.php?move_id=<?php echo $id1;?>&page=video'>To Move</a></td>
															<td class="center"><a class="btn btn-warning" id="btn-id" href="" disabled></a></td>
															
															<?php
															}
															else{
															?>
															<td class="center"><a class="btn btn-warning" id="btn-id"  href='to_move.php?move_id=<?php echo $id1;?>&page=video'>Ready To Move </a></td>
															<td class="center"><a class="btn btn-warning" id="btn-id" href="" disabled></a></td>
															<?php
															}
															
														}
													} 
													?>
													</tr>
													<?php
												}
											?>
										</tbody>
									</table>
									
									<a class="btn btn-warning" href='previous_folder.php?page=video'>Previous Folder</a>
								</div>
								
							</div>
						</div>
						<!--End Advanced Tables -->
					</div>
				</div>
				
				
				From download.php 
				
					<!--Form for creating folder -->
				<div class="row">
					<div class="col-md-3"></div>
					<div class="col-md-6">
						<h2 class="page-title">Create Folder</h2>
						<center>
							<?php
								$message2 = @$_GET ['message2'];
								if (isset ( $message2 )) {
								?>
								<div class="alert alert-danger alert-dismissible" role="alert">
								<?php echo $message2; ?></div>
							<?php } ?>
						</center>
						<center>
							<?php
								$message = @$_GET ['message'];
								if (isset ( $message3 )) {
								?>
								<div class="alert alert-success alert-dismissible"
								role="alert">
								<?php echo $message3; ?></div>
							<?php } ?>
						</center>
						
						<!--Form for creating folder -->
						<form name="folder_form" id="folder_form" action="create_folder.php?page=audio"
						method="post" class="contact-form" enctype="multipart/form-data">
							
							<input name="name" id="name" style="width: 100%;" type="text" 
							placeholder="Enter Folder Name" /> <input type="submit"
							name="Folder" id="Folder" value="Create folder" />
						</form>
					</div>
					
				</div>
				<?php
				}
			?>	
			
			<br><br>
			
			<div class="row">
				<div class="col-md-2">
				</div>
                <div class="col-md-8">
					<center><h2 class="page-title">Audio Library <?php echo $current_directory; ?></h2></center>	
					
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
							Audio List
						</div>
						
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
											<th>Name</th>
											<th>Size</th>
											<th>Type</th>
											<th>Play</th>
											<th>Download</th>
											<th>Delete</th>
											<th>Move</th>
											<th>Open</th>
										</tr>
									</thead>
                                    <tbody>
										<?php
											
											$query = mysql_query ( "select * from media where banned = '0' and (data_type = '.mp3' || data_type = '.audiofolder') and user_id = '" . $_SESSION ['id'] . "' and media_path = '" . $_SESSION ['current_directory'] . "' " ); //
											while ($row = mysql_fetch_array($query))
											{	
												$id1 = $row ['media_id'];
												$name = $row ['name'];
												$size = $row ['data_size'];
												$type = $row ['data_type'];
												$data_link = $row ['data_link'];
												$to_move = $row ['to_move'];
												$media_path = $row['media_path']
												
											?>
											<tr class="odd gradeX">
												<td><?php echo $name;?></td>
												<td><?php echo $size;?>Mb</td>
												<td><?php echo $type;?></td>
												<?php
													$check_size = mysql_query("select data_downloaded from registered_users where user_id='$id'");
													while ($row1 = mysql_fetch_array($check_size)){
														$data_downloaded=$row1['data_downloaded'];
													}
													$total_data=$data_downloaded+$size;
													if($banned=='1'){
													?>
													<td class="center">You are banned.Can't download.</td>
													<?php
													}
													else if($status == 'Inactive' && $total_data>10){
														
													?>
													<td class="center">Your download limit exceeds.</td>
													<?php
														
													}
													else{
														
													?>
													
													<?php
														if ($type == ".audiofolder") {
															// Is a folder
														?>
														<td class="center"><a class="btn btn-warning" id="btn-id" href="" disabled></a></td>
														<td class="center"><a class="btn btn-warning" id="btn-id" href="" disabled></a></td>
														<td class="center"><a class="btn btn-warning" href="delete_folder.php?id=<?php echo $id1;?>&page=audio&media_path=<?php echo $media_path; ?>&name=<?php echo $name;?>&size=<?php echo $size;?>">Delete</a></td>
														
														<td class="center"><a class="btn btn-warning" href='move_to_folder.php?id=<?php echo $row['media_id'];?>&name=<?php echo $row['name'];?>&page=audio&file_size = <?php echo $size;?>'>Move to</a></td>
														
														<td class="center"><a class="btn btn-warning" href='open_folder.php?name=<?php echo $name?>&page=audio'>Open Folder</a></td>
														<?php
														} 
														else {
															// Is not a folder
														?>
														<td class="center"><a target="_blank"href="play_mp3.php?id=<?php echo $data_link; ?>" class="btn btn-warning">Play</a></td>
														<td class="center"><a target="_blank" class="btn btn-warning" on_click='' href="<?php echo $data_link;?>" download>Download</a></td>
														<td class="center"><a class="btn btn-warning" href="delete.php?id=<?php echo $row['media_id'];?>&page=audio&size=<?php echo $size;?>">Delete</a></td>
														
														<?php
															if($to_move=='0'){
																//When button is clicked, sets to_move on media file in database to 1.
															?>
															<td class="center"><a class="btn btn-warning" id="btn-id"  href='to_move.php?move_id=<?php echo $id1;?>&page=audio'>To Move</a></td>
															<td class="center"><a class="btn btn-warning" id="btn-id" href="" disabled></a></td>
															
															<?php
															}
															else{
															?>
															<td class="center"><a class="btn btn-warning" id="btn-id"  href='to_move.php?move_id=<?php echo $id1;?>&page=audio'>Ready To Move </a></td>
															<td class="center"><a class="btn btn-warning" id="btn-id" href="" disabled></a></td>
															<?php
															}
															
														}
													} 
													
												?>
												
											</tr>
											
											<?php
												
											}
										?>
									</tbody>
								</table>
								<a class="btn btn-warning" href='previous_folder.php?page=audio'>Previous Folder</a>
							</div>
							
						</div>
					</div>
					<!--End Advanced Tables -->
				</div>
			</div>
			
Arftifact 5: New uploading code for media files so it will be uploaded in the current directory. These can be found in upload_video upload_mp3.


					<?php
					$check = mysql_query("select name from media where name ='$name' AND data_type='$ext'  and user_id = '".$_SESSION['id']."'");
					$SongCount = mysql_num_rows($check);
					
					if($SongCount>0)
					{
						header("Location:blog.php?message1=This file already exists.");
						
					}
					
					else{
						
						
						
						
						$target_path = "videos/".$new_file_name;
						
						if(move_uploaded_file($_FILES['video_file']['tmp_name'], $target_path)) {
							
							$query_insert_users="UPDATE `registered_users` SET `data_uploaded`='$total_data' where user_id='$id'";
							mysql_query($query_insert_users);
							
							//getting the folder name so later the size can be deduced
							$exploded_dir = explode('/',$current_directory);
							$folder_name =$exploded_dir[sizeof($exploded_dir)-2]; //gets current folder name
							
							$insertquery ="INSERT INTO `media`(`user_id`, `name`, `data_type`, `data_link`, `data_size`, `media_path`) VALUES ('$id','$name','$ext','$target_path','$file_size','$current_directory')";
							if(mysql_query($insertquery)){
								if($folder_name != 'main'){
									$size_of_folder = $file_size + mysql_fetch_row(mysql_query("SELECT data_size FROM media WHERE name = '$folder_name' AND data_type = '.videofolder'"))[0];
									mysql_query("UPDATE media SET data_size = '$size_of_folder' WHERE user_id='$id' AND name = '$folder_name'");
									header("Location:blog.php?message1=Uploaded video successfully '$current_directory'.");
								}
								header("Location:blog.php?message=Uploaded video successfully '$current_directory'.");
								
							}
							
						}
					}
				?>
				
			In upload_mp3: 
			<?php
			$target_path = "songs/".$new_file_name;
							
							if(move_uploaded_file($_FILES['audio_file']['tmp_name'], $target_path)) {
								
								$query_insert_users="UPDATE `registered_users` SET `data_uploaded`='$total_data' where user_id='$id'";
								mysql_query($query_insert_users);
								
								//Below is code for getting the folder name so later the size can be deduced
								$exploded_dir = explode('/',$current_directory);
								$folder_name =$exploded_dir[sizeof($exploded_dir)-2]; //gets current folder name
								
								$insertquery ="INSERT INTO `media`(`user_id`, `name`, `data_type`, `data_link`, `data_size`, `media_path`) VALUES ('$id','$name','.mp3','$target_path','$file_size','$current_directory')";
								if(mysql_query($insertquery)){
									if($folder_name != 'main'){
										$size_of_folder = $file_size + mysql_fetch_row(mysql_query("SELECT data_size FROM media WHERE name = '$folder_name' AND data_type = '.audiofolder'"))[0];
										mysql_query("UPDATE media SET data_size = '$size_of_folder' WHERE user_id='$id' AND name = '$folder_name'");
									}
									header("Location:download.php?message=Uploaded audio successfully.");
									
								}
							}
			?>
			
			in ebooks upload file: 
			<?php
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
						?>




