<div class="main-nav">
	<div class="info-wrapper">
		<?php get_template_part('templates/modules/info-address'); ?>
		<?php get_template_part('templates/modules/info-phone'); ?>
		<?php get_template_part('templates/modules/info-portal'); ?>
		<?php get_template_part('templates/modules/info-social'); ?>
	</div>

	<?php
	if (has_nav_menu('primary_navigation')) :
		wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_id' => 'main-nav'));
	endif;
	?>
</div>
