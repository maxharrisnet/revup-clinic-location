# RevUp Special Offers Plugin

## Developed by: [Max Harris](www.maxharris.net) 👨🏾‍💻

This plugin is written as part of a coding assesment for RevUp. It plots the locations of dental clinics and displays them in a Google map.

### Here's what it does:

## Considerations 🤔

- Enqueing the Google Maps API script via the main plugin file using async and defer attributes.
- Using the Places API to get the locations of dental clinics

## Future Improvements 📋

Here are some things that were out of scope of this particular exercise that I would add to this plugin with more time:

- Handle results with multiple locations (e.g. `[clinic_location name="Harbour Dental Centre"]` returns 'Harbour Centre Dental', and 'Vancouver Harbour Dental'). I would add an address paramater to the shortcode to specify which location to use when needed.
- Use the newer version of the Places API (https://developers.google.com/maps/documentation/javascript/places-migration-overview)[https://developers.google.com/maps/documentation/javascript/places-migration-overview].
- Use the Place Details API (https://developers.google.com/maps/documentation/places/web-service/op-overview#place_details_api)[https://developers.google.com/maps/documentation/places/web-service/op-overview#place_details_api] to get more information about the clinics.
- Improved loading state.
