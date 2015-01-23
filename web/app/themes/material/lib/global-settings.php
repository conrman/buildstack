<?php

/**
 * This function introduces the theme options into the 'Appearance' menu and into a top-level
 * 'global Theme' menu.
 */
function global_options_theme_menu() {

	$menu = add_menu_page(
		'Global Settings', 					// The title to be displayed in the browser window for this page.
		'Global Settings',					// The text to be displayed for this menu item
		'edit_pages',					// Which type of users can see this menu item
		'global_settings',			// The unique ID - that is, the slug - for this menu item
		'global_settings_display'				// The name of the function to call when rendering this menu's page
	);

	add_action('load-'.$menu, 'global_options_save');

	// add_menu_page(
	// 	'Global Theme Options',					// The value used to populate the browser's title bar when the menu page is active
	// 	'Global Theme Options',					// The text of the menu in the administrator's sidebar
	// 	'edit_pages',					// What roles are able to access the menu
	// 	'global_theme_menu',				// The ID used to bind submenu items to this menu
	// 	'global_settings_display'				// The callback function used to render this menu
	// );

	add_submenu_page(
		'global_theme_menu',				// The ID of the top-level menu page to which this submenu item belongs
		__( 'Display Options', 'global' ),			// The value used to populate the browser's title bar when the menu page is active
		__( 'Display Options', 'global' ),			// The label of this submenu item displayed in the menu
		'edit_pages',					// What roles are able to access this submenu item
		'global_settings_display_options',	               // The ID used to represent this submenu item
		'global_settings_display'			// The callback function used to render the options for this submenu item
	);

	add_submenu_page(
		'global_theme_menu',
		__( 'Social Options', 'global' ),
		__( 'Social Options', 'global' ),
		'edit_pages',
		'global_settings_social_options',
		create_function( null, 'global_settings_display( "social_options" );' )
	);


} // end global_options_theme_menu
add_action( 'admin_menu', 'global_options_theme_menu' );

// modify capability
function global_settings_display_options_capability( $capability ) {
	return 'edit_others_posts';
}
add_filter( 'option_page_capability_global_settings_display_options', 'global_settings_display_options_capability' );

// modify capability
function global_settings_social_options_capability( $capability ) {
	return 'edit_others_posts';
}
add_filter( 'option_page_capability_global_settings_social_options', 'global_settings_social_options_capability' );

function global_options_save() {
	if(isset($_GET['settings-updated']) && $_GET['settings-updated']) {
		$display_options = get_option('global_settings_display_options');
		$address = $display_options['address'];
		$city = $display_options['city'];
		$state = $display_options['state'];
		$zip = $display_options['zip'];

		$url = 'http://maps.googleapis.com/maps/api/geocode/json?sensor=false&address='.urlencode($address).',%20'.$zip.'%20'.$city.'%20'.$state.'%20';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$response = json_decode(curl_exec($ch), true);

		if(!empty($response['results'])) {
			$display_options['latitude'] = $response['results'][0]['geometry']['location']['lat'];
			$display_options['longitude'] = $response['results'][0]['geometry']['location']['lng'];

			update_option('global_settings_display_options', $display_options);
		}
	}
}

/**
 * Renders a simple page to display for the theme menu defined above.
 */
function global_settings_display( $active_tab = '' ) {
?>
	<!-- Create a header in the default WordPress 'wrap' container -->
	<div class="wrap">

		<div id="icon-themes" class="icon32"></div>
		<h2><?php _e( 'Global Theme Options', 'global' ); ?></h2>
		<?php settings_errors(); ?>

		<?php if( isset( $_GET[ 'tab' ] ) ) {
			$active_tab = $_GET[ 'tab' ];
		} else if( $active_tab == 'social_options' ) {
			$active_tab = 'social_options';
		} else {
			$active_tab = 'display_options';
		} // end if/else ?>

		<h2 class="nav-tab-wrapper">
			<a href="?page=global_settings&tab=display_options" class="nav-tab <?php echo $active_tab == 'display_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Display Options', 'global' ); ?></a>
			<a href="?page=global_settings&tab=social_options" class="nav-tab <?php echo $active_tab == 'social_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Social Options', 'global' ); ?></a>
		</h2>

		<form method="post" action="options.php">
			<?php

				if( $active_tab == 'display_options' ) {

					settings_fields( 'global_settings_display_options' );
					do_settings_sections( 'global_settings_display_options' );

				} elseif( $active_tab == 'social_options' ) {

					settings_fields( 'global_settings_social_options' );
					do_settings_sections( 'global_settings_social_options' );

				} else {


				} // end if/else

				submit_button();

			?>
		</form>

	</div><!-- /.wrap -->
<?php
} // end global_settings_display

