<?php

/**
 * Get latitude and longitude when saving post
 *
 * @param int $post_id The ID of the post.
 */
function get_location_details($post_id) {
	/*
	 * In production code, $slug should be set only once in the plugin,
	 * preferably as a class property, rather than in each function that needs it.
	 */
	$slug = 'location';

	// If this isn't a 'location' post, don't update it.
	if (!isset($_POST['post_type']) || $slug != $_POST['post_type']) {
		return;
	}

	$lat = get_field('latitude');
	$lon = get_field('longitude');

	// remove_action('save_post', 'get_location_details');
	
	$address = get_field('address', $post_id);
	$city = get_field('city', $post_id);
	$state = get_field('state', $post_id);
	$zip = get_field('zip', $post_id);

	$url = 'http://maps.googleapis.com/maps/api/geocode/json?sensor=false&address='.urlencode($address);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$response = json_decode(curl_exec($ch), true);

	if(!empty($response['results'])) {
		// update_field('latitude', $response['results'][0]['geometry']['location']['lat'], $post_id);
		// update_field('longitude', $response['results'][0]['geometry']['location']['lng'], $post_id);

		// update post fields for each new site
		$_POST['fields']['field_5422f5a376382'] = $response['results'][0]['geometry']['location']['lat'];
		$_POST['fields']['field_5422f5a776383'] = $response['results'][0]['geometry']['location']['lng'];
		
		remove_action('save_post', 'get_location_details');

		wp_update_post(array('ID' => $post_id));

	}
}
add_action('save_post', 'get_location_details');