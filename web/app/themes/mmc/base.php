<?php 
/**
 *  Base Template
 */

get_template_part('templates/head'); ?>

<body <?php body_class(); ?> class="not-loaded">
	<?php
	do_action('get_header');
	get_template_part('templates/header');

	if (is_singular('project')) {
		get_template_part('modules/slider');
	}
	?>

	<div class="container">
		<div class="row">
			<?php if (roots_display_sidebar()) : ?>
				<aside id="sidebar" class="<?php echo roots_sidebar_class(); ?>" role="complementary">
					<?php include roots_sidebar_path(); ?>
				</aside>
			<?php endif; ?>

			<main id="<?php echo $post->post_name;?>"  class="<?php echo  roots_main_class(); ?>" role="main">
				<?php include roots_template_path(); ?>
			</main>

		</div>
	</div>

	<?php get_template_part('templates/footer'); ?>

	<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<?php wp_footer(); ?>
</body>
</html>
