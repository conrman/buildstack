<?php
/**
 * Clean up the_excerpt()
 */
function roots_excerpt_more($more) {
	return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'roots') . '</a>';
}
add_filter('excerpt_more', 'roots_excerpt_more');

/**
* Breadcrumb
*/
function the_breadcrumb() {
	if (!is_home()) {
		echo '<a href="';
		echo get_option('home');
		echo '">';
		bloginfo('name');
		echo "</a> <i class='fa fa-chevron-right'></i> ";
		if (is_category() || is_single()) {
			the_category('title_li=');
			if (is_single()) {
				echo " <i class='fa fa-chevron-right'></i> ";
				the_title();
			}
		} elseif (is_page()) {
			echo the_title();
		}
	}
}


function add_classes($classes, $item, $args) {
	$classes[] = 'button';
	return $classes;
}
// add_filter('nav_menu_css_class','add_classes',1,3);

function nav_depth_classes($item_output, $item, $depth, $args) {
	add_action(
		'nav_menu_css_class',
		function() use ($depth) {
			$depth++;
			$classes[] = "depth-{$depth}";
			return $classes;
		}
		);
	return $item_output;
}
// add_filter('walker_nav_menu_start_el','nav_depth_classes',1,4);

/**
 * Manage output of wp_title()
 */
function roots_wp_title($title) {
	if (is_feed()) {
		return $title;
	}
	$title .= get_bloginfo('name');
	return $title;
}
add_filter('wp_title', 'roots_wp_title', 10);

/**
 *  Custon Post Type - Location
 */
add_action('init', 'cptui_register_my_cpt_location');
function cptui_register_my_cpt_location() {
	register_post_type('location', array(
		'label' => 'Locations',
		'description' => '',
		'public' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'capability_type' => 'post',
		'map_meta_cap' => true,
		'hierarchical' => false,
		'rewrite' => array('slug' => 'location', 'with_front' => true),
		'query_var' => true,
		'supports' => array('title','editor','excerpt','trackbacks','custom-fields','comments','revisions','thumbnail','author','page-attributes','post-formats'),
		'labels' => array (
			'name' => 'Locations',
			'singular_name' => 'Location',
			'menu_name' => 'Locations',
			'add_new' => 'Add Location',
			'add_new_item' => 'Add New Location',
			'edit' => 'Edit',
			'edit_item' => 'Edit Location',
			'new_item' => 'New Location',
			'view' => 'View Location',
			'view_item' => 'View Location',
			'search_items' => 'Search Locations',
			'not_found' => 'No Locations Found',
			'not_found_in_trash' => 'No Locations Found in Trash',
			'parent' => 'Parent Location',
			)
		) ); }

/**
 * Custom Post Type - Floorplan
 */
add_action('init', 'cptui_register_my_cpt_floorplan');
	function cptui_register_my_cpt_floorplan() {
		register_post_type('floorplan', array(
			'label' => 'Floorplans',
			'description' => '',
			'public' => false,
			'show_ui' => true,
			'show_in_menu' => true,
			'capability_type' => 'post',
			'map_meta_cap' => true,
			'hierarchical' => false,
			'rewrite' => array('slug' => 'floorplans', 'with_front' => true),
			'query_var' => true,
			'supports' => array('title','editor','excerpt','trackbacks','custom-fields','comments','revisions','thumbnail','author','page-attributes','post-formats'),
			'labels' => array (
				'name' => 'Floorplans',
				'singular_name' => 'Floor plan',
				'menu_name' => 'Floor Plans',
				'add_new' => 'Add Floorplan',
				'add_new_item' => 'Add New Floorplan',
				'edit' => 'Edit',
				'edit_item' => 'Edit Floorplan',
				'new_item' => 'New Floorplan',
				'view' => 'View Floorplan',
				'view_item' => 'View Floorplan',
				'search_items' => 'Search Floorplans',
				'not_found' => 'No Floorplans Found',
				'not_found_in_trash' => 'No Floorplans Found in Trash',
				'parent' => 'Parent Floorplan',
				)
			) ); }

