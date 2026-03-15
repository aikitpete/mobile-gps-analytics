<?php
	
	if ($_GET["action"] == "test") {
		echo "DEBUG MODE"."<br/>";
	}

	$host="localhost"; // Host name 
	$db_username="root"; // Mysql username 
	$db_password="danilo";//"Z4CseYjs"; // Mysql password 
	$db_name="demola"; // Database name 
	$tbl_name="users"; // Table name 
	
	if ($_GET["action"] == "test") {
		echo "CONNECTING"."<br/>";
	}
	
	// Connect to server and select databse.
	$connection = mysql_connect("$host", "$db_username", "$db_password")or die("cannot connect"); 
	mysql_select_db("$db_name")or die("cannot select DB");
	mysql_set_charset("utf8");
	
	if ($_GET["action"] == "test") {
		echo "CONNTECTED"."<br/>";
	}
				
	$query = mysql_query('select uid,name,surname from users');
	
	if ($_GET["action"] == "test") {
		echo "WRITING OUTPUT"."<br/>";
	}
	
	if ($_GET["action"] == "test") {
		echo $query."<br/>";
	}
	
	while ($array = mysql_fetch_array($query, MYSQL_BOTH)) {
	    echo '<input type="checkbox" onchange="updateMap();" class="mapuser" value="'.$array[0].'" checked>'.$array[1].' '.$array[2].'<br/>';  
	}
	
	mysql_free_result($query);
?>

