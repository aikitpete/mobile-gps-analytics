<?php
session_start(); // Starting Session
$reg_error=''; // Variable To Store Error Message
if (empty($_POST['reg_name']) || empty($_POST['reg_surname']) || empty($_POST['reg_email']) || empty($_POST['reg_password']) || empty($_POST['reg_password2'])) {
		if (isset($_POST['reg_submit'])) {
			$reg_error = "Input is invalid";
		} else {
			include("signup.php");
		}
}
else
{
		// Define $username and $password
		$name=$_POST['reg_name'];
		$surname=$_POST['reg_surname'];
		$email=$_POST['reg_email'];
		$password=$_POST['reg_password'];
		$password2=$_POST['reg_password2'];
		$feedback=$_POST['reg_feedback'];
		$category=$_POST['reg_category'];//"usability_analyst";
		
		/*echo $name."<br/>";
		echo $surname."<br/>";
		echo $email."<br/>";
		echo $password."<br/>";
		echo $password2."<br/>";
		echo $feedback."<br/>";
		echo $category."<br/>";*/
		
		
		if (strcmp($password, $password2) == 0) {
			$reg_error = "Passwords don't match";
		}

		// To protect MySQL injection for Security purpose
		//$email = stripslashes($email);
		$password = stripslashes($password);
		//$email = mysql_real_escape_string($email);
		$password = mysql_real_escape_string($password);

		$host="localhost"; // Host name 
		$db_username="root"; // Mysql username 
		$db_password="danilo";//"Z4CseYjs"; // Mysql password 
		$db_name="demola"; // Database name 
		$tbl_name="users"; // Table name 
		
		// Connect to server and select databse.
		$connection = mysql_connect("$host", "$db_username", "$db_password")or die("cannot connect"); 
		mysql_select_db("$db_name")or die("cannot select DB");
		mysql_set_charset("utf8");

		// SQL query to insert information about new user into database.
		$query = mysql_query("insert into users (name, surname, email, password, feedback, category) values ('$name', '$surname', '$email', '$password', '$feedback', '$category')")or die(mysql_error());
		$rows = mysql_fetch_array($query);

		if (empty($rows)) {

			mysql_close($connection); // Closing Connection
			//header("location: index.php");
			echo "<h3>Registration successful!</h3>";
		} else {
	
			$reg_error = $rows;
		}
		
}

?>