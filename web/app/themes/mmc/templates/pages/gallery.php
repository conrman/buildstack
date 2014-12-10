<!-- Gallery -->

<?php $gallery_images = get_field('gallery_images'); ?>
<?php $gallery_thumbnails = get_field('gallery_thumbnails'); ?>

<section class="page-wrapper">
	<div class="container">
		<div id="gallery-collage">
			<?php $i = 0;
			if (!empty($gallery_thumbnails)) : foreach ($gallery_thumbnails as $image) : ?>
			<a class="gallery-item fancybox" href="<?php echo $gallery_images[$i]['url']; ?>" rel="gallery">
				<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
			</a>
			<?php $i++;
			endforeach; endif;
			?>
		</div>
	</div>
</section>