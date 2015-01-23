<?php while (have_posts()) : the_post(); ?>
	<article <?php post_class(); ?>>
		<header>
			<h2 class="article-title"><?php the_title(); ?></h2>
		</header>
		<div class="row">
		<?php if (get_field('secondary_content')) : ?>
			<div class="col s12 m6 l6">
				<div class="secondary-content">
					<?php the_field('secondary_content'); ?>
				</div>
			</div>
			<div class="col s12 m6 l6">
				<div class="content">
					<?php the_content(); ?>
				</div>
			</div>
		<?php else: ?>
			<div class="col s12 m12 l12">
				<div class="content">
					<?php the_content(); ?>
				</div>
			</div>
		<?php endif; ?>
		</div>
		<footer>
			<?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
		</footer>
	</article>
<?php endwhile; ?>
