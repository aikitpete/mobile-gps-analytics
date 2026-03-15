var map;
//map = new google.maps.Map(document.getElementById('map-overlay'), mapOptions);


var LUND = new google.maps.LatLng(55.7038997,13.1935328);
var LUSEM = new google.maps.LatLng(55.710581,13.213371);
var STATION = new google.maps.LatLng(55.7068014,13.197996);
var TORGET = new google.maps.LatLng(55.7030733,13.1932168);
var HOSPITAL = new google.maps.LatLng(55.7117458,13.1985968);

var current_location;

var latitude;
var longitude;
var accuracy;

var geolocation0;
var geolocation1;
var geolocation2;
var geolocation3;
var geolocation4;
var geolocation5;
var geolocation6;
var geolocation7;

var geocoder;

var battery;

function checkBattery() {
	

	document.getElementById("batterycharging").innerHTML = battery.charging;
	document.getElementById("batterylevel").innerHTML = battery.level;
	document.getElementById("batterysupported").innerHTML = "Battery API is supported.";
	
		
}

function renderMap() {
	//Map rendering
	
  	var mapOptions = {
    	zoom: 14,
    	center: LUND,
    	mapTypeId: google.maps.MapTypeId.HYBRID
  	};
  	
  	map = new google.maps.Map(document.getElementById('map-overlay'), mapOptions);
  	
	/*
  	map.data.loadGeoJson('https://storage.googleapis.com/maps-devrel/google.json');
	
	var marker1 = new google.maps.Marker({
    	map:map,
    	draggable:true,
    	animation: google.maps.Animation.DROP,
    	position: LUND,
		title:"Lund Municipality"
  	});
  	
  	var marker2 = new google.maps.Marker({
    	map:map,
    	draggable:true,
    	animation: google.maps.Animation.DROP,
    	position: LUSEM,
		title:"Hello World!"
  	});
  	
  	var marker3 = new google.maps.Marker({
    	map:map,
    	draggable:true,
    	animation: google.maps.Animation.DROP,
    	position: STATION,
		title:"Hello World!"
  	});
  	
  	var marker4 = new google.maps.Marker({
    	map:map,
    	draggable:true,
    	animation: google.maps.Animation.DROP,
    	position: TORGET,
		title:"Hello World!"
  	});
  	
  	var marker5 = new google.maps.Marker({
    	map:map,
    	draggable:true,
    	animation: google.maps.Animation.DROP,
    	position: HOSPITAL,
		title:"Hello World!"
  	});
  	
  	var currentMarker = new google.maps.Marker({
    	map:map,
    	draggable:false,
    	animation: google.maps.Animation.DROP,
    	position: current_location,
		title:"CURRENT LOCATION!"
  	});
  	
  	var trafficLayer = new google.maps.TrafficLayer();
  	trafficLayer.setMap(map);
  
  	var bikeLayer = new google.maps.BicyclingLayer();
  	bikeLayer.setMap(map);
  	
  	var transitLayer = new google.maps.TransitLayer();
  	transitLayer.setMap(map);
  	
  	var contentString = '<div id="content">'+
      '<div id="siteNotice">'+
      '</div>'+
      '<h1 id="firstHeading" class="firstHeading">Uluru</h1>'+
      '<div id="bodyContent">'+
      '<p><b>Lund Municipality</b> - Wolcome to Lund Municipality</p>'+
      '</div>'+
      '</div>';

  var infowindow = new google.maps.InfoWindow({
      content: contentString
  });

  google.maps.event.addListener(marker1, 'click', function() {
    infowindow.open(map,marker1);
  });
  infowindow.open(map,marker1);
	
	// To add the marker to the map, call setMap();
	//marker.setMap(map);
	
	google.maps.event.addListener(marker1, 'click', toggleBounce);
	
	var heatMapData = [
 		{location: new google.maps.LatLng(55.712,13.185328), weight: 0.5}, new google.maps.LatLng(55.7038993,13.1935377),
   		{location: new google.maps.LatLng(55.709,13.183532), weight: 2},
  		{location: new google.maps.LatLng(55.71899,13.19328), weight: 3},
		{location: new google.maps.LatLng(55.729,13.203532), weight: 2}, new google.maps.LatLng(55.703892,13.1935666),
  		{location: new google.maps.LatLng(55.71,13.2035328), weight: 0.5},
  		{location: new google.maps.LatLng(55.717,13.213532), weight: 3},
  		{location: new google.maps.LatLng(55.697,13.2135328), weight: 2}, new google.maps.LatLng(55.703896,13.193588),
  		{location: new google.maps.LatLng(55.6989,13.21), weight: 0.5}, new google.maps.LatLng(55.703847,13.19355),
	  	{location: new google.maps.LatLng(55.699,13.2035328), weight: 2},
	  	{location: new google.maps.LatLng(55.7,13.2033532), weight: 3}
	];
	
	var heatmap = new google.maps.visualization.HeatmapLayer({
	  data: heatMapData
	});
	heatmap.setMap(map);
	*/
}

function GetLocation(location) {
	
	geocoder = new google.maps.Geocoder();
	
    latitude = location.coords.latitude;
    longitude = location.coords.longitude;
    accuracy = location.coords.accuracy;
    
    //alert("Latitude: "+latitude);
    //alert("Longitude: "+longitude);
    //alert("Accuracy: "+accuracy);
	
	current_location = new google.maps.LatLng(latitude,longitude);
	geocoder.geocode({'latLng': current_location}, function(results, status)  {

      if (status == google.maps.GeocoderStatus.OK) {
      	
      	geolocation0 = results[0].formatted_address;
      	geolocation1 = results[1].formatted_address;
      	geolocation2 = results[2].formatted_address;
      	geolocation3 = results[3].formatted_address;
      	geolocation4 = results[4].formatted_address;
      	geolocation5 = results[5].formatted_address;
      	geolocation6 = results[6].formatted_address;
      	geolocation7 = results[7].formatted_address;
       
		if (document.getElementById("geolocation0")) {
			document.getElementById("geolocation0").innerHTML = geolocation0;
			document.getElementById("geolocation1").innerHTML = geolocation1;
			document.getElementById("geolocation2").innerHTML = geolocation2;
			document.getElementById("geolocation3").innerHTML = geolocation3;
			document.getElementById("geolocation4").innerHTML = geolocation4;
			document.getElementById("geolocation5").innerHTML = geolocation5;
			document.getElementById("geolocation6").innerHTML = geolocation6;
			document.getElementById("geolocation7").innerHTML = geolocation7;
			
			document.getElementById("latitude").innerHTML = latitude;
			document.getElementById("longitude").innerHTML = longitude;
			document.getElementById("accuracy").innerHTML = accuracy;
		}
		
      } else {
        alert("Geocoder failed due to: " + status);
      }
    });
    
    renderMap();
}

function initialize() {
	
	//Check battery
	
	battery = navigator.battery || navigator.webkitBattery || navigator.mozBattery || navigator.msBattery;

	//alert("Charging: "+battery.charging);
	//alert("Level: "+battery.level);

	if (battery) {
		checkBattery();
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
		if (document.getElementById("batterysupported"))
		document.getElementById("batterysupported").innerHTML = "Battery API not supported.";
	}

	
	//GPS data collection
	
	navigator.geolocation.getCurrentPosition(GetLocation);
	
}

function toggleBounce() {

  if (marker.getAnimation() != null) {
    marker.setAnimation(null);
  } else {
    marker.setAnimation(google.maps.Animation.BOUNCE);
  }
}

google.maps.event.addDomListener(window, 'load', initialize);