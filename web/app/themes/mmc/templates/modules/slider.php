<div id="<?php echo $post->post_name; ?>-slider" class="slick-slider">

	<?php
	$i = 0;
	$slider_images = get_field('slider_images');
	foreach ($slider_images as $image) {
		echo '<div class="slide-'. $i .'"><img class="img-responsive" src="'. $image['url'] .'"></div>';
		$i++;
	}
	?>

</div>