<?php
/*
 * Template Name: Floor Plans Page Template
 */

$args = array( 'post_type' => 'floorplan', 'posts_per_page' => 100);
$loop = new WP_Query( $args ); ?>

<section>
	<div class="container">
		<div class="row">
			<div class="floorplans-wrapper col l12">
				<?php if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post();  ?>

					<div class="col s12 m6 l4">
						<a class="floorplan" href="<?php echo the_permalink(); ?>">
							<div href="<?php echo the_permalink(); ?>" class="floorplan-image">
								<?php the_post_thumbnail('', array('class' => 'responsive')); ?>
							</div>
							<div class="floorplan-title">
								<span><?php the_title(); ?></span>
							</div>
						</a>
					</div>

				<?php endwhile; endif; ?>
			</div>
		</div>
	</div>
</section>