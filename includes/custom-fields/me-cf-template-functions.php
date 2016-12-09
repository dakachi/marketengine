<?php
/**
 * List custom field type
 *
 * @since 	1.0.1
 */
function me_list_custom_field_type() {
	$field_types = array(
		array(
			'label'		=> __("Basic", "enginethemes"),
			'options'	=> array(
				'text'		=> 'Text',
				'textarea'	=> 'Textarea',
				'number'	=> 'Number',
				'date'		=> 'Date',
			),
		),
		array(
			'label'		=> __("Choose", "enginethemes"),
			'options'	=> array(
				'checkbox'				 => 'Checkbox',
				'radio'					 => 'Radio',
				'single-select' => 'Dropdown Single Select',
				'multi-select'	 => 'Dropdown Multi Select',
			),
		),
	);

	$field_types = apply_filters('filter_custom_field', $field_types);

	return $field_types;
}

/**
 * Loads custom field templates
 *
 * @since 	1.0.1
 * @version 1.0.0
 */
function marketengine_custom_field_template() {
    if(isset($_REQUEST['view']) && $_REQUEST['view'] == 'add') {
        me_get_template('custom-fields/admin-custom-field-form');
    } else {
        me_get_template('custom-fields/admin-custom-field');
    }
}

/**
 * Prepares content of custom field section
 *
 * @since 	1.0.1
 * @version 1.0.0
 */
function marketengine_add_actions() {
    if( is_admin() && isset($_REQUEST['section']) && $_REQUEST['section'] == 'custom-field') {
        add_action( 'wp_print_scripts', 'marketengine_dequeue_script', 100 );
        add_action('get_custom_field_template', 'marketengine_custom_field_template');
    }
}

/**
 * Removes ajax handle of option
 *
 * @since 	1.0.1
 * @version 1.0.0
 */
function marketengine_dequeue_script() {
   wp_dequeue_script( 'option-view' );
}


function marketengine_add_custom_field_section( $sections ) {
    if(!isset($_REQUEST['tab']) || $_REQUEST['tab'] == 'marketplace-settings') {
        $sample_data = $sections['sample-data'];
        $sections['custom-field'] = array(
            'title'  => __('Custom Field', 'enginethemes'),
            'slug'   => 'custom-field',
            'type'   => 'section',
        );
        unset($sections['sample-data']);
        $sections['sample-data'] = $sample_data;
    }
    return $sections;
}
add_action('marketengine_section', 'marketengine_add_custom_field_section');