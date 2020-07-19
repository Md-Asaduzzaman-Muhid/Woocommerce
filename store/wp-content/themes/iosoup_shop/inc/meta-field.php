<?php 

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_5abcadae90a72',
	'title' => 'Inner Banner',
	'fields' => array (
		array (
			'key' => 'field_5abcadb7cd220',
			'label' => 'Inner Banner',
			'name' => 'inner_banner',
			'type' => 'image',
			'value' => NULL,
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'medium',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
		),
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'page',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'side',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));


//Page Icon
acf_add_local_field_group(array(
	'key' => 'group_5b7139de87851',
	'title' => 'Page Icon',
	'fields' => array(
		array(
			'key' => 'field_5b7139e781eb6',
			'label' => '',
			'name' => 'page_icon',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'page',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'side',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));



//Job Post Info
acf_add_local_field_group(array (
	'key' => 'group_5a9fc87fc2d3f',
	'title' => 'Job Information',
	'fields' => array (
		array (
			'key' => 'field_5a9fc88c3aaca',
			'label' => 'Deadline',
			'name' => 'deadline',
			'type' => 'date_picker',
			'value' => NULL,
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'F j, Y',
			'return_format' => 'F j, Y',
			'first_day' => 1,
		),
		array (
			'key' => 'field_5a9fc8b73aacb',
			'label' => 'No. of Vacancies',
			'name' => 'no_of_vacancies',
			'type' => 'text',
			'value' => NULL,
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'job',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;
