<!-- Jumbotron -->
<?php if (get_field('use_jumbotron')) : ?>
	<div id="<?php echo $post->post_name; ?>-jumbotron" class="jumbotron no-pad-bot">
		<?php if (get_field('use_bg_image')) {
			$img = get_field('jumbotron_image');
			echo '<img class="jumbotron-image" src="' . $img['url'] . '">';
		} ?>
		<div class="container">
			<div class="jumbotron-text">
				<?php the_field('jumbotron_text'); ?>
			</div>
		</div>
	</div>
<?php endif; ?>