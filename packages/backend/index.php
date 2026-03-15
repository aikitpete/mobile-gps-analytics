<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>

	<link rel="stylesheet" href="style.css">

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Cyclists and the City Home</title>
	
	<link type="text/css" rel="stylesheet" charset="UTF-8" href="style.css">
	<link type="text/css" rel="stylesheet" charset="UTF-8" href="menu.css">
	<link rel="stylesheet" href="tablesorter.css" type="text/css" media="print, projection, screen" />
	
	<!--<link rel="icon" href="/favicon.ico">
	
	<link type="text/css" rel="stylesheet" charset="UTF-8" href="generic.css" disabled>
	<link type="text/css" rel="stylesheet" charset="UTF-8" href="style.css" disabled>
	<link type="text/css" rel="stylesheet" charset="UTF-8" href="mobile.css" disabled>
	<link type="text/css" rel="stylesheet" charset="UTF-8" href="tablet.css" disabled>
	<link type="text/css" rel="stylesheet" charset="UTF-8" href="desktop.css" disabled>
	
	<script type="text/javascript" src="modifyContent.js"></script>	-->
	
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=visualization&sensor=false"></script>
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.1.js"></script>
	<script type="text/javascript" src="jquery.tablesorter.min.js"></script>
	
	
	

</head>

<body style="overflow:visible">
	
	<?php include("menuarea.php"); ?>
	
	
	
	<?php
	
	if ($_GET["action"] == "admin") {
		
		//include("login.php");
		include("usagedata.php");
		include("view.php");
		include("data.php");
		include("analyze.php");
		//include("register.php");
	
	} else if ($_GET["action"] == "view" && isset( $_COOKIE['user_id'])) {
		
		include("view.php");
	
	} else if ($_GET["action"] == "data" && isset( $_COOKIE['user_id'])) {
		
		include("data.php");
	
	} else if ($_GET["action"] == "analyze" && isset( $_COOKIE['user_id'])) {
		
		include("analyze.php");
	
	} else if ($_GET["action"] == "collect" && isset( $_COOKIE['user_id'])) {
		
		include("usagedata.php");
	
	} else if ($_GET["action"] == "signup") {
		
		include("register.php");
	
	} else if ($_GET["action"] == "signin") {
		
		//include("login.php");
	
	} else {
		
		include("intro.php");
	
	}
	?>
	
	
</body>

</html>