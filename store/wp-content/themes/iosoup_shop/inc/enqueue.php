<?php
/**
 * understrap enqueue scripts
 *
 * @package understrap
 */

/**
 *  INSTALOGIC DEV/PRODUCTION Switch
 *
 */
define('INSTA_DEV', true);
define('VERSION', '1.00');


function theme_script() {
    wp_enqueue_style( 'font-lato', 'https://fonts.googleapis.com/css?family=Lato:400,300,700,900,400italic' );

    // include custom jQuery
    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true);

    if(INSTA_DEV) {
        //development files
        wp_enqueue_style( 'bundle', get_stylesheet_directory_uri() . '/assets/css/bundle.css', array(), time(), 'all' );
        wp_enqueue_style( 'theme', get_stylesheet_directory_uri() . '/assets/css/theme.css', array(), time(), 'all' );
        wp_enqueue_style( 'theme-style', get_stylesheet_uri(), array(), time(), 'all' );

        //wp_enqueue_script('jquery');
    	wp_enqueue_script( 'bundle', get_template_directory_uri() . '/assets/js/bundle.js', array('jquery'), VERSION, true );


    } else {
        //production
       wp_enqueue_style( 'main', get_stylesheet_directory_uri() . '/assets/css/theme.min.css', array(), VERSION, 'all' );

       wp_enqueue_style( 'theme-style', get_stylesheet_uri(), array(), VERSION, 'all' );

       // wp_enqueue_script('jquery');
        wp_enqueue_script( 'bundle', get_template_directory_uri() . '/assets/js/bundle.min.js', array('jquery'), VERSION, true );

    }
}

add_action( 'wp_enqueue_scripts', 'theme_script' );
