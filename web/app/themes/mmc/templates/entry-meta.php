<span class="byline author vcard">
	<span class="fa-stack">
    	<i class="fa fa-circle fa-stack-2x text-brand-3"></i>
		<i class="fa fa-user fa-stack-1x"></i>
	</span>
	<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn">
		<?php echo get_the_author(); ?>
	</a>

</span>
&nbsp;
<time class="published" datetime="<?php echo get_the_time('c'); ?>"><?php echo get_the_date(); ?></time>