window.pendingMaps = window.pendingMaps || []; // Store maps that need initialization

function initializeClinicMap(mapDiv) {
	var placeName = mapDiv.getAttribute('data-name');

	var map = new google.maps.Map(mapDiv, {
		zoom: 15,
		center: { lat: 0, lng: 0 }, // Placeholder
	});

	var service = new google.maps.places.PlacesService(map);
	var request = {
		query: placeName,
		fields: ['geometry', 'name'],
	};

	service.findPlaceFromQuery(request, function (results, status) {
		if (status === google.maps.places.PlacesServiceStatus.OK && results[0]) {
			var place = results[0];
			map.setCenter(place.geometry.location);

			new google.maps.Marker({
				map: map,
				position: place.geometry.location,
				title: place.name,
			});
		} else {
			console.error('Place not found: ' + placeName);
		}
	});
}

// 🔥 Fix: Attach initMaps to the window object so Google Maps can call it
window.initMaps = function () {
	window.pendingMaps.forEach(initializeClinicMap);
	window.pendingMaps = []; // Clear queue after initialization
};

document.addEventListener('DOMContentLoaded', function () {
	document.querySelectorAll('.clinic-map').forEach(function (mapDiv) {
		if (typeof google !== 'undefined' && google.maps) {
			initializeClinicMap(mapDiv);
		} else {
			window.pendingMaps.push(mapDiv); // Queue map for initialization
		}
	});
});
