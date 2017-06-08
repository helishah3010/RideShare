$(document).ready(function() {
		var directionsDisplay = new google.maps.DirectionsRenderer;
		var directionsService = new google.maps.DirectionsService;
		var map = new google.maps.Map(document.getElementById('mapholder'), {
		zoom: 7,
		center: {lat: 41.85, lng: -87.65}
	});
	directionsDisplay.setMap(map);
	
		var start = document.getElementById('origin-input').value;
		var end = document.getElementById('destination-input').value;
		//alert("start add: "+start);
		directionsService.route({
		origin: start,
		destination: end,
		travelMode: google.maps.TravelMode.DRIVING
		}, function(response, status) {
		if (status === google.maps.DirectionsStatus.OK) {
		  directionsDisplay.setDirections(response);
		} else {
		  window.alert('Directions request failed due to ' + status);
		}
		});
	}	  