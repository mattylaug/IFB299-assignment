<?php
	$con=mysql_connect("localhost", "root", "");
	
	if(!$con)
    die("error in data base conection");
	
	mysql_select_db('audio');
	
?>