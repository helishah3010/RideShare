<?php
$dbname            ='ride2015'; //Name of the database
$dbuser            ='root'; //Username for the db
$dbpass            =''; //Password for the db
$dbserver          ='localhost'; //Name of the mysql server

$dbcnx = mysql_connect ("$dbserver", "$dbuser", "$dbpass");
mysql_select_db("$dbname") or die(mysql_error());
?>
<html>
<head>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDW9Gyntxgty76v8XF856RaDlTo-bSj44I
&signed_in=true&libraries=places&callback=initMap"
    async defer></script>
<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false&libraries=geometry" type="text/javascript"></script>   

<link rel="stylesheet" href="css/logged.css" type="text/css">
<script src="js/newprefix.min.js"></script>
</head>
<body>
	<div class="body"></div>
		<div class="grad"></div>
		<div class="header">
			<div>Strap<span>hanger</span></div>
		</div>
		<br>
		<div class="login" id="login">
	</br>
	<form id="calculate-route" name="calculate-route" action="#">
	<input id="origin-input" name="origin-input" class="controls" type="text"
        placeholder="Enter source">

    <input id="destination-input" name="destination-input" class="controls" type="text"
        placeholder="Enter a destination">
	 <input id="calculate-route" type="submit" />&nbsp; &nbsp;
    <input type="reset" />&nbsp; &nbsp;
	<input id="btnMarker" name="markerName" value="get drivers" type="button"  onclick="gotodriver()"/>	
	</form>
	
	</br></br>
	
	<p id="demo"></p>
	</br>
	<p id="distance"></p>
	</br>
	<p id="duration"></p>
	
	</div>
	<div id="mapholder"></div>
	<script>
	
	function gotodriver() {	
		location.href="http://localhost/uber/random-login-form/1/index.php?latd="+lat+"&longd="+lon;
	}
	function initCoords() {
	var x = document.getElementById("demo");
	
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(initialize);
		} else {
			x.innerHTML = "Geolocation is not supported by this browser.";
		}
	}
	var icon = new google.maps.MarkerImage(" http://maps.google.com/mapfiles/ms/micons/blue.png",
	 new google.maps.Size(32, 32), new google.maps.Point(0, 0),
	 new google.maps.Point(16, 32));
	 var center = null;
	 var map = null;
	 var currentPopup;
	 var bounds = new google.maps.LatLngBounds();
	 
	
	
	function addMarker(lat, lng, info) {
		 var pt = new google.maps.LatLng(lat, lng);
		 bounds.extend(pt);
		 var marker = new google.maps.Marker({
		 position: pt,
		 icon: icon,
		 map: map
		 });
		 var popup = new google.maps.InfoWindow({
		 content: info,
		 maxWidth: 300
		 });
		 google.maps.event.addListener(marker, "click", function() {
		 if (currentPopup != null) {
		 currentPopup.close();
		 currentPopup = null;
		 }
		 popup.open(map, marker);
		 currentPopup = popup;
		 });
		 google.maps.event.addListener(popup, "closeclick", function() {
		 map.panTo(center);
		 currentPopup = null;
		 });
	}
	
	function initialize(position) {
		lat = position.coords.latitude;
		lon = position.coords.longitude;
		latlon = new google.maps.LatLng(lat, lon);
		//document.getElementById("currentLoc").value = latlon;
		
		mapholder = document.getElementById('mapholder');
		mapholder.style.height = '500px';
		mapholder.style.width = '500px';

		var myOptions = {
		center:latlon,zoom:14,
		mapTypeId:google.maps.MapTypeId.ROADMAP,   
		mapTypeControl:false,
		navigationControlOptions:{style:google.maps.NavigationControlStyle.SMALL}
		}
		//var mapopt = new google.maps.MapOptions({draggable:false});
		var map = new google.maps.Map(document.getElementById("mapholder"), myOptions);
		
		var marker = new google.maps.Marker({position:latlon,map:map,title:"You are here!"});
		
		//autocomplete
		var places = new google.maps.places.Autocomplete(document.getElementById('origin-input'));
        google.maps.event.addListener(places, 'place_changed', function () {
            var place = places.getPlace();
        });
        var places1 = new google.maps.places.Autocomplete(document.getElementById('destination-input'));
        google.maps.event.addListener(places1, 'place_changed', function () {
			var place1 = places1.getPlace();	
        });		
		
		<?php
	 $query = mysql_query("SELECT * FROM driver_location");
	 while ($row = mysql_fetch_array($query)){
	 $name=$row['name'];
	 $lat=$row['latitude'];
	 $lon=$row['longitude'];
	 $desc=$row['Address'];
	 //echo $row;die;
	 echo ("addMarker($lat, $lon,'<b>$name</b><br/>$desc');\n");
	 }
	 ?>
	 center = bounds.getCenter();
	 map.fitBounds(bounds);	
	}	  
	
	//source and destination
	$(document).ready(function() {
	google.maps.event.addDomListener(window, 'load', initCoords);
	
        $("#calculate-route").submit(function(event) {
          event.preventDefault();
          calculateRoute($("#origin-input").val(), $("#destination-input").val());		  
        });
		
	});
	
	//multiple markers
	
	
	function calculateRoute(from, to) {
		var myOptions = {
          zoom: 10,
          center: new google.maps.LatLng(40.84, 14.25),
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        // Draw the map
        var mapObject = new google.maps.Map(document.getElementById("mapholder"), myOptions);

        var directionsService = new google.maps.DirectionsService();
        var directionsRequest = {
          origin: from,
          destination: to,
          travelMode: google.maps.DirectionsTravelMode.DRIVING,
          unitSystem: google.maps.UnitSystem.METRIC
        };
        directionsService.route(
          directionsRequest,
          function(response, status)
          {
            if (status == google.maps.DirectionsStatus.OK)
            {
              new google.maps.DirectionsRenderer({
                draggable: true,
				map: mapObject,
                directions: response
              });
            }
            else
              $("#error").append("Unable to retrieve your route<br />");
          
			// distance calculation
			var totalDistance = 0;
			var totalDuration = 0;
			var METERS_TO_MILES = 0.000621371192;
			var legs = response.routes[0].legs;
			
			for(var i=0; i<legs.length; ++i) {
				totalDistance += legs[i].distance.value;
				totalDuration += legs[i].duration.value;
			}
			$('#distance').text('Estimated distance :'+(Math.round( totalDistance * METERS_TO_MILES * 10 ) / 10)+' miles');
			$('#duration').text('Estimated time: '+ totalDuration / 3600 +' hours');			  
        });	
	}
	</script>
</body>
</html>