/* ------------------------------------------------------------------------ *
 * Setting Registration
 * ------------------------------------------------------------------------ */


/**
 * Provides default values for the Social Options.
 */
function global_theme_default_social_options() {

	$defaults = array(
		'twitter' => '',
		'facebook' => '',
		'instagram'	=> '',
		'pinterest'	=> '',
		'linkedin'	=> '',
	);

	return apply_filters( 'global_theme_default_social_options', $defaults );

} // end global_theme_default_social_options

/**
 * Provides default values for the display Options.
 */
function global_theme_default_display_options() {

	$defaults = array(
		'phone'	=> '',
		'address' => '',
		'city' => '',
		'state' => '',
		'zip' => '',
		'latitude' => '',
		'longitude' => '',
		'email' => '',
		'lease_online' => '',
	);

	return apply_filters( 'global_theme_default_display_options', $defaults );

} // end global_theme_default_display_options

/**
 * Initializes the theme's display options page by registering the Sections,
 * Fields, and Settings.
 *
 * This function is registered with the 'admin_init' hook.
 */
function global_initialize_theme_options() {

	// If the theme options don't exist, create them.
	if( false == get_option( 'global_settings_display_options' ) ) {
		add_option( 'global_settings_display_options', apply_filters( 'global_theme_default_display_options', global_theme_default_display_options() ) );
	} // end if

	// First, we register a section. This is necessary since all future options must belong to a
	add_settings_section(
		'general_settings_section',			// ID used to identify this section and with which to register options
		__( 'display Options', 'global' ),		// Title to be displayed on the administration page
		'global_general_options_callback',	// Callback used to render the description of the section
		'global_settings_display_options'		// Page on which to add this section of options
	);

	// Next, we'll introduce the fields for toggling the visibility of content elements.
	add_settings_field(
		'phone',						// ID used to identify the field throughout the theme
		__( 'Phone Number', 'global' ),							// The label to the left of the option interface element
		'global_phone_callback',	// The name of the function responsible for rendering the option interface
		'global_settings_display_options',	// The page on which this option will be displayed
		'general_settings_section',			// The name of the section to which this field belongs
		array()								// The array of arguments to pass to the callback. In this case, just a description.
	);

	add_settings_field(
		'address',
		__( 'Address', 'global' ),
		'global_address_callback',
		'global_settings_display_options',
		'general_settings_section',
		array()
	);

	add_settings_field(
		'city',
		__( 'City', 'global' ),
		'global_city_callback',
		'global_settings_display_options',
		'general_settings_section',
		array()
	);

	add_settings_field(
		'state',
		__( 'State', 'global' ),
		'global_state_callback',
		'global_settings_display_options',
		'general_settings_section',
		array()
	);

	add_settings_field(
		'zip',
		__( 'Zip Code', 'global' ),
		'global_zip_callback',
		'global_settings_display_options',
		'general_settings_section',
		array()
	);

	add_settings_field(
		'latitude',
		__( 'Latitude', 'global' ),
		'global_latitude_callback',
		'global_settings_display_options',
		'general_settings_section',
		array()
	);

	add_settings_field(
		'longitude',
		__( 'Longitude', 'global' ),
		'global_longitude_callback',
		'global_settings_display_options',
		'general_settings_section',
		array()
	);

	add_settings_field(
		'email',
		__( 'Email', 'global' ),
		'global_email_callback',
		'global_settings_display_options',
		'general_settings_section',
		array()
	);


	// Finally, we register the fields with WordPress
	register_setting(
		'global_settings_display_options',
		'global_settings_display_options'
	);

} // end global_initialize_theme_options
add_action( 'admin_init', 'global_initialize_theme_options' );

