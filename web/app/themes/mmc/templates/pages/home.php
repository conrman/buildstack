<?php 
$badge = get_field('badge_image'); 
$contact_images = get_field('contact_images');
?>

<section>
	<div class="slide-wrapper">
		<!-- Slider -->
		<?php get_template_part('templates/modules/slider'); ?>

		<!-- Badge -->
		<img class="badge animated fadeInDown" src="<?php echo $badge['url']; ?>" alt="">
	</div>
</section>

<section class="romance">
	<div class="romance-wrapper">
		<div class="container">
			<div class="row text-center">
				<div class="span-10">
					<div class="content">
						<?php the_content(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="map">
	<div class="map-wrapper">
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
		<a class="map-gfx" href="/location">
			<img src="<?php bloginfo('template_directory'); ?>/assets/images/gfx_homepage_map.png" alt="">
		</a>
	</div>
</section>

<div class="bar">
	<img src="<?php bloginfo('template_directory'); ?>/assets/images/gfx_homepage_teal_grunge_leasenow_bar.png" alt="">
	<a class="span-6 lease-now-link" href="#lease-now-link">
		<img class="lease-now" src="<?php bloginfo('template_directory'); ?>/assets/images/gfx_lease_now_arrow.png" alt="">
	</a>
</div>

<section class="contact">
	<div class="row bp1 block-columns text-center">
		<?php 
		$i = 1;
		foreach ($contact_images as $image) : ?>
		<div class="span-4">
			<div class="contact-badge-<?php echo $i; ?>">
				<img class="contact-image" src="<?php echo $image['url']; ?>">
			</div>
		</div>
		<?php 
		$i++;
		endforeach;
		?>
	</div>
</section>