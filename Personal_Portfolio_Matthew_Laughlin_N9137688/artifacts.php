Comments on artifact 1

Description: This is responsible for retriving data for media files from the database, this data is used later for filling the page full of the user's media to allow the user to see what they can download, 
and creating a data link for later download use. In this case it's for the audio page. This is from download.php.


<?php
									
									$query = mysql_query("select * from media where data_type ='.mp3' and banned = '0' and user_id = '".$_SESSION['id']."'");
									while ($row = mysql_fetch_array($query))
									{
									$name = $row['name'];
									$size = $row['data_size'];
									$type = $row['data_type'];
									$data_link = $row['data_link'];
									
									?>
                                        
Comments on artifact 2:

Description: This is UI for playing audio files. Uses the link created previously which is used to play the file. This is from download.php.

						<tr class="odd gradeX">
                                            <td><?php echo $name;?></td>
                                            <td><?php echo $size;?>Mb</td>
                                            <td>mp3</td>
                                            <td class="center"><a target="_blank"href="play_mp3.php?id=<?php echo $data_link; ?>" class="btn btn-warning">Play</a></td>	
											

Comments on artifact 3: 

Description: This one section of the code for downloading audio, and allowing/disallowing downloading depending on the user's priveleges. Also some basic UI for deleting. This is from download.php.


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
											<td class="center"><a target="_blank"  class="btn btn-warning" on_click='' href="<?php echo $data_link;?>" download>Download</a></td>
											<td><a  class="btn btn-warning"  href="delete.php?id=<?php echo $row['media_id'];?>&page=mp3">Delete</a></td>
											<?php
											}
											
											?>
											
                                        </tr>
                                        
										<?php
										
										}
										?>
										
Comments on artifact 4:

Description: This is the code for viewing videos, making use of a HTML video player. This code is also used for audio files given this player can also play mp3 files. This is from play_mp4.php

<script type="text/javascript">

$(document).ready(function(){

    /* Get iframe src attribute value i.e. YouTube video url

    and store it in a variable */

    var url = $(".play_video").attr('src');

   // alert(url);

    /* Assign empty url value to the iframe src attribute when

    modal hide, which stop the video playing */

    $("#myModal").on('hide.bs.modal', function(){

        $("#cartoonVideo").attr('src', '');

    });
//     $("#myModal").on('hidden.bs.modal', function (e) {
 
//  $("#myModal iframe").attr("src", $("#myModal iframe").attr("src"));
// });

    

    /* Assign the initially stored url back to the iframe src

    attribute when modal is displayed again */
    
        $("#myModal").on('show.bs.modal', function(){

        $("#cartoonVideo").attr('src', url);

    });

});

</script>

Comments on artifact 5:

Description: UI for downloading videos, and the listing UI. This is to allow the user to see their video files in an organized way. This is from blog.php.

<center><h2 class="page-title">Video Library</h2></center>	

                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Video List
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
                                        </tr>
                                    </thead>
									