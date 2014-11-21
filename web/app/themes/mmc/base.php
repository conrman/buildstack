<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?> class="not-loaded"><div id="site-content">

	<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
	<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
	<!--[if IE 8]>         <html class="no-js lt-ie9"><div class="alert alert-warning"><?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'roots'); ?></div><![endif]-->

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
				<aside class="sidebar <?php echo roots_sidebar_class(); ?>" role="complementary">
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
