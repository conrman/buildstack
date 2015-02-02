var infowindow;
var map;

var category = "food";

var catchmentDiameter = 1.75;

var disableGeolocation = false;

//Used to track which Google InfoWindow is currently open
var openWindow;

var markers = [];

var POIs = {}; // Keep track of all the venues we've added to the map

//infoWindow close icon
var infoClose = "";
var closePosition = "0";
var mapStyles = [ { "stylers": [ { "saturation": -100 } ] } ];

var defaultZoom = 13;
var defaultLatLng = new google.maps.LatLng(defaultLat, defaultLng); //create the geolocation position
var mapCenter = defaultLat + ', ' + defaultLng;

window.loadMap = function() {
	//set the config options for the map
	var myOptions = {
		zoom: defaultZoom,
		minZoom: 11,
		maxZoom: 19,
		center: new google.maps.LatLng(defaultLat, defaultLng),
		styles: mapStyles,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		mapTypeControl: false,
		disableDefaultUI: true,
		panControl: false,
		panControlOptions: {
			position: google.maps.ControlPosition.TOP_LEFT
		},
		zoomControl: false,
		zoomControlOptions: {
			style: google.maps.ZoomControlStyle.LARGE,
			position: google.maps.ControlPosition.TOP_LEFT
		},
		scrollwheel: false
	};
	map = new google.maps.Map(document.getElementById('map-canvas'), myOptions);
	
	// var mapControlDiv = document.createElement('div');
	// var mapControl = new mapNav(mapControlDiv, map);
	// map.controls[google.maps.ControlPosition.TOP_RIGHT].push(mapControlDiv);
	
	var homeMarker = new google.maps.Marker({
		map: map,
		position: new google.maps.LatLng(defaultLat,defaultLng),
		icon : templateDirectory+'/assets/images/icon_marker_home.png',
		url: 'http://www.google.com/maps/place/' + defaultAddress,
		zIndex: 9000
	});

	google.maps.event.addListener(homeMarker, 'click', function() {
		window.open(this.url);
	});
};

window.updateMapOptions = function(options) {    
	this.map.setOptions(options);
};

window.drawPolygon = function(map) {
	var myCoordinates = [
	];

	var polyOptions = {
		path: myCoordinates,
		strokeColor: "#b13d5f",
		strokeOpacity: 0.8,
		strokeWeight: 2,
		fillColor: "#b13d5f",
		fillOpacity: 0.6
	};

	var it = new google.maps.Polygon(polyOptions);
	it.setMap(map);
};

window.showCategory = function(category) {
	resetMap();

	for (var i = 0; i < markers.length; i++) {
		if (markers[i].POI.category === category) {
			markers[i].setVisible(true);
		}
	}
};

window.mapPan = function(direction) {
	var newLat = map.getCenter().lat();
	var newLng = map.getCenter().lng();

	switch(direction){
		case 'n':
		newLat = newLat + 0.005;
		break;
		case 'w':
		newLng = newLng - 0.005;
		break;
		case 'e':
		newLng = newLng + 0.005;
		break;
		case 's':
		newLat = newLat - 0.005;
		break;
	}

	map.panTo(new google.maps.LatLng(newLat, newLng));
};

window.mapZoom = function(zoom) {
	map.setZoom(map.getZoom() + zoom);
};

window.mapReset = function() {
	map.setZoom(defaultZoom);
	map.panTo(defaultLatLng);
};

window.resetMap = function() {
	if (openWindow) {
		openWindow.infowindow.close();
	}

	POIs = {}; // Reset our stored list of venues
	for (var i = 0; i < markers.length; i++) {
		// markers[i].setMap(null);
		markers[i].setVisible(false);
	}
};

//The search for venue tweets has to do something slightly different to manipulate the google InfoWindow
window.showPOIDetail = function(marker) {
	//Open up the window!
	if (openWindow) {
		openWindow.setIcon(templateDirectory + '/assets/images/icon_location_marker.png');
		openWindow.infowindow.close();
	}
	
	marker.setIcon(templateDirectory + '/assets/images/icon_location_marker.png');
	marker.infowindow.open(map, marker);

	openWindow = marker;
};

//Adds the markers to the map
window.drawPoint = function(POI) {	
	var POILatlng = new google.maps.LatLng(POI.lat, POI.lng);

	var windowString = '\
	<div class="pointer-box">\
		<a class="pointer" href="#"></a>\
		<div class="popup">\
			<a class="btn-close" href="javascript:;"><span></span></a>\
			<span class="title">' + POI.name + '</span>\
			<p>\
				<a class="address" target="_blank" href="http://www.google.com/maps/place/' + POI.address + '#">' + POI.address + '</a>\
				<br>\
				<a class="website" target="_blank" href="' + POI.website + '">' + POI.website + '</a>\
			</p>\
		</div>\
	</div>';


	//Use InfoBox extension instead of InfoWindow so we can style
	var boxText = document.createElement("div");
	boxText.innerHTML = windowString;


	var myOptions = {
		content: boxText,
		disableAutoPan: false,
		alignBottom: true,
		maxWidth: 0,
		pixelOffset: new google.maps.Size(-160, -25),
		zIndex: 1,
		boxClass: "infoBox",
		closeBoxURL: infoClose,
		closeBoxMargin: closePosition,
		infoBoxClearance: new google.maps.Size(1, 1),
		isHidden: false,
		pane: "floatPane",
		enableEventPropagation: true
	};
	
	var infowindow = new InfoBox(myOptions);

	var pointerIcon = templateDirectory+'/assets/images/icon_location_marker.png';
	
	var marker = new google.maps.Marker({
		position: POILatlng,
		icon: pointerIcon,
		map: map,
		zIndex: 9999
	});

	marker.setVisible(false);
	
	if(category === POI.category) {
		marker.setVisible(true);
	}
	
	marker.infowindow = infowindow;
	marker.POI = POI;

	markers.push(marker);


	google.maps.event.addListener(marker, 'click', function () {
		if (openWindow) {
			openWindow.setIcon(templateDirectory + '/assets/images/icon_location_marker.png');
			openWindow.infowindow.close();
		}
		showPOIDetail(marker);
		return false;
	});
	
	google.maps.event.addListener(map, 'click', function () {
		if (openWindow) {
			openWindow.setIcon(templateDirectory + '/assets/images/icon_location_marker.png');
			openWindow.infowindow.close();
		}
	});

	return marker;
};