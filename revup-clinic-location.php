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
  exit;
}

require_once plugin_dir_path(__FILE__) . 'admin/settings.php';
require_once plugin_dir_path(__FILE__) . 'includes/shortcode.php';

function revup_enqueue_maps_scripts()
{
  // Only load scripts on pages where the shortcode is used
  global $post;
  if (!is_a($post, 'WP_Post') || !has_shortcode($post->post_content, 'clinic_location')) {
    return;
  }

  // Enqueue Google Maps API script
  $api_key = get_option('revup_google_maps_api_key', '');
  if (!empty($api_key) && !wp_script_is('google-maps-places', 'enqueued')) {
    wp_enqueue_script('google-maps-places', "https://maps.googleapis.com/maps/api/js?key={$api_key}&libraries=places&loading=async&callback=revUpInitMaps", [], null, array('strategy' => 'async', 'in_footer' => true));
  }

  // Enqueue the custom script for clinic maps
  wp_enqueue_script('clinic-maps', plugin_dir_url(__FILE__) . 'public/js/revup-clinic-maps.js', ['google-maps-places'], null, true);
}
add_action('wp_enqueue_scripts', 'revup_enqueue_maps_scripts');

function revup_enqueue_maps_styles()
{
  // Only load styles on pages where shortcode is used
  global $post;
  if (!is_a($post, 'WP_Post') || !has_shortcode($post->post_content, 'clinic_location')) {
    return;
  }


  wp_enqueue_style(
    'revup-clinic-location',
    plugin_dir_url(__FILE__) . 'public/css/revup-clinic-maps.css',
    array(),
    filemtime(plugin_dir_path(__FILE__) . 'public/css/revup-clinic-maps.css')
  );
}
add_action('wp_enqueue_scripts', 'revup_enqueue_maps_styles');
