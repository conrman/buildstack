<!-- Floor Plans -->

<!-- Bedroom Nav -->
<nav class="floorplans-bed-nav">
	<div class="container">
		<div class="row">
			<div class="span-12">
				<div class="span-3 text-center">
					<div class="bed-select active" data-beds="one">One Bedroom</div>
				</div>
				<div class="span-3 text-center">
					<div class="bed-select" data-beds="two">Two Bedroom</div>
				</div>
				<div class="span-3 text-center">
					<div class="bed-select" data-beds="three">Three Bedroom</div>
				</div>
				<div class="span-3 text-center">
					<div class="bed-select" data-beds="townhome">Townhome</div>
				</div>
			</div>
		</div>
	</div>
</nav>

<?php $floorplans = get_posts(array('post_type' => 'floorplan', 'numberposts' => 10, 'order' => 'asc')); ?>

<section class="page-wrapper">
	<div class="container">
		<?php $i = 1;
		if (!empty($floorplans)) : foreach ($floorplans as $post) : setup_postdata($post); ?>
		<?php echo "<!-- ".get_the_title()." Floorplan -->"; ?>
		<div class="floorplan-excerpt active" 
			data-beds="<?php echo bedsToString(get_field('bedrooms')); ?>"
			data-floorplan="<?php echo get_the_title(); ?>">
			<?php get_template_part('templates/modules/floorplan', 'image'); ?>
			<?php get_template_part('templates/modules/floorplan', 'info'); ?>
		</div>
		<div class="floorplan-unit" 
			data-floorplan="<?php echo get_the_title(); ?>">
			<?php get_template_part('templates/modules/floorplan', 'image'); ?>
			<?php get_template_part('templates/modules/floorplan', 'info'); ?>
		</div>
		<?php $i++;
		endforeach; endif; ?>
	</div>
</section>
