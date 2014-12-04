<!-- Default Page Template -->

<?php get_template_part('templates/modules/jumbotron'); ?>
<section class="page-wrapper">
	<div class="container">
		<div class="row">
			<?php while (have_posts()) : the_post(); ?>
				<?php get_template_part('templates/content', 'page'); ?>
			<?php endwhile; ?>
		</div>
	</div>
</section>