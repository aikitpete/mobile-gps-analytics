<html>
<head>
	
	<script src="view.js"></script>
	<script src="updatemap.js"></script>
</head>
<body>
	<div style="overflow:hidden; height:80%;width:100%">
			<div id="theMap" style="height:100%;width:70%;float:left">
 				<div id="map-overlay" style="height:100%"> 
    				<iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><br>
    			</div>
			</div>
			<div id="mapcontrol" style="height:100%;width:30%;float:right">
				<h3>Select Users:</h3>
				<?php include("users.php"); ?>
			</div>
	</div>
</body>	
</html>