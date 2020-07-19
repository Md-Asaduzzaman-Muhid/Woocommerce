<?php

/**
 * Registers a custom post type.
 */
function prefix_register_post_type()
{
	// register_post_type(
	// 	'portfolio',
	// 	array(
	// 		'labels'        => array(
	// 			'name'               => __('Portfolio', 'text_domain'),
	// 			'singular_name'      => __('Portfolio', 'text_domain'),
	// 			'menu_name'          => __('Portfolio', 'text_domain'),
	// 			'name_admin_bar'     => __('Portfolio Item', 'text_domain'),
	// 			'all_items'          => __('All Items', 'text_domain'),
	// 			'add_new'            => _x('Add New', 'portfolio', 'text_domain'),
	// 			'add_new_item'       => __('Add New Item', 'text_domain'),
	// 			'edit_item'          => __('Edit Item', 'text_domain'),
	// 			'new_item'           => __('New Item', 'text_domain'),
	// 			'view_item'          => __('View Item', 'text_domain'),
	// 			'search_items'       => __('Search Items', 'text_domain'),
	// 			'not_found'          => __('No items found.', 'text_domain'),
	// 			'not_found_in_trash' => __('No items found in Trash.', 'text_domain'),
	// 			'parent_item_colon'  => __('Parent Items:', 'text_domain'),
	// 		),
	// 		'public'        => true,
	// 		'menu_position' => 6,
	// 		'menu_icon'		=> 'dashicons-format-gallery',
	// 		'supports'      => array(
	// 			'title',
	// 			'editor',
	// 			'thumbnail',
	// 			'excerpt',
	// 			'custom-fields',
	// 			'author'
	// 		),
	// 		'taxonomies'    => array(
	// 			'portfolio_categories',
	// 		),
	// 		'has_archive'   => true,
	// 		'rewrite'       => array(
	// 			'slug' => 'portfolio',
	// 		),
	// 	)
	// );

    //     register_post_type(
	// 	'faq',
	// 	array(
	// 		'labels'        => array(
	// 			'name'               => __('Faq', 'text_domain'),
	// 			'singular_name'      => __('Faq', 'text_domain'),
	// 			'menu_name'          => __('Faq', 'text_domain'),
	// 			'name_admin_bar'     => __('Faq Item', 'text_domain'),
	// 			'all_items'          => __('All Items', 'text_domain'),
	// 			'add_new'            => _x('Add New', 'faq', 'text_domain'),
	// 			'add_new_item'       => __('Add New Item', 'text_domain'),
	// 			'edit_item'          => __('Edit Item', 'text_domain'),
	// 			'new_item'           => __('New Item', 'text_domain'),
	// 			'view_item'          => __('View Item', 'text_domain'),
	// 			'search_items'       => __('Search Items', 'text_domain'),
	// 			'not_found'          => __('No items found.', 'text_domain'),
	// 			'not_found_in_trash' => __('No items found in Trash.', 'text_domain'),
	// 			'parent_item_colon'  => __('Parent Items:', 'text_domain'),
	// 		),
	// 		'public'        => true,
	// 		'menu_position' => 7,
	// 		'menu_icon'		=> 'dashicons-editor-help',
	// 		'supports'      => array(
	// 			'title',
	// 			'editor',
	// 			'thumbnail',
	// 			'excerpt',
	// 			'custom-fields',
	// 			'author'
	// 		),
	// 		'taxonomies'    => array(
	// 			'faq_categories',
	// 		),
	// 		'has_archive'   => true,
	// 		'rewrite'       => array(
	// 			'slug' => 'faq',
	// 		),
	// 	)
	// );

}

add_action('init', 'prefix_register_post_type');



/**
 * Registers a custom taxonomy.
 */
