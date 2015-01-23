<form role="search" method="get" class="search-form form-inline" action="<?php echo esc_url(home_url('/')); ?>">
	<div class="input-group">
		<input type="search" value="<?php echo get_search_query(); ?>" name="s" class="search-field box" placeholder="<?php _e('Search', 'roots'); ?>">
		<button type="submit" class="search-submit button"><?php _e('<i class="fa fa-search"></i>', 'roots'); ?></button>
	</div>
</form>
