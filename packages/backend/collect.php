<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
	<head>
		<script type="text/javascript" src="collect.js">
</script>
		<title></title>
	</head>
	<body>
		<div>
			<h3>Current interval: (seconds)</h3>
			<span id="current_interval"><?php echo $current_interval/1000; ?></span>
			<br/><br/>
			<fieldset>
				<legend>Time Interval</legend>
				<form id="interval" name="interval" action="" method="POST">
					<label>New interval:</label> <input id="interval_interval" name="interval_interval" placeholder="" type="text"> <input name="interval_submit" type="submit" value=" Submit "> <span><?php echo $interval_error; ?></span>
				</form>
			</fieldset>
		</div>
		<div>
			<!--<h3>Your location: </h3><span id="location"></span> 
						<span id="geolocation0">N/A</span><br/>
						<span id="geolocation1">N/A</span><br/>
						<span id="geolocation2">N/A</span><br/>
						<span id="geolocation3">N/A</span><br/>
						<span id="geolocation4">N/A</span><br/>
						<span id="geolocation5">N/A</span><br/>
						<span id="geolocation6">N/A</span><br/>
						<span id="geolocation7">N/A</span><br/>-->
			<h3>
				Latitude:
			</h3><span id="latitude">N/A</span>
			<h3>
				Longtitude:
			</h3><span id="longitude">N/A</span>
			<h3>
				Accuracy:
			</h3><span id="accuracy">N/A</span>
			<h3>
				Battery level:
			</h3><span id="batterycharging">N/A</span><br>
			<span id="batterystatus">N/A</span><br>
			<span id="batterysupported">N/A</span><br>
			<h3>
				JSON:
			</h3><span id="jsonmessage">N/A</span><br>
		</div>
	</body>
</html>
