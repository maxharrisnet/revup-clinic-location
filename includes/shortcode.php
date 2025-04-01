<?php

if (! defined('ABSPATH')) {
  exit;
}

/**
 * Shortcode to display clinic location on Google Maps
 * The shortcode takes the clinic name as an attribute and displays the location on a Google Map.
 * It uses the Google Maps JavaScript API to find the clinic's location and display it on the map.
 *
 * Usage: [clinic_location name="Your Clinic Name" width="100%" height="400px"]
 * 
 * @param array $atts Shortcode attributes
 * @return string HTML output for the shortcode
 * 
 */

function revup_clinic_location_shortcode($atts)
{
  $atts = shortcode_atts(
    array(
      'name' => 'Brookside Dental Care', // Default to Brookside Dental Care
      'width' => '100%',
      'height' => '400px',
    ),
    $atts,
    'clinic_location'
  );

  // Google Maps API key from WordPress settings
  $api_key = get_option('revup_google_maps_api_key', '');

  if (empty($api_key)) {
    return '<p>Please set the Google Maps API key in the plugin settings.</p>';
  }

  // Generate id for unique map instance
  $map_id = 'clinicMap_' . uniqid();

  ob_start();
?>
  <div style="width: <?php echo esc_attr($atts['width']); ?>; height: <?php echo esc_attr($atts['height']); ?>;">
    <gmp-map id="<?php echo esc_attr($map_id); ?>" zoom="15" map-id="8eaef166049349d4">
      <gmp-advanced-marker id="<?php echo esc_attr($map_id); ?>-marker" position=""></gmp-advanced-marker>
    </gmp-map>

    <script>
      // Create a function in global scope that will initialize this specific map
      window.initMap<?php echo esc_attr($map_id); ?> = async function() {
        const map = document.getElementById('<?php echo esc_attr($map_id); ?>');
        const marker = document.getElementById('<?php echo esc_attr($map_id); ?>-marker');

        // Create a PlacesService instance
        const placesService = new google.maps.places.PlacesService(map);

        // Search for the clinic by name
        placesService.findPlaceFromQuery({
          query: '<?php echo esc_js($atts['name']); ?>',
          fields: ['name', 'geometry', 'formatted_address']
        }, function(results, status) {
          if (status === google.maps.places.PlacesServiceStatus.OK && results.length > 0) {
            const place = results[0];
            const location = place.geometry.location;

            // Position the map and marker
            map.setAttribute('center', `${location.lat()},${location.lng()}`);
            marker.setAttribute('position', `${location.lat()},${location.lng()}`);

            const infowindow = document.createElement('gmp-advanced-marker-info-window');
            infowindow.innerHTML = `
              <div>
                <strong>${place.name}</strong><br>
                ${place.formatted_address || ''}
              </div>
            `;
            marker.appendChild(infowindow);

            setTimeout(() => {
              infowindow.open = true;
            }, 500);
          } else {
            console.error('🔴 Places API error:', status);
            map.innerHTML = `<div style="padding: 20px; text-align: center;">
              Could not find location: <?php echo esc_js($atts['name']); ?>
            </div>`;
          }
        });
      };

      // Function to initialize the map when API is ready
      async function initializeMap() {
        if (window.google && window.google.maps) {
          await window.initMap<?php echo esc_attr($map_id); ?>();
        } else {
          // Wait for the API to load
          await new Promise((resolve) => {
            const checkGoogle = setInterval(() => {
              if (window.google && window.google.maps) {
                clearInterval(checkGoogle);
                resolve();
              }
            }, 100);
          });
          await window.initMap<?php echo esc_attr($map_id); ?>();
        }
      }

      // Start initialization when DOM is ready
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeMap);
      } else {
        initializeMap();
      }
    </script>
  </div>
<?php
  return ob_get_clean();
}

add_shortcode('clinic_location', 'revup_clinic_location_shortcode');
