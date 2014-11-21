<?php global $display_options; ?>
<?php $contact_badge_1 = get_field('contact_badge_1'); ?>
<?php $contact_badge_2 = get_field('contact_badge_2'); ?>
<?php $contact_form_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );?>
<?php get_template_part('templates/modules/jumbotron'); ?>

<div class="bar">
	<img src="<?php bloginfo('template_directory'); ?>/assets/images/gfx_homepage_teal_grunge_leasenow_bar.png" alt="">
	<div class="span-6 lets-get-together-wrapper">
		<img class="lets-get-together" src="<?php bloginfo('template_directory'); ?>/assets/images/gfx_contact_letsgettogether.png" alt="">
	</div>
</div>

<section class="contact">
	<div class="row bp1 contact-form">
		<div class="contact-form-wrapper" data-mh="contact-form" style="background-image: url('<?php echo $contact_form_image; ?>');">
			<div class="row bp1 text-center">
				<div class="span-8">
					<div class="contact-form">
						<?php the_content(); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="contact-badge-wrapper" data-mh="contact-form">
			<div class="row bp1 text-center">
				<div class="badge bg-brand-2">
					<img src="<?php echo $contact_badge_1['url']; ?>" alt="">
				</div>
				<div class="badge bg-brand-3">
					<a href="http://google.com/maps/place/<?php echo $display_options['address'] . ' ' . $display_options['city'] . ' ' . $display_options['state']; ?>" target="_blank"><img src="<?php echo $contact_badge_2['url']; ?>" alt=""></a>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="office-hours bg-brand-1">
	<div class="container">
		<div class="row text-center">
			<div class="span-10">
				<h2>Office Hours</h2>
				<p><?php echo get_field('office_hours'); ?></p>
			</div>
		</div>
	</div>
</div>