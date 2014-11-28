<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?> class="not-loaded"><div id="site-content">

	<?php
	do_action('get_header');
	get_template_part('templates/header');
	?>

	<div class="wrapper" role="document">
		<!-- Main Content -->
		<div class="row">
			<main id="main" class="<?php echo $post->post_name . ' ' . roots_main_class(); ?>" role="main">
				<?php include roots_template_path(); ?>
			</main><!-- /.main -->
			<?php if (roots_display_sidebar()) : ?>
				<aside id="sidebar" class="<?php echo roots_sidebar_class(); ?>" role="complementary">
					<?php include roots_sidebar_path(); ?>
				</aside><!-- /.sidebar -->
			<?php endif; ?>
		</div>
	</div><!-- /.wrapper -->

	<?php get_template_part('templates/footer'); ?>

	<!-- Site Overlay -->
	<div class="site-overlay"></div>

	<!-- Scroll to top icon-->
	<a class="fa fa-angle-up scroll-top" href="#site-content"></a>

</div><!-- #site-content -->

<?php get_template_part('templates/modules/navigation', 'off-canvas'); ?>

</body>
</html>
