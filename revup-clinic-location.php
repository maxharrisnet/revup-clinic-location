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
require_once plugin_dir_path(__FILE__) . 'includes/api.php';
require_once plugin_dir_path(__FILE__) . 'admin/settings.php';

function revup_clinic_location_enqueue_styles()
{
  wp_enqueue_style(
    'revup-clinic-location',
    plugin_dir_url(dirname(__FILE__)) . 'public/css/revup-clinic-location.css',
    array(),
    '1.0.0'
  );
}
add_action('wp_enqueue_scripts', 'revup_clinic_location_enqueue_styles');
