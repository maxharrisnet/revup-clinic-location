window.pendingMaps = window.pendingMaps || []; // Store maps that need initialization

function initializeClinicMap(mapDiv) {
	var placeName = mapDiv.getAttribute('data-name');
	var detailsDiv = document.getElementById(mapDiv.id + '_details'); // Clinic details container
	var nameSpan = detailsDiv.querySelector('.clinic-name');
	var addressSpan = detailsDiv.querySelector('.clinic-address');

	var map = new google.maps.Map(mapDiv, {
		zoom: 15,
		center: { lat: 0, lng: 0 },
	});

	var service = new google.maps.places.PlacesService(map);
	var request = {
		query: placeName,
		fields: ['geometry', 'name', 'formatted_address'],
	};

	service.findPlaceFromQuery(request, function (results, status) {
		if (status === google.maps.places.PlacesServiceStatus.OK && results[0]) {
			// TODO: Handle multiple results if necessary
			// console.log('Places found:', results); This will log the list of places found
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

// Attach initMaps to the window object so Google Maps API can call it
window.initMaps = function () {
	window.pendingMaps.forEach(initializeClinicMap);
	window.pendingMaps = []; // Clear queue after initialization
};

document.addEventListener('DOMContentLoaded', function () {
	document.querySelectorAll('.revup-clinic-map').forEach(function (mapDiv) {
		if (typeof google !== 'undefined' && google.maps) {
			initializeClinicMap(mapDiv);
		} else {
			window.pendingMaps.push(mapDiv); // Queue map for initialization
		}
	});
});
