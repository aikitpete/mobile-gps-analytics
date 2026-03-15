<?php
	
	function connectDatabase($tblName) {
	
		$host="localhost"; // Host name 
		$db_username="root"; // Mysql username 
		$db_password="danilo";//"Z4CseYjs"; // Mysql password 
		$db_name="demola"; // Database name 
		$tbl_name="tblName"; // Table name 

		// Connect to server and select databse.
		$connection = mysql_connect("$host", "$db_username", "$db_password")or die("cannot connect"); 
		mysql_select_db("$db_name")or die("cannot select DB");
		mysql_set_charset("utf8");
	
	}
	
	function getHeaders() {
		
		$result = mysql_query('SELECT column_name FROM information_schema.columns WHERE table_name = "usagedata"');
		
		if(mysql_num_rows($result)){
	    	echo '"headers":[';

	    	$first = true;
	    	//$row=mysql_fetch_assoc($result);
	    	while($row=mysql_fetch_row($result)){
	        	//  cast results to specific data types

	        	if($first) {
	            	$first = false;
	        	} else {
	            	echo ',';
	        	}
	        	echo json_encode($row);
	    	}
	    	echo ']';
		} else {
	    	echo '[]';
		}
		
		mysql_free_result($query);
	
	}
	
	function getData() {
		
		if (isset($_GET["limit"])) { $limit  = $_GET["limit"]; } else { $limit=20; }; 
	
		if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
		$start_from = ($page-1) * $limit;
				
		$result = mysql_query("select * from usagedata  ORDER BY timedatestamp DESC  LIMIT $start_from, $limit");
	
		if(mysql_num_rows($result)){
	    	echo '"data":[';

	    	$first = true;
	    	//$row=mysql_fetch_assoc($result);
	    	while($row=mysql_fetch_row($result)){
	        	//  cast results to specific data types

	        	if($first) {
	            	$first = false;
	        	} else {
	            	echo ',';
	        	}
	        	echo json_encode($row);
	    	}
	    	echo ']';
		} else {
	    	echo '[]';
		}
		
		mysql_free_result($query);
	}
	
	function getLocations() {
		
		if (isset($_GET["uid"])) { 
			$uid  = $_GET["uid"];
			$result = mysql_query("select latitude,longitude from usagedata WHERE uid=$uid ORDER BY timedatestamp DESC");
		} else {
			$result = mysql_query("select latitude,longitude from usagedata ORDER BY timedatestamp DESC");
		};
				
		
	
		if(mysql_num_rows($result)){
	    	echo '"locations":[';

	    	$first = true;
	    	//$row=mysql_fetch_assoc($result);
	    	while($row=mysql_fetch_row($result)){
	        	//  cast results to specific data types

	        	if($first) {
	            	$first = false;
	        	} else {
	            	echo ',';
	        	}
	        	echo json_encode($row);
	    	}
	    	echo ']';
		} else {
	    	echo '[]';
		}
		
		mysql_free_result($query);
	}
	
	function getMeta() {
		
		if (isset($_GET["limit"])) { $limit  = $_GET["limit"]; } else { $limit=20; }; 
	
		if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
		$start_from = ($page-1) * $limit;
		
		$result = mysql_query("select count(*) from usagedata");
		$row=mysql_fetch_row($result);
		$total=floor($row[0]/$limit);
		$total=$total+(($row[0]%$limit)>0);
				
		echo '"meta":{"page":['.$limit.'],"current":['.$page.'],"total":['.$total.']}';
		
		mysql_free_result($query);
	}
	
	function deleteRecord() {
		$id  = $_GET["id"];
		$result = mysql_query("DELETE FROM usagedata WHERE id=".$id.";");
	}
	
	echo "{";
	
	if ($_GET["action"] == "update") {
		
		connectDatabase("usagedata");
		getData();
		echo ", ";
		getMeta();
	
	} else if ($_GET["action"] == "headers") {
		
		connectDatabase("usagedata");
		getHeaders();
	
	} else if ($_GET["action"] == "locations") {
		
		connectDatabase("usagedata");
		getLocations();
	
	} else if ($_GET["action"] == "delete") {
		
		connectDatabase("usagedata");
		deleteRecord();
	
	} else {
		
		connectDatabase("usagedata");
		getHeaders();
		echo ", ";
		getData();
		echo ", ";
		getMeta();
		
	}
	
	echo "}";

?>