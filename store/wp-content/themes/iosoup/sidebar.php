<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package understrap
 */

if ( ! is_active_sidebar( 'primary-widget-area' ) ) {
	return;
}
?>

<div id="secondary" class="col-md-4 col-sm-5 widget-area" role="complementary">

	<?php dynamic_sidebar( 'primary-widget-area' ); ?>

</div><!-- #secondary -->
