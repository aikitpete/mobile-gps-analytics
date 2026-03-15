var map;
//map = new google.maps.Map(document.getElementById('map-overlay'), mapOptions);


var LUND = new google.maps.LatLng(55.7038997, 13.1935328);
var LUSEM = new google.maps.LatLng(55.710581, 13.213371);
var STATION = new google.maps.LatLng(55.7068014, 13.197996);
var TORGET = new google.maps.LatLng(55.7030733, 13.1932168);
var HOSPITAL = new google.maps.LatLng(55.7117458, 13.1985968);

var markers = [];

function updateMap() {

	deleteMarkers();

	var currentColor = 0;
	
	$(".mapuser").each(function(currentColor, pinColors, markers, handleData) {

		//alert(currentColor);
		//alert(pinColors);
		//alert(markers);

		currentColor++;
		

		if ($(this).prop('checked') == true) {
			
			$.ajax({
				type: "GET",
				url: "usage.php?action=locations&uid=" + $(this).attr("value"),
				success: function(html) {
					var pinColors = ["FF0000", "00FF00", "0000FF", "FF00FF", "FFFF00", "00FFFF", "000FFF", "FFF000"];

					//alert("C"+pinColors[currentColor]);
					
					var result = JSON.parse(html);

					var pinColor = pinColors[currentColor];
					var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor);
					
					
					
					for (var i = 0; i < result.locations.length; i++) {
						var position = result.locations[i];

						var current = new google.maps.LatLng(position[0], position[1]);
						
						var marker = new google.maps.Marker({
							map: map,
							draggable: false,
							//animation: google.maps.Animation.DROP,
							position: current,
							icon: pinImage
						});
						//alert("there");
						//markers.push(marker);
						handleMarkers(marker);
						
					}
					//alert(markers);

				}
			});
		}
		
	});
	
	//alert(markers);
}

function handleMarkers(marker) {
	markers.push(marker);
	//alert(markers.length);
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


function initialize() {
	renderMap();
	updateMap();
}

function toggleBounce() {

	if (marker.getAnimation() != null) {
		marker.setAnimation(null);
	} else {
		marker.setAnimation(google.maps.Animation.BOUNCE);
	}
}

// Sets the map on all markers in the array.

function setAllMap(newMap) {
	//alert(markers.length+"TEST");
	var marker;
	while (marker = markers.pop()) {
		//alert("BEFORE222");
		marker.setMap(null);
		//alert("AFTER222");
	}
	
}

// Removes the markers from the map, but keeps them in the array.

function clearMarkers() {
	setAllMap(null);
}

// Shows any markers currently in the array.

function showMarkers() {
	setAllMap(map);
}

// Deletes all markers in the array by removing references to them.

function deleteMarkers() {
	clearMarkers();
	markers = [];
}






google.maps.event.addDomListener(window, 'load', initialize);