function prefix_register_taxonomy()
{
	// register_taxonomy(
	// 	'portfolio_categories',
	// 	array(
	// 		'portfolio',
	// 	),
	// 	array(
	// 		'labels'            => array(
	// 			'name'              => _x('Categories', 'portfolio', 'text_domain'),
	// 			'singular_name'     => _x('Category', 'portfolio', 'text_domain'),
	// 			'menu_name'         => __('Categories', 'text_domain'),
	// 			'all_items'         => __('All Categories', 'text_domain'),
	// 			'edit_item'         => __('Edit Category', 'text_domain'),
	// 			'view_item'         => __('View Category', 'text_domain'),
	// 			'update_item'       => __('Update Category', 'text_domain'),
	// 			'add_new_item'      => __('Add New Category', 'text_domain'),
	// 			'new_item_name'     => __('New Category Name', 'text_domain'),
	// 			'parent_item'       => __('Parent Category', 'text_domain'),
	// 			'parent_item_colon' => __('Parent Category:', 'text_domain'),
	// 			'search_items'      => __('Search Categories', 'text_domain'),
	// 		),
	// 		'show_admin_column' => true,
	// 		'hierarchical'      => true,
    //                     'show_ui' => true,
    //                     'show_admin_column' => true,
    //                     'query_var' => true,
	// 		'rewrite'           => array(
	// 			'slug' => 'portfolio/category',
	// 		),
	// 	)
	// );

    //     register_taxonomy(
	// 	'faq_categories',
	// 	array(
	// 		'faq',
	// 	),
	// 	array(
	// 		'labels'            => array(
	// 			'name'              => _x('Categories', 'faq', 'text_domain'),
	// 			'singular_name'     => _x('Category', 'faq', 'text_domain'),
	// 			'menu_name'         => __('Categories', 'text_domain'),
	// 			'all_items'         => __('All Categories', 'text_domain'),
	// 			'edit_item'         => __('Edit Category', 'text_domain'),
	// 			'view_item'         => __('View Category', 'text_domain'),
	// 			'update_item'       => __('Update Category', 'text_domain'),
	// 			'add_new_item'      => __('Add New Category', 'text_domain'),
	// 			'new_item_name'     => __('New Category Name', 'text_domain'),
	// 			'parent_item'       => __('Parent Category', 'text_domain'),
	// 			'parent_item_colon' => __('Parent Category:', 'text_domain'),
	// 			'search_items'      => __('Search Categories', 'text_domain'),
	// 		),
	// 		'show_admin_column' => true,
	// 		'hierarchical'      => true,
    //                     'show_ui' => true,
    //                     'show_admin_column' => true,
    //                     'query_var' => true,
	// 		'rewrite'           => array(
	// 			'slug' => 'faq/category',
	// 		),
	// 	)
	// );

}

add_action('init', 'prefix_register_taxonomy', 0);


add_action( 'init', 'create_posttype' );
function create_posttype() {

//   register_post_type( 'testimonial',
//     array(
//       'labels' => array(
//         'name' => __( 'Testimonials' ),
//         'singular_name' => __( 'Testimonial' ),
//       ),
// //      'taxonomies' => array('category'),
//       'public' => true,
// 	  'menu_icon'	=> 'dashicons-testimonial',
//       'has_archive' => true,
//       'rewrite' => array('slug' => 'testimonials'),
//       'supports' => array( 'title' ,'editor', 'author')
//     )
//   );

  register_post_type( 'general',
    array(
      'labels' => array(
        'name' => __( 'General Posts' ),
        'singular_name' => __( 'General' ),
      ),
//      'taxonomies' => array('category'),
      'public' => true,
	  'menu_icon'	=> 'dashicons-format-aside',
      'has_archive' => false,
      'rewrite' => array('slug' => 'generals'),
      'supports' => array( 'title' ,'editor', 'author')
    )
  );

//   register_post_type( 'videos',
//     array(
//       'labels' => array(
//         'name' => __( 'Videos' ),
//         'singular_name' => __( 'Video' ),
//       ),
// //      'taxonomies' => array('category'),
//       'public' => true,
// 	  'menu_icon'	=> 'dashicons-format-video',
//       'has_archive' => false,
//       'rewrite' => array('slug' => 'videos'),
//       'supports' => array( 'title' , 'author')
//     )
//   );

  register_post_type( 'job',
    array(
      'labels' => array(
        'name' => __( 'Jobs' ),
        'singular_name' => __( 'Job' ),
      ),
//      'taxonomies' => array('category'),
      'public' => true,
	  'menu_icon'	=> 'dashicons-id-alt',
      'has_archive' => false,
      'rewrite' => array('slug' => 'jobs'),
      'supports' => array( 'title' ,'editor', 'author')
    )
  );
}
