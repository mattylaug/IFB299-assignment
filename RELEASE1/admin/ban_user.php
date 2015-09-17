<?php 
include('database_connection.php');

$id = $_GET['id']; 

		$result = mysql_query("SELECT banned FROM registered_users WHERE user_id='$id'");
						if(!$result){
						echo "error".mysql_error();
						}


//mysql_query("DELETE FROM `users` WHERE user_id='$id'");

		while($row = mysql_fetch_array($result)){
						  $banned=$row['banned'];
						  }
						  //echo $banned;
		if($banned === '1'){
			mysql_query("UPDATE `registered_users` SET `banned`= 0 WHERE user_id='$id'");
		}
		else{
			mysql_query("UPDATE `registered_users` SET `banned`= '1' WHERE user_id='$id'");
		}


header("Location: users.php");


?>