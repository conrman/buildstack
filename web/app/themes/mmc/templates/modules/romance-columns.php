<div class="row bp0">
	<?php 
	$romance_images = get_field('romance_images');
	foreach ($romance_images as $image) {
		echo '<div class="span-4"><img class="romance-image" src="' . $image['url'] . '"></div>';
	} ?>
</div>