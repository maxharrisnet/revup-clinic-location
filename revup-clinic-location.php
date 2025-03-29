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

require_once plugin_dir_path(__FILE__) . 'includes/shortcode.php';
require_once plugin_dir_path(__FILE__) . 'admin/settings.php';

// Enqueue Google Maps API script
function revup_clinic_location_enqueue_scripts()
{
  // Google Maps API key from WordPress settings
  $api_key = get_option('revup_google_maps_api_key', '');

  if (!empty($api_key)) {
    wp_enqueue_script(
      'google-maps-api',
      'https://maps.googleapis.com/maps/api/js?key=' . esc_attr($api_key) . '&libraries=places',
      array(),
      null,
      true
    );
  }
}
add_action('wp_enqueue_scripts', 'revup_clinic_location_enqueue_scripts');

// Enqueue plugin script for the map
function revup_clinic_location_enqueue_map_script()
{
  wp_enqueue_script(
    'revup-clinic-location-map',
    plugin_dir_url(__FILE__) . 'public/js/revup-clinic-location-map.js',
    array('google-maps-api'),
    filemtime(plugin_dir_path(__FILE__) . 'public/js/revup-clinic-location-map.js'),
    fa
  );
}
add_action('wp_enqueue_scripts', 'revup_clinic_location_enqueue_map_script');

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
