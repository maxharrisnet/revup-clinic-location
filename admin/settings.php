<?php

if (! defined('ABSPATH')) {
  exit;
}

/**
 * Admin settings page
 * 
 * This function adds a settings page to the WordPress admin menu for the Clinic Location plugin.
 * It allows the user to enter their Google Maps API key, which is required for the plugin to function.
 * The settings page is registered under the "Settings" menu in the WordPress admin area.
 * 
 */

function revup_clinic_location_add_settings_page()
{
  add_options_page(
    'Clinic Location Settings',
    'Clinic Location',
    'manage_options',
    'revup-clinic-location',
    'revup_clinic_location_settings_page'
  );
}
add_action('admin_menu', 'revup_clinic_location_add_settings_page');

/**
 * Register settings
 */
function revup_clinic_location_register_settings()
{
  register_setting('revup_clinic_location_settings', 'revup_google_maps_api_key');
}
add_action('admin_init', 'revup_clinic_location_register_settings');

/**
 * Display the settings page
 */
function revup_clinic_location_settings_page()
{
?>
  <div class="wrap">
    <h1>Clinic Location Settings</h1>
    <form method="post" action="options.php">
      <?php
      settings_fields('revup_clinic_location_settings');
      do_settings_sections('revup-clinic-location');
      ?>
      <table class="form-table">
        <tr valign="top">
          <th scope="row">Google Maps API Key</th>
          <td>
            <input type="text" name="revup_google_maps_api_key"
              value="<?php echo esc_attr(get_option('revup_google_maps_api_key')); ?>" class="regular-text" />
            <p class="description">
              Enter your Google Maps API key.
              <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">
                How to get an API key
              </a>
            </p>
          </td>
        </tr>
      </table>
      <?php submit_button(); ?>
    </form>
  </div>
<?php
}
