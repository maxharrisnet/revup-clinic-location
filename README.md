# RevUp Special Offers Plugin

## Developed by: [Max Harris](www.maxharris.net) 👨🏾‍💻

This plugin is written by Max Harris as part of a coding assesment for RevUp. It plots the locations of dental clinics and displays them in a Google map.

### Here's what it does:

- Creates a shortcode that can be used to display a map of dental clinics
- Shortcode accepts a name parameter to specify the location of the dental clinic
- Uses the Places API to get the locations of dental clinics
- Uses the Google Maps API to display the map

## Considerations 🤔

- Enqueing the Google Maps API script via the main plugin file using async and defer
- Setting "Brookside Dental Care" as the default location for the map
- Height and width shortcode attributes for the map
- Using the Places API to get the locations of dental clinics
- Using a unique id for each map to allow multiple maps on the same page (avoiding conflicts)
- Writing functionality in a DRY, external JavaScript file
- Deleting shortcode and data on plugin deactivation

## Future Improvements 📋

Here are some things that were out of scope of this particular exercise that I would add to this plugin with more time:

- Handle results with multiple locations (e.g. `[clinic_location name="Harbour Dental Centre"]` returns 'Harbour Centre Dental', and 'Vancouver Harbour Dental'). I would add an address paramater to the shortcode to specify which location to use when needed.
- Use the [newer version of the Places API](https://developers.google.com/maps/documentation/javascript/places-migration-overview)
- Use the [Place Details API](https://developers.google.com/maps/documentation/places/web-service/op-overview#place_details_api) to get more information about the clinics.
- Improve the loading state
- Add a settings page to allow the user to set the default location for the map
- More robust marker handling (e.g. if a marker is clicked, it should open the info window for that marker)