/**
 * Initializes the theme's social options by registering the Sections,
 * Fields, and Settings.
 *
 * This function is registered with the 'admin_init' hook.
 */
function global_theme_initialize_social_options() {

	if( false == get_option( 'global_settings_social_options' ) ) {
		add_option( 'global_settings_social_options', apply_filters( 'global_theme_default_social_options', global_theme_default_social_options() ) );
	} // end if

	add_settings_section(
		'social_settings_section',			// ID used to identify this section and with which to register options
		__( 'Social Options', 'global' ),		// Title to be displayed on the administration page
		'global_social_options_callback',	// Callback used to render the description of the section
		'global_settings_social_options'		// Page on which to add this section of options
	);

	add_settings_field(
		'twitter',
		'Twitter',
		'global_twitter_callback',
		'global_settings_social_options',
		'social_settings_section'
	);

	add_settings_field(
		'facebook',
		'Facebook',
		'global_facebook_callback',
		'global_settings_social_options',
		'social_settings_section'
	);

	add_settings_field(
		'instagram',
		'Instagram',
		'global_instagram_callback',
		'global_settings_social_options',
		'social_settings_section'
	);

	add_settings_field(
		'pinterest',
		'Pinterest',
		'global_pinterest_callback',
		'global_settings_social_options',
		'social_settings_section'
	);

	add_settings_field(
		'linkedin',
		'LinkedIn',
		'global_linkedin_callback',
		'global_settings_social_options',
		'social_settings_section'
	);

	register_setting(
		'global_settings_social_options',
		'global_settings_social_options',
		'global_theme_sanitize_social_options'
	);

} // end global_theme_initialize_social_options
add_action( 'admin_init', 'global_theme_initialize_social_options' );

/* ------------------------------------------------------------------------ *
 * Section Callbacks
 * ------------------------------------------------------------------------ */

/**
 * This function provides a simple description for the General Options page.
 *
 * It's called from the 'global_initialize_theme_options' function by being passed as a parameter
 * in the add_settings_section function.
 */
function global_general_options_callback() {
	echo '<p>' . __( 'Provide your display website details', 'global' ) . '</p>';
} // end global_general_options_callback

/**
 * This function provides a simple description for the Social Options page.
 *
 * It's called from the 'global_theme_initialize_social_options' function by being passed as a parameter
 * in the add_settings_section function.
 */
function global_social_options_callback() {
	echo '<p>' . __( 'Provide the URL to the social networks you\'d like to display.', 'global' ) . '</p>';
} // end global_general_options_callback

/* ------------------------------------------------------------------------ *
 * Field Callbacks
 * ------------------------------------------------------------------------ */


function global_phone_callback($args) {

	$options = get_option( 'global_settings_display_options' );

	$value = '';
	if( isset( $options['phone'] ) ) {
		$value = $options['phone'];
	} // end if

	// Render the output
	echo '<input type="text" id="phone" name="global_settings_display_options[phone]" value="' . $value . '" />';

} // end global_phone_callback

function global_address_callback($args) {

	$options = get_option( 'global_settings_display_options' );

	$value = '';
	if( isset( $options['address'] ) ) {
		$value = $options['address'];
	} // end if

	// Render the output
	echo '<input type="text" id="address" name="global_settings_display_options[address]" value="' . $value . '" />';

} // end global_address_callback

function global_city_callback($args) {

	$options = get_option( 'global_settings_display_options' );

	$value = '';
	if( isset( $options['city'] ) ) {
		$value = $options['city'];
	} // end if

	// Render the output
	echo '<input type="text" id="city" name="global_settings_display_options[city]" value="' . $value . '" />';

} // end global_city_callback

function global_state_callback($args) {

	$options = get_option( 'global_settings_display_options' );

	$value = '';
	if( isset( $options['state'] ) ) {
		$value = $options['state'];
	} // end if

	// Render the output
	echo '<input type="text" id="state" name="global_settings_display_options[state]" value="' . $value . '" />';

} // end global_state_callback

