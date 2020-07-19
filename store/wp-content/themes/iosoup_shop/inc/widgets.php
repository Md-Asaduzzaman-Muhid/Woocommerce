<?php

function blankpress_widgets_init() {

	register_sidebar( array(
		'name' => __( 'Primary Widget Area', 'Blankpress' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The primary widget area', 'Blankpress' ),
		'before_widget' => '<aside id="%1$s" class="widget wow fadeInUp %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 2, located below the Primary Widget Area in the sidebar. Empty by default.
	register_sidebar( array(
		'name' => __( 'Secondary Widget Area', 'Blankpress' ),
		'id' => 'secondary-widget-area',
		'description' => __( 'The secondary widget area', 'Blankpress' ),
		'before_widget' => '<aside id="%1$s" class="widget wow fadeInUp %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'blankpress_widgets_init' );
