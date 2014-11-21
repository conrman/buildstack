<?php 
$feature_1 = get_field('feature_1'); 
$feature_2 = get_field('feature_2'); 
$feature_3 = get_field('feature_3'); 
?>

<figure class="feature">
	<img class="img-responsive" src="<?php echo $feature_1['url']; ?>" alt="">
	<figcaption class="feature-caption">
		<h1 class="caption-1"><span><?php echo $feature_1['caption']; ?></span></h1>
	</figcaption>
</figure>

<section class="apartment-amenities">
	<div class="amenities-wrapper">
		<div class="container">
			<div class="row text-center">
				<img src="<?php bloginfo('template_directory'); ?>/assets/images/gfx_amenities_apartment_tag.png" alt="">
				<div class="span-10 content">
					<?php echo get_field('apartment_amenities'); ?>
				</div>
			</div>
		</div>
	</div>
</section>

<figure class="feature">
	<img class="img-responsive" src="<?php echo $feature_2['url']; ?>" alt="">
	<figcaption class="feature-caption">
		<h1 class="caption-2"><span><?php echo $feature_2['caption']; ?></span></h1>
	</figcaption>
</figure>

<section class="community-amenities">
	<div class="amenities-wrapper">
		<div class="container">
			<div class="row text-center">
				<img src="<?php bloginfo('template_directory'); ?>/assets/images/gfx_amenities_community_tag.png" alt="">
				<div class="span-10 content">
					<?php echo get_field('community_amenities'); ?>
				</div>
				<p class="disclaimer">Amenities subject to change.</p>
			</div>
		</div>
	</div>
</section>

<figure class="feature">
	<img class="img-responsive" src="<?php echo $feature_3['url']; ?>" alt="">
	<figcaption class="feature-caption">
		<h1 class="caption-3"><span><?php echo $feature_3['caption']; ?></span></h1>
	</figcaption>
</figure>