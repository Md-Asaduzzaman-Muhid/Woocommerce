<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="searchFormBox">
		<label class="screen-reader-text sr-only"><?php _x( 'Search for:', 'label' ); ?></label>
		<input type="text" value="<?php echo get_search_query(); ?>" name="s" placeholder="Search"autocomplete="off" />
		<button type="submit" class="searchsubmit"><i class="fa fa-search" aria-hidden="true"></i></button>
	</div>
</form>
