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
		echo "</a> <i class='mdi-hardware-keyboard-arrow-right'></i> ";
		if (is_category() || is_single()) {
			the_category('title_li=');
			if (is_single()) {
				echo " <i class='mdi-hardware-keyboard-arrow-right'></i> ";
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
 *  Projects Custom Post Type
 */
function my_custom_post_project() {
	$labels = array(
	                'name'               => _x( 'Projects', 'post type general name' ),
	                'singular_name'      => _x( 'Project', 'post type singular name' ),
	                'add_new'            => _x( 'Add New', 'project' ),
	                'add_new_item'       => __( 'Add New Project' ),
	                'edit_item'          => __( 'Edit Project' ),
	                'new_item'           => __( 'New Project' ),
	                'all_items'          => __( 'All Projects' ),
	                'view_item'          => __( 'View Project' ),
	                'search_items'       => __( 'Search Projects' ),
	                'not_found'          => __( 'No projects found' ),
	                'not_found_in_trash' => __( 'No projects found in the Trash' ), 
	                'parent_item_colon'  => '',
	                'menu_name'          => 'Projects'
	                );
	$args = array(
	              'labels'        	=> $labels,
	              'description'   	=> 'Holds our project and project specific data',
	              'public'        	=> true,
	              'menu_position' => 5,
	              'show_in_nav_menus' => true,
	              'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt'),
	              'has_archive'   => true,
	              );
	register_post_type( 'project', $args ); 
}
add_action( 'init', 'my_custom_post_project' );

/***
 *  Project Messages
 */
function my_updated_messages( $messages ) {
	global $post, $post_ID;
	$messages['product'] = array(
	                             0 => '', 
	                             1 => sprintf( __('Project updated. <a href="%s">View project</a>'), esc_url( get_permalink($post_ID) ) ),
	                             2 => __('Custom field updated.'),
	                             3 => __('Custom field deleted.'),
	                             4 => __('Project updated.'),
	                             5 => isset($_GET['revision']) ? sprintf( __('Project restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
	                             6 => sprintf( __('Project published. <a href="%s">View project</a>'), esc_url( get_permalink($post_ID) ) ),
	                             7 => __('Project saved.'),
	                             8 => sprintf( __('Project submitted. <a target="_blank" href="%s">Preview project</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	                             9 => sprintf( __('Project scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview project</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
	                             10 => sprintf( __('Project draft updated. <a target="_blank" href="%s">Preview project</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	                             );
return $messages;
}
add_filter( 'post_updated_messages', 'my_updated_messages' );

/***
 *  Project Taxonomies
 */
function my_taxonomies_project() {
	$labels = array(
	                'name'              => _x( 'Project Categories', 'taxonomy general name' ),
	                'singular_name'     => _x( 'Project Category', 'taxonomy singular name' ),
	                'search_items'      => __( 'Search Project Categories' ),
	                'all_items'         => __( 'All Project Categories' ),
	                'parent_item'       => __( 'Parent Project Category' ),
	                'parent_item_colon' => __( 'Parent Project Category:' ),
	                'edit_item'         => __( 'Edit Project Category' ), 
	                'update_item'       => __( 'Update Project Category' ),
	                'add_new_item'      => __( 'Add New Project Category' ),
	                'new_item_name'     => __( 'New Project Category' ),
	                'menu_name'         => __( 'Project Categories' ),
	                );
	$args = array(
	              'labels' => $labels,
	              'hierarchical' => true,
	              );
	register_taxonomy( 'projects', 'project', $args );
}
add_action( 'init', 'my_taxonomies_project', 0 );