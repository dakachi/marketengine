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

function marketengine_load_input_by_field_type($args) {
	$placeholder = isset($args['field_placeholder']) ? $args['field_placeholder'] : '';
	$field_minimum_value = isset($args['field_minimum_value']) ? $args['field_minimum_value'] : '';
	$field_maximum_value = isset($args['field_maximum_value']) ? $args['field_maximum_value'] : '';
	$option_values = isset($args['option_values']) ? $args['option_values'] : '';
	$option_none = isset($args['option_none']) ? $args['option_none'] : '';

    $options = '';

    switch($args['field_type']) {
        case 'text':
        case 'textarea':
            $options .= '<div class="me-group-field">';
            $options .= '<label class="me-title">'.__('Placeholder', 'enginethemes').' <small>'.__('(optional)', 'enginethemes').'</small></label>';
            $options .= '<span class="me-field-control">';
            $options .= '<input class="me-input-field" type="text" name="field_placeholder" value="'.$placeholder.'">';
            $options .= '</span>';
            $options .= '</div>';
            break;

        case 'number':
            $options .= '<div class="me-group-field">';
            $options .= '<label class="me-title">'.__('Placeholder', 'enginethemes').' <small>'.__('(optional)', 'enginethemes').'</small></label>';
            $options .= '<span class="me-field-control">';
            $options .= '<input class="me-input-field" type="text" name="field_placeholder" value="'.$placeholder.'">';
            $options .= '</span>';
            $options .= '</div>';
            $options .= '<div class="me-group-field">';
            $options .= '<label class="me-title">'.__('Minimum value', 'enginethemes').' <small>'.__('(optional)', 'enginethemes').'</small></label>';
            $options .= '<span class="me-field-control">';
            $options .= '<input class="me-input-field" type="number" name="field_minimum_value" value="'.$field_minimum_value.'">';
            $options .= '</span>';
            $options .= '</div>';
            $options .= '<div class="me-group-field">';
            $options .= '<label class="me-title">'.__('Maximum value', 'enginethemes').' <small>'.__('(optional)','enginethemes').'</small></label>';
            $options .= '<span class="me-field-control">';
            $options .= '<input class="me-input-field" type="number" name="field_maximum_value" value="'.$field_maximum_value.'">';
            $options .= '</span>';
            $options .= '</div>';
            break;
        case 'date':
            break;

        case 'checkbox':
        case 'radio':
            $options .= '<div class="me-group-field">';
            $options .= '<label class="me-title">'.__('Option','enginethemes').'</label>';
            $options .= '<span class="me-field-control">';
            $options .= '<textarea class="me-textarea-field" name="option_values" placeholder="'.__('Enter each option on a new line', 'enginethemes').'">'.$option_values.'</textarea>';
            $options .= '</span>';
            $options .= '</div>';
            break;

        case 'single-select':
        case 'multi-select':
            $options .= '<div class="me-group-field">';
            $options .= '<label class="me-title">'.__('Option none', 'enginethemes').'</label>';
            $options .= '<span class="me-field-control">';
            $options .= '<input class="me-input-field" type="text" name="option_none" value="'.$option_none.'">';
            $options .= '</span>';
            $options .= '</div>';
            $options .= '<div class="me-group-field">';
            $options .= '<label class="me-title">'.__('Option','enginethemes').'</label>';
            $options .= '<span class="me-field-control">';
            $options .= '<textarea class="me-textarea-field" name="option_values" placeholder="'.__('Enter each option on a new line', 'enginethemes').'">'.$option_values.'</textarea>';
            $options .= '</span>';
            $options .= '</div>';
            break;

        default:
            break;
    }
    return $options;
}

function marketengine_load_inputs_for_view( $field ) {
	extract($field);
    switch($field_type) {
        case 'text':
        case 'textarea':
    		echo "<p><span>".__('Placeholder:', 'enginethemes')."</span>".$field_placeholder."</p>";

            break;

        case 'number':
        	$field_placeholder = isset($field_placeholder) ? $field_placeholder : 'N/A';
        	/*$field_minimum_value = isset($field->field_minimum_value) ? $field->field_minimum_value : 'N/A';
        	$field_maximum_value = isset($field->field_maximum_value) ? $field->field_maximum_value : 'N/A';*/

	        echo "<p><span>".__('Placeholder:', 'enginethemes')."</span>".$field_placeholder."</p>";
	        echo "<p><span>".__('Minimum value:', 'enginethemes')."</span></p>";
	        echo "<p><span>".__('Maximum value:', 'enginethemes')."</span></p>";

            break;

        case 'date':
            break;

        case 'checkbox':
        case 'radio':
            break;

        case 'single-select':
        case 'multi-select':
            break;

        default:
            break;
    }
}
add_action('me_load_inputs_for_view', 'marketengine_load_inputs_for_view');

function marketengine_cf_pagination($args) {
    $big = 999999999;
    $current_page = empty($_REQUEST['paged']) ? 1 : $_REQUEST['paged'];
    echo paginate_links( array(
        'base' => add_query_arg( 'paged', '%#%' ),
        'format' => '',
        'current' => max( 1, $current_page ),
        'total' => $args['max_numb_pages']
    ) );
}