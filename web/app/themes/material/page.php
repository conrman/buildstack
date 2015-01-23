<?php 
/* * *
 *  Default Page Template
 */
while (have_posts()) { 
	the_post(); 
	get_template_part('templates/content', 'page'); 
}
?>