<?php
$current_interval=120000;

if ($_POST["action"] == "update" || $_GET["action"] == "test") {
	
	if (!empty($_POST['interval_interval']) && is_int($_POST['interval_interval'])) {
		$current_interval=$_POST['interval_interval']*1000;
		$return_array["success"]="true";
	}
	
	
	$return_array["current_interval"]=$current_interval;
	echo json_encode($return_array);
	
	return;
	
} else if (!$_GET["action"] == "test") {
	$accuracy=$_POST['accuracy'];
	/*$altitude=$_POST['altitude'];*/
	$batterycharging=$_POST['batterycharging'];
	$batterystatus=$_POST['batterystatus'];
	$batterysupported=$_POST['batterysupported'];
	$chippresent=$_POST['chippresent'];
	/*$geolocation0=$_POST['geolocation0'];
	$geolocation1=$_POST['geolocation1'];
	$geolocation2=$_POST['geolocation2'];
	$geolocation3=$_POST['geolocation3'];
	$geolocation4=$_POST['geolocation4'];
	$geolocation5=$_POST['geolocation5'];
	$geolocation6=$_POST['geolocation6'];
	$geolocation7=$_POST['geolocation7'];*/
	$latitude=$_POST['latitude'];
	$longitude=$_POST['longitude'];
	$notes=$_POST['notes'];
	$timedatestamp=$_POST['timedatestamp'];
	$uid=$_POST['uid'];

	$alturl = "https://maps.googleapis.com/maps/api/elevation/json?locations=".$latitude.",".$longitude."&key=AIzaSyDc9hc6jgIxAvAyCSiCFhSdLSy6WVyW-ek";

if ($_GET["action"] == "test") {
	echo "Altitude URL: ".$alturl."<br/>";
}

	//Get altitude
	
	// Get cURL resource
	/*$curl = curl_init();
	$timeout = 10000;
	// Set some options - we are passing in a useragent too here
	curl_setopt($curl, CURLOPT_URL, $alturl);
	//curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($cURL, CURLOPT_HTTPGET, TRUE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); 
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,  2);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HEADER, 0);
	// Send the request & save response to $resp
	$altitude = curl_exec($curl);*/
	
	
	$result = json_decode(file_get_contents($alturl), true);
	$result = $result['results'][0];
	$altitude = $result['elevation'];
	
	
	// Close request to clear up some resources
	//curl_close($curl);
	
	if ($_GET["action"] == "test") {
		echo "Altitude: ".$altitude."<br/>";
	}
	

	$host="localhost"; // Host name 
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
	
	$query = mysql_query("insert into usagedata (uid,latitude,longitude,altitude,accuracy,batterycharging,batterystatus,  batterysupported,chippresent,timedatestamp,notes) values
	('$uid','$latitude','$longitude','$altitude','$accuracy','$batterycharging','$batterystatus',                       '$batterysupported','$chippresent','$timedatestamp','$notes')");
	
	if ($_GET["action"] == "test") {
		echo "Query: ".$query."<br/>";
	}
	
	$rows = mysql_fetch_array($query);
	
if ($_GET["action"] == "test") {
	echo "Response: ".$rows."<br/>";
	echo "TEST ENDED"."<br/>";
}	
	
	mysql_close($connection);
} else {
	echo "1";
	if (isset($_GET['interval_interval']) ? (int) $_GET['interval_interval'] : null) {
		echo "2";$current_interval=$_GET['interval_interval']*1000;
	}
	include("collect.php");
}
?>