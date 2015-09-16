<?php 
include('database_connection.php');

$id = $_GET['id']; 


mysql_query("DELETE FROM `media` WHERE media_id='$id'");
mysql_query("DELETE FROM `registered_users` WHERE user_id='$id'");


header("Location: users.php"); /** redirect to delete.php **/


?>