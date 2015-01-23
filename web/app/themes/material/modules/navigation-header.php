<!-- Primary Navigation -->
<?php if (has_nav_menu('primary_navigation')) {
	wp_nav_menu( array('theme_location' => 'primary_navigation', 'menu_id' => 'nav-mobile', 'menu_class' => 'side-nav') );
} ?>