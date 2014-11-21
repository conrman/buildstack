<?php get_template_part('templates/modules/jumbotron'); ?>

<!-- Bedroom Nav -->
<nav class="floorplans-bed-nav">
	<div class="container">
		<div class="row text-center">
			<div class="span-4">
				<a class="bed-select active" data-beds="one bedroom" href="javascript:;">
					<img src="<?php bloginfo('template_directory'); ?>/assets/images/gfx_floorplans_one_bedroom_arrow_over.png" data-swap="<?php bloginfo('template_directory'); ?>/assets/images/gfx_floorplans_one_bedroom_arrow.png">
				</a>
			</div>
			<div class="span-4">
				<a class="bed-select" data-beds="two bedroom" href="javascript:;">
					<img src="<?php bloginfo('template_directory'); ?>/assets/images/gfx_floorplans_two_bedroom_arrow.png" data-swap="<?php bloginfo('template_directory'); ?>/assets/images/gfx_floorplans_two_bedroom_arrow_over.png">
				</a>
			</div>
		</div>
	</div>
</nav>

<?php 
$args = array('post_type' => 'floorplan', 'numberposts' => 10, 'order' => 'asc');
$floorplans = get_posts($args);
?>

<!-- Unit Nav -->
<nav class="floorplans-unit-nav">
	<div class="container">
		<div class="row text-center">
			<div class="span-8">
				<div class="bedroom-units">
					<?php
					$i = 1;
					foreach ($floorplans as $post) : setup_postdata($post); ?>
					<div class="bed-unit <?php echo ($i == 1) ? "active" : ""; ?>" data-floorplan="<?php echo $i; ?>" data-beds="<?php echo get_field('bedrooms'); ?>"><span><?php the_title(); ?></span></div>
					<?php
					$i++;
					endforeach;
					?>
				</div>
			</div>
		</div>
	</div>
</nav>

<!-- Floorplan -->
<section>
	<?php 
	$i = 1;
	foreach ($floorplans as $post) : setup_postdata($post); ?>
	<div class="floorplan-unit" <?php echo ($i != 1) ? 'style="display:none"' : ''; ?> data-floorplan="<?php echo $i; ?>">

		<div class="container">
			<div class="row">

				<!-- Floorplan Info -->
				<div class="unit-info">
					<div class="container">
						<div class="row text-center">
							<div class="span-8">
								<h1>
									<span class="beds"><?php echo get_field('bedrooms'); ?></span>&nbsp;&nbsp;
									<span class="baths"><?php echo get_field('bathrooms'); ?></span>&nbsp;&nbsp;
									<span class="sqft"><?php echo get_field('square_footage'); ?></span>
								</h1>
							</div>
						</div>
					</div>
				</div>

				<!-- Floorplan Image -->
				<div class="floorplan-image text-center">
					<?php $fp_image = get_field('floor_plan_image'); ?>
					<img src="<?php echo $fp_image['url']; ?>" alt="<?php echo $fp_image['alt']; ?>" title="<?php echo $fp_image['title']; ?>">
				</div>

				<!-- Mits Feed -->
				<div class="container">
					<div class="row bp1 text-center">
						<div class="span-6">
							<form class="mits-feed-availability" action="">
								<span>Lease This Floor Plan</span>
								<select class="box" name="unit-select">
									<option value="" disabled selected>Find Me a Home!</option>
								</select>
								<select class="box" name="movein-date">
									<option value="" disabled selected>Move-in Date</option>
								</select>
								<input type="submit" class="button submit-button" value="Submit">
							</form>
							<p class="disclaimer">Floor plans are artist’s rendering. All dimensions are approximate. Actual product and specifications may vary in dimension or detail. Not all features are available in every apartment. Prices and availability are subject to change. Please see a representative for details.</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Floorplan Share -->
		<div class="floorplan-share">
			<div class="row text-center">
				<?php $download = get_field('download_file'); ?>
				<span class="share">Share this Floor Plan:</span>
				<a class="fa-stack" target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo bloginfo('url'); ?>/floor-plans"><i class="fa fa-stack-2x fa-circle"></i><i class="fa fa-stack-1x fa-facebook"></i></a>
				<a class="fa-stack" target="_blank" href="https://twitter.com/share?url=<?php echo bloginfo('url'); ?>/floor-plans"><i class="fa fa-stack-2x fa-circle"></i><i class="fa fa-stack-1x fa-twitter"></i></a>
				<a class="fa-stack" target="_blank" href="https://pinterest.com/pin/create/button/?<?php echo bloginfo('url'); ?>/floor-plans&media=<?php echo $image['url']; ?>"><i class="fa fa-pinterest fa-2x"></i></a>
				<?php if(!empty($download)) { ?>
					<a class="fa-stack" target="_blank" href="<?php echo $download['url']; ?>"><i class="fa fa-stack-2x fa-circle"></i><i class="fa fa-stack-1x fa-download"></i></a>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php
	$i++;
	endforeach;
	?>
</section>
