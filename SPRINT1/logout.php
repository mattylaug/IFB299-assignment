<?php
	session_start();
	unset($_SESSION['name']);
	unset($_SESSION['id']);
	unset($_SESSION['status']);
	session_destroy();
	header("Location:index.php");
?>