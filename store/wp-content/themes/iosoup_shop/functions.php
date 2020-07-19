<?php

/*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
     add_theme_support( 'title-tag' );
     
/*
* Switch default core markup for search form, comment form, and comments
* to output valid HTML5.
*/
    add_theme_support( 'html5', array(
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );

/*
* Enable support for Post Formats.
*
* See: https://codex.wordpress.org/Post_Formats
*/
    add_theme_support( 'post-formats', array(
        'aside',
        'image',
        'video',
        'quote',
        'link',
        'gallery',
        'audio',
    ) );

    add_theme_support( 'post-thumbnails' );


   // This theme uses wp_nav_menu() in two locations.
    register_nav_menus( array(
        'top-menu'    => __( 'Top Menu', '' ),
        'footer-menu' => __( 'Footer Menu', '' ),
    ));


//set active class on menu  links
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);

function special_nav_class ($classes, $item) {
    if (in_array('current-menu-item', $classes) ){
        $classes[] = 'active';
    }
    return $classes;
};

function add_link_atts($atts) {
    $atts['class'] = "nav-link";
    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'add_link_atts');


//print r function
function pr($data){
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

// Add RSS links to <head> section
//automatic_feed_links();
// Clean up the <head>
function removeHeadLinks() {
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
}
add_action('init', 'removeHeadLinks');
remove_action('wp_head', 'wp_generator');

/* Add the logo code here */

function custom_login_logo() {
    echo '<style type="text/css">
    h1 a {
        background-image: url('. get_template_directory_uri() .'/assets/img/logo.png) !important;
        background-position: center center !important;
        background-size: contain !important;
        margin: 0 15px 25px !important;
        width: auto !important;
    }

    #login{
        background:#fff;
    }
    body{
        background:#e3e3e3;
    }
    </style>';
}

add_action('login_head', 'custom_login_logo');

add_action('admin_head', 'thum_column_style');

function thum_column_style() {
  echo '<style>
    .column-featured_thumb {
        width: 80px;
    }
    .column-featured_thumb img {
        max-width: 60px;
        height: auto;
    } 
  </style>';
}


function loginpage_custom_link() {
    return site_url();
}

add_filter('login_headerurl','loginpage_custom_link');

function change_title_on_logo() {
    return get_bloginfo( 'name' );
}

add_filter('login_headertitle', 'change_title_on_logo');

/* end logo code */

/**
 * breadcrumbs.php* 
 */
require get_template_directory() . '/inc/breadcrumbs.php';
/**
 * bootstrap-wp-navwalker.php * 
 */
 //require get_template_directory() . '/inc/bs4navwalker.php';

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */

 require get_template_directory() . '/inc/widgets.php';
 
 /**
  * Enqueue scripts and styles.
  */
 require get_template_directory() . '/inc/enqueue.php';
 

//Custom Post Type
require get_template_directory() . '/inc/custom-post-types.php';


//Meta Fields
require get_template_directory() . '/inc/meta-field.php';


/**
 * Load Jetpack compatibility file.
 */
 require get_template_directory() . '/inc/jetpack.php';


/**
 * Load Editor functions.
 */
require get_template_directory() . '/inc/editor.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/pagination.php';
 
/**
 * Load functions to secure your WP install.
 */
require get_template_directory() . '/inc/security.php';


//jpeg_quality
add_filter( 'jpeg_quality', 'insta_jpeg_quality' );
function insta_jpeg_quality() {
   return 100;
}

//title trim
function insta_title_trim($title, $character){
    $postfix = '';
    if( strlen($title) > $character) {
        $postfix = '...';
    }
    return substr($title,0,$character) . $postfix;
}

//excerpt
function insta_excerpt($limit = 80) {
    $excerpt = get_the_content();
    $excerpt = preg_replace(" ([.*?])",'',$excerpt);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $limit);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = trim(preg_replace( '/s+/', ' ', $excerpt));
    $excerpt = $excerpt.'...';
    return '<p>'.$excerpt.'</p>';    
}

function custom_insta_excerpt($limit = 80, $cont) {
    $excerpt = $cont;
    $excerpt = preg_replace(" ([.*?])",'',$excerpt);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $limit);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = trim(preg_replace( '/s+/', ' ', $excerpt));
    $excerpt = $excerpt.'...';
    return '<p>'.$excerpt.'</p>';    
}


// function insta_excerpt($limit = 20) {
//     $excerpt = explode(' ', get_the_excerpt(), $limit);
//     if (count($excerpt) >= $limit) {
//       array_pop($excerpt);
//       $excerpt = implode(" ",$excerpt).'...';
//     } else {
//       $excerpt = implode(" ",$excerpt);
//     }    
//     $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
//     return '<p>'.$excerpt.'</p>';
// }


/*
 * return array of post by post type catId
 * @param: postType  (required)
 * @param catId (required)
 */

function getPostByCatId($postType,$catId,$current_post_id,$orderBy="post_date",$AD="DESC"){
    global $wpdb;
    $catPost = $wpdb->get_results("SELECT ".$wpdb->prefix."posts.* FROM ".$wpdb->prefix."posts
        INNER JOIN ".$wpdb->prefix."term_relationships
        ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."term_relationships.object_id)
        WHERE ".$wpdb->prefix."posts.ID != '".$current_post_id."' AND ( ".$wpdb->prefix."term_relationships.term_taxonomy_id IN (".$catId.") )
        AND ".$wpdb->prefix."posts.post_type IN ('".$postType."')
        AND ((".$wpdb->prefix."posts.post_status = 'publish'))
        GROUP BY ".$wpdb->prefix."posts.ID ORDER BY ".$wpdb->prefix."posts.$orderBy $AD ", ARRAY_A  );

    return $catPost;

}


// add featured thumbnail to admin post & custom post columns
add_filter('manage_posts_columns', 'posts_columns', 5);
add_action('manage_posts_custom_column', 'posts_custom_columns', 5, 2);

function posts_columns($defaults){
    $defaults['featured_thumb'] = __('Thum');
    return $defaults;
}

function posts_custom_columns($column_name, $id){ 
    if($column_name === 'featured_thumb'){
        echo '<a href="' . get_edit_post_link() . '">';
        echo the_post_thumbnail( 'thumbnail' );
        echo '</a>';
    } 
}

// add featured thumbnail to admin page columns
add_filter( 'manage_pages_columns', 'custom_pages_columns' );
add_action( 'manage_pages_custom_column', 'posts_custom_columns', 10, 2 );

function custom_pages_columns( $columns ) {
    $columns['featured_thumb'] = __('Thum');
    return $columns;
}

// Disable Gutenberg
add_filter('use_block_editor_for_post', '__return_false');

?>
