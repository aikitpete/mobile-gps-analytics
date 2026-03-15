var current_location;

var myObj = new Object();

//var geocoder = new google.maps.Geocoder();

var elevator = new google.maps.ElevationService();

var battery;

//TEMP VARIABLES
/*var latitude;
var longitude;

var accuracy;

var altitude;
  	
var geolocation0;
var geolocation1;
var geolocation2;
var geolocation3;
var geolocation4;
var geolocation5;
var geolocation6;
var geolocation7;*/

function checkBattery() {


	myObj.batterycharging = battery.charging;
	myObj.batterystatus = battery.level;
	myObj.batterysupported = true;

}

function getElevation(current_location) {

	var locations = [];

	// Retrieve the clicked location and push it on the array
	locations.push(current_location);

	// Create a LocationElevationRequest object using the array's one value
	var positionalRequest = {
		'locations': locations
	}

	// Initiate the location request
	elevator.getElevationForLocations(positionalRequest, function(results, status) {
		if (status == google.maps.ElevationStatus.OK) {

			// Retrieve the first result
			if (results[0]) {
				return results[0];
			} else {
				return -2;
			}
		} else {
			return -3;
		}
	});
}


function GetLocation(location) {
	
	
	
	myObj.latitude = location.coords.latitude;
	myObj.longitude = location.coords.longitude;

	myObj.accuracy = location.coords.accuracy;

	//alert("Latitude: "+latitude);
	//alert("Longitude: "+longitude);
	//alert("Accuracy: "+accuracy);

	//current_location = new google.maps.LatLng(latitude, longitude);
	
	/*
	myObj.altitude = getElevation(current_location);
	*/
	
	/*
	geocoder.geocode({
		'latLng': current_location
	}, function(results, status) { 
		GetNames(results,status);
	});

	}

	function GetNames(results, status) {

	if (status == google.maps.GeocoderStatus.OK) {

		myObj.geolocation0 = results[0].formatted_address;
		myObj.geolocation1 = results[1].formatted_address;
		myObj.geolocation2 = results[2].formatted_address;
		myObj.geolocation3 = results[3].formatted_address;
		myObj.geolocation4 = results[4].formatted_address;
		myObj.geolocation5 = results[5].formatted_address;
		myObj.geolocation6 = results[6].formatted_address;
		myObj.geolocation7 = results[7].formatted_address;

	} else {
		alert("Geocoder failed due to: " + status);
	}
	*/

	/*alert("Latitude: "+latitude);
	    alert("Longitude: "+longitude);
	    alert("Accuracy: "+accuracy);
		alert("Altitude: "+altitude);*/

	//Check battery

	battery = navigator.battery || navigator.webkitBattery || navigator.mozBattery || navigator.msBattery;

	//alert("Charging: "+battery.charging);
	//alert("Level: "+battery.level);

	if (battery) {

		//checkBattery();
		battery.onlevelchange = checkBattery();

		// Add a few event listeners
		battery.addEventListener("chargingchange", function(e) {
			alert("Battery charge change: ", battery.charging);
		}, false);
		battery.addEventListener("chargingtimechange", function(e) {
			alert("Battery charge time change: ", battery.chargingTime);
		}, false);
		battery.addEventListener("dischargingtimechange", function(e) {
			alert("Battery discharging time change: ", battery.dischargingTime);
		}, false);
		battery.addEventListener("levelchange", function(e) {
			alert("Battery level change: ", battery.level);

		}, false);
	} else {

		myObj.batterycharging = false;
		myObj.batterystatus = -1;
		myObj.batterysupported = false;

	}

	myObj.chippresent = false;
	myObj.notes = "JS1.0," + navigator.userAgent;
	myObj.timedatestamp = new Date().toISOString().slice(0, 19).replace('T', ' ');
	myObj.uid = readCookie("user_id");

	/*myObj.latitude = latitude;
		myObj.longitude = longitude;

		myObj.accuracy = accuracy;

		myObj.altitude = altitude;
  	
		myObj.geolocation0 = geolocation0;
		myObj.geolocation1 = geolocation1;
		myObj.geolocation2 = geolocation2;
		myObj.geolocation3 = geolocation3;
		myObj.geolocation4 = geolocation4;
		myObj.geolocation5 = geolocation5;
		myObj.geolocation6 = geolocation6;
		myObj.geolocation7 = geolocation7;*/

	/*alert("Latitude: "+latitude);
	    alert("Longitude: "+longitude);
	    alert("Accuracy: "+accuracy);
		alert("Altitude: "+altitude);*/

	//store();

	//}

	//function store() {

	document.getElementById("accuracy").innerHTML = myObj.accuracy;
	//document.getElementById("altitude").innerHTML = myObj.altitude;
	document.getElementById("batterycharging").innerHTML = myObj.batterycharging;
	document.getElementById("batterystatus").innerHTML = myObj.batterystatus;
	document.getElementById("batterysupported").innerHTML = myObj.batterysupported;
	//document.getElementById("chippresent").innerHTML = myObj.chippresent;
	/*document.getElementById("geolocation0").innerHTML = myObj.geolocation0;
	document.getElementById("geolocation1").innerHTML = myObj.geolocation1;
	document.getElementById("geolocation2").innerHTML = myObj.geolocation2;
	document.getElementById("geolocation3").innerHTML = myObj.geolocation3;
	document.getElementById("geolocation4").innerHTML = myObj.geolocation4;
	document.getElementById("geolocation5").innerHTML = myObj.geolocation5;
	document.getElementById("geolocation6").innerHTML = myObj.geolocation6;
	document.getElementById("geolocation7").innerHTML = myObj.geolocation7;*/
	document.getElementById("latitude").innerHTML = myObj.latitude;
	document.getElementById("longitude").innerHTML = myObj.longitude;
	//document.getElementById("notes").innerHTML = myObj.notes;
	//document.getElementById("timedatestamp").innerHTML = myObj.timedatestamp;
	//document.getElementById("uid").innerHTML = myObj.uid;
	document.getElementById("jsonmessage").innerHTML = JSON.stringify(myObj);

	$.ajax({
		type: "POST",
		url: "usagedata.php",
		data: jQuery.param(myObj),
		success: function(html) {

		},
		beforeSend: function() {

		}
	});

}

function updateTimer() {
	$.ajax({
		type: "POST",
		url: "usagedata.php",
		data: "action=update&"+$("interval").serialize(),
		success: function(html) {
			//alert(html);
			var result = JSON.parse(html);
			//alert(result.current_interval);
			$("#current_interval").text((result.current_interval/1000));
		},
		beforeSend: function() {

		}
	});
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') c = c.substring(1, c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
	}
	return null;
}

function initialize() {
	//alert($("#interval").serialize());
	//updateTimer();
	//GPS myObj collection
	navigator.geolocation.getCurrentPosition(GetLocation);
	setInterval(function() {navigator.geolocation.getCurrentPosition(GetLocation);},20000);

}

google.maps.event.addDomListener(window, 'load', initialize);
