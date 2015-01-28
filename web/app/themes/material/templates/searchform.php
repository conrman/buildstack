<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
	<div class="input-field">
		<input type="search" value="<?php echo get_search_query(); ?>" name="s" class="search-field box" placeholder="<?php _e('Search', 'roots'); ?>">
		<button type="submit" class="btn btn-submit"><?php _e('<i class="mdi-action-search"></i>', 'roots'); ?></button>
	</div>
</form>
