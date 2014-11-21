<?php global $display_options; ?>

<div class="info-social">
	<?php if (!empty($display_options['facebook'])) : ?>
		<a href="<?php echo $display_options['facebook']; ?>" class="fa fa-stack" target="_blank">
			<i class="fa fa-stack-2x fa-circle"></i>
			<i class="fa fa-stack-1x fa-facebook"></i>
		</a>
	<?php endif; ?>
	<?php if (!empty($display_options['twitter'])) : ?>
		<a href="<?php echo $display_options['twitter']; ?>" class="fa fa-stack" target="_blank">
			<i class="fa fa-stack-2x fa-circle"></i>
			<i class="fa fa-stack-1x fa-twitter"></i>
		</a>
	<?php endif; ?>
	<?php if (!empty($display_options['pinterest'])) : ?>
		<a href="<?php echo $display_options['pinterest']; ?>" class="fa fa-stack" target="_blank">
			<i class="fa fa-stack-2x fa-circle"></i>
			<i class="fa fa-stack-1x fa-pinterest"></i>
		</a>
	<?php endif; ?>
	<?php if (!empty($display_options['instagram'])) : ?>
		<a href="<?php echo $display_options['instagram']; ?>" class="fa fa-stack" target="_blank">
			<i class="fa fa-stack-2x fa-circle"></i>
			<i class="fa fa-stack-1x fa-instagram"></i>
		</a>
	<?php endif; ?>
	<?php if (!empty($display_options['linkedin'])) : ?>
		<a href="<?php echo $display_options['linkedin']; ?>" class="fa fa-stack" target="_blank">
			<i class="fa fa-stack-2x fa-circle"></i>
			<i class="fa fa-stack-1x fa-linkedin"></i>
		</a>
	<?php endif; ?>
</div>