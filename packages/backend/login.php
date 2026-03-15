<?php
session_start(); // Starting Session
$login_error=''; // Variable To Store Error Message

//TEST
//print_r($_REQUEST);

if (isset( $_COOKIE['user_id'] )) {
	include("logout.php");
} 
elseif (empty($_POST['login_email']) || empty($_POST['login_password']))
{
	if (isset($_POST['login_submit'])) {
		$login_error = "Email or Password is invalid";
	} else {
		include("signin.php");
	}
}
else
{
	// Define $username and $password
	$email=$_POST['login_email'];
	$password=$_POST['login_password'];
	// To protect MySQL injection for Security purpose
	$password = stripslashes($password);
	$password = mysql_real_escape_string($password);
	
	//echo $email;
	//echo $password;

	$host="localhost"; // Host name 
	$db_username="root"; // Mysql username 
	$db_password="danilo";//"Z4CseYjs"; // Mysql password 
	$db_name="demola"; // Database name 
	$tbl_name="users"; // Table name 

	// Connect to server and select databse.
	$connection = mysql_connect("$host", "$db_username", "$db_password")or die("cannot connect"); 
	mysql_select_db("$db_name")or die("cannot select DB");
	mysql_set_charset("utf8");

	// SQL query to fetch information of registerd users and finds user match.
	$query = mysql_query("select * from users where password='$password' AND email='$email'", 	$connection);
	$rows = mysql_fetch_array($query);

	if (!empty($rows)) {

		setcookie('user_name', $rows['name'], time() + (3600 * 24 * 30));
		setcookie('user_id', $rows['uid'], time() + (3600 * 24 * 30));

		//$_SESSION['login_user']=$email; // Initializing Session
		header("location: index.php"); // Redirecting To Other Page
	
	} else {
	
		$login_error = "Email or Password is invalid";
	
	}
	mysql_close($connection); // Closing Connection
}
?>