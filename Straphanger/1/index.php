<?php
$dbname            ='ride2015'; 
$dbuser            ='root'; 
$dbpass            ='';
$dbserver          ='localhost';

$dbcnx = mysql_connect ("$dbserver", "$dbuser", "$dbpass");
mysql_select_db("$dbname") or die(mysql_error());
$currentLat = $_GET['latd'];
$currentLon = $_GET['longd'];
?>
<html>
 <head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
 <title>Google Map API V3 with markers</title>
 <link rel="stylesheet" href="../css/logged.css" type="text/css">

 <script src="../js/newprefix.min.js"></script>
 <script src="http://maps.google.com/maps/api/js?v=3&sensor=false" type="text/javascript"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 <script type="text/javascript">
 //Sample code written by August Li
 var icon = new google.maps.MarkerImage("http://maps.google.com/mapfiles/ms/micons/blue.png",
	new google.maps.Size(32, 32), new google.maps.Point(0, 0),
	new google.maps.Point(16, 32));
 var center = null;
 var map = null;
 var currentPopup;
 var bounds = new google.maps.LatLngBounds();
 
 //nearest driver
 $(document).ready(function() {
 $("#nearestD").click(function() {
	 //findNearD();
	 <?php
	 echo ("findNearD($currentLat, $currentLon);");
?>		
 });
 });
 
 function findNearD(latitude,longitude){
		//alert("Hello");
		<?php
		$nearSql = mysql_query("SELECT
		driverID,name,Address,latitude,longitude, (
        3959 * acos (
      cos ( radians(33.7883145) )
      * cos( radians(latitude))
      * cos( radians(longitude) - radians(-118.1409629) )
      + sin ( radians(33.7883145) )
      * sin( radians(latitude))
    )
	) AS distance
	FROM driver_location
	HAVING distance < 30
	ORDER BY distance");

	$row = mysql_fetch_array($nearSql);
	$ID = $row['driverID'];
	
	$dsql = mysql_query("select * from driver_details where driverID='".$ID."'",$dbcnx);
	while($driverDetails = mysql_fetch_array($dsql)) {	
	echo $driverDetails['name'];
	}	
	 ?>
	 alert('Details are :<?php print_r($driverDetails['name']);?>');
	 //center = bounds.getCenter();
	 //map.fitBounds(bounds);
 }

 
 var Uicon = new google.maps.MarkerImage(" http://maps.google.com/mapfiles/ms/micons/red.png",
	 new google.maps.Size(32, 32), new google.maps.Point(0, 0),
	 new google.maps.Point(16, 32));
	 var center = null;
	 var map = null;
	 var currentPopup;
	 var bounds = new google.maps.LatLngBounds();
	
	function addyourmarker(lat, lng, info) {
		 var pt = new google.maps.LatLng(lat, lng);
		 bounds.extend(pt);
		 var marker = new google.maps.Marker({
		 position: pt,
		 icon: Uicon,
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
 function initMap() {
	 map = new google.maps.Map(document.getElementById("map"), {
	 center: new google.maps.LatLng(0, 0),
	 zoom: 14,
	 mapTypeId: google.maps.MapTypeId.ROADMAP,
	 mapTypeControl: false,
	 mapTypeControlOptions: {
	 style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR
	},
	 navigationControl: true,
	 navigationControlOptions: {
	 style: google.maps.NavigationControlStyle.SMALL
	 }
	});
	 <?php
	 $query = mysql_query("SELECT * FROM driver_location");
	 while ($row = mysql_fetch_array($query)){
	 $name=$row['name'];
	 $lat=$row['latitude'];
	 $lon=$row['longitude'];
	 $desc=$row['Address'];
	 echo ("addyourmarker($currentLat, $currentLon,'<b>Your current location</b>');\n");
	 echo ("addMarker($lat, $lon,'<b>$name</b><br/>$desc');\n");
	 }
	 //echo ("findNearD($currentLat, $currentLon);");
	 ?>
	 center = bounds.getCenter();
	 map.fitBounds(bounds);
	 
}
 </script>
 </head>
 <body onload="initMap()">
 <div class="body"></div>
		<div class="grad"></div>
		<div class="header">
			<div>Strap<span>hanger</span></div></br>
			<input type="button" id="nearestD" name="nearestD" value="get nearest one" />
		</div>
  <div id="map"></div>
 </body>
 </html>
