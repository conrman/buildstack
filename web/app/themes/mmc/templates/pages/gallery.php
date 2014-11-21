<?php get_template_part('templates/modules/jumbotron'); ?>

<?php $gallery_thumbnails = get_field('gallery_thumbnails'); ?>
<?php $gallery_images = get_field('gallery_images'); ?>

<section class="grid-gallery">
	<div class="container">
		<div class="row text-center">
			<?php 
			$i = 0;
			foreach ($gallery_thumbnails as $image) : ?>
			<a class="grid-item fancybox" href="<?php echo $gallery_images[$i]['url']; ?>">
				<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
			</a>
			<?php $i++;
			endforeach;
			?>
		</div>
	</div>
</section>

<div class="bar">
	<!-- <img src="<?php bloginfo('template_directory'); ?>/assets/images/gfx_gallery_blue_grungy_bar.png" alt=""> -->
	<h2>life is an adventure...live life here.</h2>
</div>