function global_zip_callback($args) {

	$options = get_option( 'global_settings_display_options' );

	$value = '';
	if( isset( $options['zip'] ) ) {
		$value = $options['zip'];
	} // end if

	// Render the output
	echo '<input type="text" id="zip" name="global_settings_display_options[zip]" value="' . $value . '" />';

} // end global_zip_callback

function global_latitude_callback($args) {

	$options = get_option( 'global_settings_display_options' );

	$value = '';
	if( isset( $options['latitude'] ) ) {
		$value = $options['latitude'];
	} // end if

	// Render the output
	echo '<input type="text" id="latitude" name="global_settings_display_options[latitude]" value="' . $value . '" />';

} // end global_latitude_callback

function global_longitude_callback($args) {

	$options = get_option( 'global_settings_display_options' );

	$value = '';
	if( isset( $options['longitude'] ) ) {
		$value = $options['longitude'];
	} // end if

	// Render the output
	echo '<input type="text" id="longitude" name="global_settings_display_options[longitude]" value="' . $value . '" />';

} // end global_longitude_callback

function global_email_callback($args) {

	$options = get_option( 'global_settings_display_options' );

	$value = '';
	if( isset( $options['email'] ) ) {
		$value = $options['email'];
	} // end if

	// Render the output
	echo '<input type="text" id="email" name="global_settings_display_options[email]" value="' . $value . '" />';

} // end global_email_callback

function global_twitter_callback() {

	// First, we read the social options collection
	$options = get_option( 'global_settings_social_options' );

	// Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
	$url = '';
	if( isset( $options['twitter'] ) ) {
		$url = esc_url( $options['twitter'] );
	} // end if

	// Render the output
	echo '<input type="text" id="twitter" name="global_settings_social_options[twitter]" value="' . $url . '" />';

} // end global_twitter_callback

function global_facebook_callback() {

	$options = get_option( 'global_settings_social_options' );

	$url = '';
	if( isset( $options['facebook'] ) ) {
		$url = esc_url( $options['facebook'] );
	} // end if

	// Render the output
	echo '<input type="text" id="facebook" name="global_settings_social_options[facebook]" value="' . $url . '" />';

} // end global_facebook_callback

function global_instagram_callback() {

	$options = get_option( 'global_settings_social_options' );

	$url = '';
	if( isset( $options['instagram'] ) ) {
		$url = esc_url( $options['instagram'] );
	} // end if

	// Render the output
	echo '<input type="text" id="instagram" name="global_settings_social_options[instagram]" value="' . $url . '" />';

} // end global_instagram_callback

function global_pinterest_callback() {

	$options = get_option( 'global_settings_social_options' );

	$url = '';
	if( isset( $options['pinterest'] ) ) {
		$url = esc_url( $options['pinterest'] );
	} // end if

	// Render the output
	echo '<input type="text" id="pinterest" name="global_settings_social_options[pinterest]" value="' . $url . '" />';

} // end global_codepen_callback

function global_linkedin_callback() {

	$options = get_option( 'global_settings_social_options' );

	$url = '';
	if( isset( $options['linkedin'] ) ) {
		$url = esc_url( $options['linkedin'] );
	} // end if

	// Render the output
	echo '<input type="text" id="linkedin" name="global_settings_social_options[linkedin]" value="' . $url . '" />';

} // end global_linkedin_callback

/* ------------------------------------------------------------------------ *
 * Setting Callbacks
 * ------------------------------------------------------------------------ */

/**
 * Sanitization callback for the social options. Since each of the social options are text inputs,
 * this function loops through the incoming option and strips all tags and slashes from the value
 * before serializing it.
 *
 * @params	$input	The unsanitized collection of options.
 *
 * @returns			The collection of sanitized values.
 */
function global_theme_sanitize_social_options( $input ) {

	// Define the array for the updated options
	$output = array();

	// Loop through each of the options sanitizing the data
	foreach( $input as $key => $val ) {

		if( isset ( $input[$key] ) ) {
			$output[$key] = esc_url_raw( strip_tags( stripslashes( $input[$key] ) ) );
		} // end if

	} // end foreach

	// Return the new collection
	return apply_filters( 'global_theme_sanitize_social_options', $output, $input );

} // end global_theme_sanitize_social_options

?>