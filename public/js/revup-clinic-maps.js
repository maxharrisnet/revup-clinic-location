// Define revUpInitMaps function at the start so it's available for Google Maps API
window.revUpInitMaps = function () {
	console.log('Google Maps API loaded');
	// Initialize the maps for each shortcode on the page
	document.querySelectorAll('.revup-clinic-map').forEach(function (mapDiv) {
		initializeClinicMap(mapDiv);
	});
};

window.pendingMaps = window.pendingMaps || []; // Store maps that need initialization

function initializeClinicMap(mapDiv) {
	var placeName = mapDiv.getAttribute('data-name');
	var detailsDiv = document.getElementById(mapDiv.id + '_details');
	var nameSpan = detailsDiv.querySelector('.clinic-name');
	var addressSpan = detailsDiv.querySelector('.clinic-address');

	var map = new google.maps.Map(mapDiv, {
		zoom: 15,
		center: { lat: 0, lng: 0 },
		mapTypeControl: false,
		streetViewControl: true,
		zoomControl: true,
	});

	var service = new google.maps.places.PlacesService(map);
	var request = {
		query: placeName,
		fields: ['geometry', 'name', 'formatted_address'],
	};

	service.findPlaceFromQuery(request, function (results, status) {
		if (status === google.maps.places.PlacesServiceStatus.OK && results[0]) {
			var place = results[0];
			map.setCenter(place.geometry.location);

			// Create marker with position and title
			var marker = new google.maps.Marker({
				map: map,
				position: place.geometry.location,
				title: place.name,
				animation: google.maps.Animation.DROP,
			});

			// Add info window
			var infoContent = '<div class="clinic-info">' + '<strong>' + place.name + '</strong><br>' + place.formatted_address + '</div>';

			var infowindow = new google.maps.InfoWindow({
				content: infoContent,
			});

			// Add click listener to open info window
			marker.addListener('click', function () {
				infowindow.open(map, marker);
			});

			// Open info window by default
			infowindow.open(map, marker);

			// Update clinic details below the map
			nameSpan.textContent = place.name;
			addressSpan.textContent = place.formatted_address;
		} else {
			console.error('Place not found: ' + placeName);
			nameSpan.textContent = 'Clinic not found';
			addressSpan.textContent = '';
			mapDiv.innerHTML = '<div style="padding: 20px; text-align: center;" class="map-error">' + 'Could not find the location: ' + placeName + '</div>';
		}
	});
}

document.addEventListener('DOMContentLoaded', function () {
	document.querySelectorAll('.revup-clinic-map').forEach(function (mapDiv) {
		if (typeof google !== 'undefined' && google.maps) {
			initializeClinicMap(mapDiv);
		} else {
			window.pendingMaps.push(mapDiv); // Queue map for initialization
		}
	});
});