/**
 * Custom Fields
 */
if(function_exists("register_field_group")) {
  /* Floor Plans */
	register_field_group(array (
		'id' => 'acf_floorplans',
		'title' => 'Floorplans',
		'fields' => array (
			array (
				'key' => 'field_5419c015b4440',
				'label' => 'Bedrooms',
				'name' => 'bedrooms',
				'type' => 'text',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
				),
			array (
				'key' => 'field_5419c01cb4441',
				'label' => 'Bathrooms',
				'name' => 'bathrooms',
				'type' => 'text',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
				),
			array (
				'key' => 'field_5419c023b4442',
				'label' => 'Square Feet',
				'name' => 'square_feet',
				'type' => 'text',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
				),
			array (
				'key' => 'field_5419c02ab4443',
				'label' => 'Price',
				'name' => 'price',
				'type' => 'text',
				'required' => 1,
				),
			array (
				'key' => 'field_5419c032b4444',
				'label' => 'Download',
				'name' => 'download',
				'type' => 'file',
				'save_format' => 'object',
				'library' => 'all',
				),
			),
'location' => array (
	array (
		array (
			'param' => 'post_type',
			'operator' => '==',
			'value' => 'floorplan',
			'order_no' => 0,
			'group_no' => 0,
			),
		),
	),
'options' => array (
	'position' => 'normal',
	'layout' => 'no_box',
	'hide_on_screen' => array (
		0 => 'the_content',
		1 => 'excerpt',
		2 => 'custom_fields',
		3 => 'discussion',
		4 => 'comments',
		5 => 'revisions',
		6 => 'slug',
		7 => 'author',
		8 => 'format',
		9 => 'categories',
		10 => 'tags',
		11 => 'send-trackbacks',
		),
	),
'menu_order' => 0,
));

/* Locations */
register_field_group(array (
	'id' => 'acf_locations',
	'title' => 'Locations',
	'fields' => array (
		array (
			'key' => 'field_5422f59176380',
			'label' => 'Address',
			'name' => 'address',
			'type' => 'text',
			'required' => 1,
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'formatting' => 'html',
			'maxlength' => '',
			),
		array (
			'key' => 'field_5422f59876381',
			'label' => 'Website',
			'name' => 'website',
			'type' => 'text',
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'formatting' => 'html',
			'maxlength' => '',
			),
		array (
			'key' => 'field_5422f8e03ce4a',
			'label' => 'Category',
			'name' => 'category',
			'type' => 'select',
			'required' => 1,
			'choices' => array (
				'food' => 'Food',
				'coffee' => 'Coffee',
				'shopping' => 'Shopping',
				'fun' => 'Fun',
				'school' => 'School',
				),
			'default_value' => '',
			'allow_null' => 0,
			'multiple' => 0,
			),
		array (
			'key' => 'field_5422f5a376382',
			'label' => 'Latitude',
			'name' => 'latitude',
			'type' => 'text',
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'formatting' => 'html',
			'maxlength' => '',
			),
		array (
			'key' => 'field_5422f5a776383',
			'label' => 'Longitude',
			'name' => 'longitude',
			'type' => 'text',
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'formatting' => 'html',
			'maxlength' => '',
			),
		),
'location' => array (
	array (
		array (
			'param' => 'post_type',
			'operator' => '==',
			'value' => 'location',
			'order_no' => 0,
			'group_no' => 0,
			),
		),
	),
'options' => array (
	'position' => 'normal',
	'layout' => 'no_box',
	'hide_on_screen' => array (
		0 => 'permalink',
		1 => 'the_content',
		2 => 'excerpt',
		3 => 'custom_fields',
		4 => 'discussion',
		5 => 'comments',
		6 => 'revisions',
		7 => 'slug',
		8 => 'author',
		9 => 'format',
		10 => 'featured_image',
		11 => 'categories',
		12 => 'tags',
		13 => 'send-trackbacks',
		),
	),
'menu_order' => 0,
));
}


