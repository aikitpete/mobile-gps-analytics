<?php
if (!$_GET["action"] == "test") {

} else {

}	

if ($_GET["action"] == "test") {

}

	$db_username="root"; // Mysql username 
	$db_password="danilo";//"Z4CseYjs"; // Mysql password 
	$db_name="demola"; // Database name 
	$tbl_name="usagedata"; // Table name 

	// Connect to server and select databse.
	$connection = mysql_connect("$host", "$db_username", "$db_password")or die("cannot connect"); 
	mysql_select_db("$db_name")or die("cannot select DB");
	mysql_set_charset("utf8");
	
	if ($_GET["action"] == "test") {
		echo "Connection: ".$connection."<br/>";
	}
	

	$query = mysql_query("select * from users where uid=$activeUser");
	
	if ($_GET["action"] == "test") {
		echo "Query: ".$query."<br/>";
	}
	
	$rows = mysql_fetch_array($query);
	
if ($_GET["action"] == "test") {
	echo "Response: ".$rows."<br/>";
	echo "TEST ENDED"."<br/>";
}	
	
	mysql_close($connection);
?>