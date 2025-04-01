<?php

/*
  Plugin Name: RevUp Clinic Location
  Plugin URI: https://github.com/maxharrisnet/revup-clinic-location
  Description: This plugin displays the location of a given dental clinic on a Google map. It creates a shortcode that can be used in posts or pages to show the map.
  Version: 1.0
  Author: Max Harris for RevUp Dental
  Author URI: https://www.maxharris.net
  Text Domain: revup
*/

if (! defined('ABSPATH')) {
  exit; // Exit if accessed directly
}


// Enqueue Google Maps API script
function revup_enqueue_google_maps_scripts()
{
  $api_key = get_option('revup_google_maps_api_key', '');
  if (!wp_script_is('google-maps-places', 'enqueued')) {
    wp_enqueue_script('google-maps-places', "https://maps.googleapis.com/maps/api/js?key={$api_key}&libraries=places&callback=initMaps", [], null, true);
  }
  wp_enqueue_script('clinic-maps', plugin_dir_url(__FILE__) . 'public/js/revup-clinic-maps.js', ['google-maps-places'], null, true);
}
add_action('wp_enqueue_scripts', 'revup_enqueue_google_maps_scripts');

function revup_clinic_location_enqueue_styles()
{
  wp_enqueue_style(
    'revup-clinic-location',
    plugin_dir_url(__FILE__) . 'public/css/revup-clinic-location.css',
    array(),
    filemtime(plugin_dir_path(__FILE__) . 'public/css/revup-clinic-location.css')
  );
}
add_action('wp_enqueue_scripts', 'revup_clinic_location_enqueue_styles');

require_once plugin_dir_path(__FILE__) . 'includes/shortcode.php';
require_once plugin_dir_path(__FILE__) . 'admin/settings.php';
