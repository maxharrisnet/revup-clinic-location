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
			// TODO: Handle multiple results if necessary, use address as fallback
			// console.log('Places found:', results);

			var place = results[0];
			map.setCenter(place.geometry.location);

			new google.maps.Marker({
				map: map,
				position: place.geometry.location,
				title: place.name,
			});

			// Update clinic details
			nameSpan.textContent = place.name;
			addressSpan.textContent = place.formatted_address;
		} else {
			console.error('Place not found: ' + placeName);
			nameSpan.textContent = 'Clinic not found';
			addressSpan.textContent = '';
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
