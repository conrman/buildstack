<?php 
global $display_options;
?>
<?php get_template_part('templates/modules/jumbotron'); ?>
<div class="bar">
	<img src="<?php bloginfo('template_directory'); ?>/assets/images/gfx_homepage_teal_grunge_leasenow_bar.png" alt="">
	<div class="span-6">
		<img class="lease-now" src="<?php bloginfo('template_directory'); ?>/assets/images/gfx_residents_our_residents.png" alt="">
	</div>
</div>

<section class="container">
	<?php the_content(); ?>
</section>


<div class="content">
	<div class="row text-center">
		<a href="<?php echo $display_options['residents_link']; ?>" class="button large" target="_blank">
			<h2 class="font-1">Resident Portal</h2>
			<span class="font-3 large">LOG IN</span>
		</a>
	</div>
</div>

<section class="romance">
	<div class="romance-wrapper">
		<div class="container">
			<div class="row text-center">
				<div class="span-12 romance-thumbnails-wrapper">
					<div class="romance-thumbnails">
						<!-- Romance 3 column images -->
						<?php get_template_part('templates/modules/romance', 'columns') ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>