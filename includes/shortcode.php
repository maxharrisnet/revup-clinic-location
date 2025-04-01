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
// Shortcode function
function revup_clinic_location_shortcode($atts)
{
  $atts = shortcode_atts([
    'name' => 'Brookside Dental Care', // Default place name
    'width' => '100%',
    'height' => '400px',
  ], $atts, 'clinic_location');

  $map_id = 'clinicMap_' . uniqid(); // Unique ID for each map

  ob_start();
?>
  <div id="<?php echo esc_attr($map_id); ?>" class="revup-clinic-map"
    data-name="<?php echo esc_attr($atts['name']); ?>"
    style="width: <?php echo esc_attr($atts['width']); ?>; height: <?php echo esc_attr($atts['height']); ?>;">
  </div>
  <div class="clinic-details" id="<?php echo esc_attr($map_id); ?>_details">
    <address>
      <strong class="clinic-name">Loading...</strong><br>
      <span class="clinic-address">Fetching address...</span>
    </address>
  </div>
<?php
  return ob_get_clean();
}
add_shortcode('clinic_location', 'revup_clinic_location_shortcode');
