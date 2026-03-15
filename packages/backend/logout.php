<?php
session_start();
if (isset($_POST['submit'])) {
	if(session_destroy()) // Destroying All Sessions
	{
		unset($_COOKIE['user_name']);
		unset($_COOKIE['user_id']);
	
		setcookie('user_name', '', time() - 3600);
		setcookie('user_id', '', time() - 3600);
	
		header("Location: index.php"); // Redirecting To Home Page
	}
} else {
	include("signout.php");
}
?>