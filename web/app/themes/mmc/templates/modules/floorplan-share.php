<!-- Floorplan Share -->
<div class="floorplan-share">
	<div class="row text-center">
		<?php $download = get_field('download_file'); ?>
		<span class="share">Share this Floor Plan:</span>
		<a class="fa-stack" target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo bloginfo('url'); ?>/floor-plans"><i class="fa fa-stack-2x fa-circle"></i><i class="fa fa-stack-1x fa-facebook"></i></a>
		<a class="fa-stack" target="_blank" href="https://twitter.com/share?url=<?php echo bloginfo('url'); ?>/floor-plans"><i class="fa fa-stack-2x fa-circle"></i><i class="fa fa-stack-1x fa-twitter"></i></a>
		<a class="fa-stack" target="_blank" href="https://pinterest.com/pin/create/button/?<?php echo bloginfo('url'); ?>/floor-plans&media=<?php echo $image['url']; ?>"><i class="fa fa-pinterest fa-2x"></i></a>
		<?php if(!empty($download)) { ?>
		<a class="fa-stack" target="_blank" href="<?php echo $download['url']; ?>"><i class="fa fa-stack-2x fa-circle"></i><i class="fa fa-stack-1x fa-download"></i></a>
		<?php } ?>
	</div>
</div>
