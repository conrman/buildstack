<?php 
/* * *
 *  Page Custom Fields
 */
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_page-custom-fields',
		'title' => 'Page Custom Fields',
		'fields' => array (
			array (
				'key' => 'field_54cabb0caf9a4',
				'label' => 'Slider',
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_54cabb58af9a5',
				'label' => 'Use Slider?',
				'name' => 'use_slider',
				'type' => 'true_false',
				'instructions' => 'Check the box to use a Slider on this page',
				'message' => '',
				'default_value' => 0,
			),
			array (
				'key' => 'field_54cabfecaf9ac',
				'label' => 'Use Captions?',
				'name' => 'use_captions',
				'type' => 'true_false',
				'instructions' => 'Would you like to add text captions on the Slider? If this box is checked, the Slider will use the Image\'s Title & Caption fields to populate text for each Slide.',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_54cabb58af9a5',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
				'default_value' => 0,
			),
			array (
				'key' => 'field_54cabb97af9a6',
				'label' => 'Slider Images',
				'name' => 'slider_images',
				'type' => 'gallery',
				'instructions' => 'Add images to the Slider',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_54cabb58af9a5',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_54cabbb3af9a7',
				'label' => 'Jumbotron',
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_54cabc3caf9a9',
				'label' => 'Use Jumbotron?',
				'name' => 'use_jumbotron',
				'type' => 'true_false',
				'instructions' => 'Check the box to use a Jumbotron on this page',
				'message' => '',
				'default_value' => 0,
			),
			array (
				'key' => 'field_54cabc79af9aa',
				'label' => 'Add background Image?',
				'name' => 'use_bg_image',
				'type' => 'true_false',
				'instructions' => 'Would you like to add a background image?',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_54cabc3caf9a9',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
				'default_value' => 0,
			),
			array (
				'key' => 'field_54cabbd7af9a8',
				'label' => 'Jumbotron Text',
				'name' => 'jumbotron_text',
				'type' => 'wysiwyg',
				'instructions' => 'Enter text to appear in the Jumbotron on this page',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_54cabc3caf9a9',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '<h2>Jumbotron Title</h2>
	<p>Jumbotron Text</p>',
				'toolbar' => 'full',
				'media_upload' => 'yes',
			),
			array (
				'key' => 'field_54cabcb4af9ab',
				'label' => 'Jumbotron Image',
				'name' => 'jumbotron_image',
				'type' => 'image',
				'instructions' => 'Add image to show as a background on the Jumbotron',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_54cabc79af9aa',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
				0 => 'permalink',
				1 => 'custom_fields',
				2 => 'discussion',
				3 => 'comments',
				4 => 'author',
				5 => 'format',
				6 => 'categories',
				7 => 'tags',
				8 => 'send-trackbacks',
			),
		),
		'menu_order' => 0,
	));
}
 ?>