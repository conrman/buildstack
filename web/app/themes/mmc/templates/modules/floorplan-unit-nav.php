<!-- Unit Nav -->
<nav class="floorplans-unit-nav">
	<div class="container">
		<div class="row text-center">
			<div class="span-8">
				<div class="bedroom-units">
					<?php $i = 1;
					foreach ($floorplans as $post) : setup_postdata($post); ?>
					<div class="bed-unit <?php echo ($i == 1) ? "active" : ""; ?>" 
						data-floorplan="<?php echo $i; ?>" 
						data-beds="<?php echo get_field('bedrooms'); ?>">
						<span><?php the_title(); ?></span>
					</div>
					<?php $i++;
					endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</nav>