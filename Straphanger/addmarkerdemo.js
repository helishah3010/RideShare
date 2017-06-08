var map;
function initialize() 
  {
    var latloncenter = new google.maps.LatLng(51,-1.4469157);
    var myOptions = 
    {
      zoom: 4,
      center: latloncenter,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	<? while($row = mysql_fetch_assoc($result)){?>

      var lon = "<?php echo($row['Longitude']); ?>"; 
      var lat = "<?php echo($row['Latitude']); ?>"; 


     alert_test(lat,lon);
     setmarker(lat,lon);

<? } ?>
  }; 

  



function setmarker(lat,lon)
{

var latlongMarker = new google.maps.LatLng(lat,lon);

var marker = new google.maps.Marker
    (
        {
            position: latlongMarker, 
            map: map,
            title:"Hello World!"
        }
    ); 

}

function alert_test(lat,lon)
{
    alert(lat +" "+ lon);
}