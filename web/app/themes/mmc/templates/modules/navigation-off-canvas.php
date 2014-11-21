<!-- Off Canvas Menu -->
<nav class="off-canvas-nav">
	<div id="off-canvas-nav">
		<?php
		if (has_nav_menu('sidebar_navigation')) :
			wp_nav_menu(array('theme_location' => 'off-canvas-nav', 'menu_class' => 'side-nav'));
		endif;
		?>
	</div>
</nav>
