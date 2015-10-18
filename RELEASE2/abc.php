<?php
	session_start();
	include "db.php";
	
	if (isset($_POST['submit']))
	{
		if(!empty($_POST))
		{
			$email = $_POST['email'];
			$password = md5($_POST['password']);
			
			if(empty($_POST['email'])||empty($_POST['password'])){
				
				header("Location:login.php?message=Please fill all the fields");
			}
			else{
				
				
				$sql = mysql_query("SELECT * FROM registered_users WHERE email='$email' AND password='$password'");
				$row = mysql_fetch_array($sql);
				
				$id = $row['user_id'];
				$status = $row['status'];
				$name = $row['first_name'];
				$email = $row['email'];
				$banned = $row['banned'];
				
				
				if(!$sql){echo"error here";}
				$existCount = mysql_num_rows($sql);
				
				if($existCount == 1)
				{
					
					
					
					
					$_SESSION['id'] = $id;
					$_SESSION['name'] = $name;
					$_SESSION['status'] = $status;
					$_SESSION['email'] = $email;
					$_SESSION['banned'] = $banned;
					
					if($banned=='1')
					{
						header("Location:login.php?message=Your account has been blocked");
					}
					else
					{
						
						header("Location:index.php");
					}
				}
				else{  
					
					header("Location:login.php?message=Wrong username or password");
				}
				
			}
		}
	}
	else{
	}
?>