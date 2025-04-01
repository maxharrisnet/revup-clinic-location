<?php

if (!defined('ABSPATH') || !defined('WP_UNINSTALL_PLUGIN')) {
  exit;
}

global $wpdb;

// Get all posts/pages that contain the shortcode
$posts_with_shortcode = $wpdb->get_results(
  $wpdb->prepare(
    "SELECT ID, post_content 
         FROM {$wpdb->posts} 
         WHERE post_content LIKE %s 
         AND post_status = 'publish'",
    '%[clinic_location%'
  )
);

// Remove the shortcode from each post's content
foreach ($posts_with_shortcode as $post) {
  $new_content = preg_replace('/\[clinic_location.*?\]/', '', $post->post_content);

  // Update the post
  wp_update_post([
    'ID' => $post->ID,
    'post_content' => $new_content
  ]);
}
