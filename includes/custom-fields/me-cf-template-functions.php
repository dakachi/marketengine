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
    if(isset($_REQUEST['view'])) {
        if($_REQUEST['view'] == 'add') {
            me_get_template('custom-fields/admin-custom-field-form');
        } elseif($_REQUEST['view'] == 'edit') {
            $field_obj = me_cf_get_field($_REQUEST['custom-field-id']);
            $field_obj['field_for_categories'] = me_cf_get_field_categories($_REQUEST['custom-field-id']);
            me_get_template('custom-fields/admin-custom-field-form', array('field_obj' => $field_obj));
        } elseif($_REQUEST['view'] == 'group-by-category') {
            me_get_template('custom-fields/admin-custom-field');
        }
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
            'title'  => __('Custom Fields', 'enginethemes'),
            'slug'   => 'custom-field',
            'type'   => 'section',
        );
        unset($sections['sample-data']);
        $sections['sample-data'] = $sample_data;
    }
    return $sections;
}

function marketengine_load_input_by_field_type($args) {
	$placeholder = isset($args['field_placeholder']) ? $args['field_placeholder'] : '';
    $attribute = me_field_attribute_array($args);
    $attribute = wp_parse_args($attribute, array('min'=>'','max'=>''));

	$option_values = isset($args['option_values']) ? $args['option_values'] : '';
	$option_none = isset($args['option_none']) ? $args['option_none'] : '';

    $options = '';

    switch($args['field_type']) {
        case 'text':
        case 'textarea':
            $options .= '<div class="me-group-field">';
            $options .= '<label class="me-title">'.__('Placeholder', 'enginethemes').' <small>'.__('(optional)', 'enginethemes').'</small></label>';
            $options .= '<span class="me-field-control">';
            $options .= '<input class="me-input-field" id="field_placeholder" type="text" name="field_placeholder" value="'.esc_attr($placeholder).'">';
            $options .= '</span>';
            $options .= '</div>';
            break;

        case 'number':
            $options .= '<div class="me-group-field">';
            $options .= '<label class="me-title">'.__('Placeholder', 'enginethemes').' <small>'.__('(optional)', 'enginethemes').'</small></label>';
            $options .= '<span class="me-field-control">';
            $options .= '<input class="me-input-field" id="field_placeholder" type="text" name="field_placeholder" value="'.esc_attr($placeholder).'">';
            $options .= '</span>';
            $options .= '</div>';
            $options .= '<div class="me-group-field">';
            $options .= '<label class="me-title">'.__('Minimum value', 'enginethemes').' <small>'.__('(optional)', 'enginethemes').'</small></label>';
            $options .= '<span class="me-field-control">';
            $options .= '<input class="me-input-field" id="field_minimum_value" type="number" name="field_minimum_value" value="'.$attribute['min'].'">';
            $options .= '</span>';
            $options .= '</div>';
            $options .= '<div class="me-group-field">';
            $options .= '<label class="me-title">'.__('Maximum value', 'enginethemes').' <small>'.__('(optional)','enginethemes').'</small></label>';
            $options .= '<span class="me-field-control">';
            $options .= '<input class="me-input-field" id="field_maximum_value" type="number" name="field_maximum_value" value="'.$attribute['max'].'">';
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
            $options .= '<input class="me-input-field" type="text" name="option_none" value="'.esc_attr($placeholder).'">';
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
        	$field_attribute = me_field_attribute_array($field);
            $field_attribute = wp_parse_args($field_attribute, array('min' => '', 'max' => ''));

	        echo "<p><span>".__('Placeholder:', 'enginethemes')."</span>".$field_placeholder."</p>";
	        echo "<p><span>".__('Minimum value:', 'enginethemes')."</span>".$field_attribute['min']."</p>";
	        echo "<p><span>".__('Maximum value:', 'enginethemes')."</span>".$field_attribute['max']."</p>";

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