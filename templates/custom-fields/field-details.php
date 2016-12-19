<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

?>
<div class="me-custom-field">
<?php
foreach ($fields as $field):
    switch ($field['field_type']) {
        case 'text':
        case 'textarea':
        case 'number':

            $value = me_field($field['field_name']);
            if (!$value) {
                break;
            }

            me_get_template('custom-fields/listing-details/text', array('field' => $field, 'value' => $value));

            break;
        case 'date':
            $value = me_field($field['field_name']);
            if (!$value) {
                break;
            }

            $date = date_i18n(get_option('date_format'), strtotime($value));
            me_get_template('custom-fields/listing-details/text', array('field' => $field, 'value' => $date));

            break;

        case 'single-select':
            $value = me_field($field['field_name'], null, array('fields' => 'names'));
            if (empty($value)) {
                break;
            }

            $value = $value[0];
            me_get_template('custom-fields/listing-details/text', array('field' => $field, 'value' => $value));

            break;

        case 'checkbox':
        case 'multi-select':
            $value = me_field($field['field_name'], null, array('fields' => 'names'));
            if (empty($value)) {
                break;
            }

            me_get_template('custom-fields/listing-details/list', array('field' => $field, 'value' => $value));

            break;

        default:
            break;
    }
endforeach;
?>
</div>