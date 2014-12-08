<!-- Slider -->
<div id="<?php echo $post->post_name; ?>-slider" class="slick-slider">

	<?php
	$i = 0;
	$slider_images = get_field('slider_images');
	foreach ($slider_images as $image) {
		$class = '';
		if($i === 0) {
			$class = 'slick-active';
		}
		echo '<div class="slide-'. $i .' ' . $class . '"><img class="img-responsive" src="'. $image['url'] .'"></div>';
		$i++;
	}
	?>
</div>