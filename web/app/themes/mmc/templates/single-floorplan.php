<div class="col">
	<?php while (have_posts()) : the_post(); ?>
		<article <?php post_class(); ?>>
			<aside class="col s12 m4 l3">				
				<header>
					<h6><?php the_title(); ?></h6>
				</header>

				<div class="floorplan-info">
					<?php get_template_part('templates/modules/floorplan', 'info'); ?>
					<?php get_template_part('templates/modules/floorplan', 'share'); ?>
				</div>

			</aside>

			<div class="col s12 m8 l9">
				<div class="section">
					<?php get_template_part('templates/modules/floorplan', 'image'); ?>
				</div>
				
				<?php the_content(); ?>
			</div>
			<footer>
				<?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
			</footer>
		</article>
	<?php endwhile; ?>
</div>