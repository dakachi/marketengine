<div class="marketengine-custom-field">
<?php
if (!empty($_POST['parent_cat'])):
    $fields = me_cf_get_fields($_POST['parent_cat']);
    if (!empty($fields)) {
        foreach ($fields as $field):
            $field_name = $field['field_name'];
            $value      = !empty($_POST[$field_name]) ? $_POST[$field_name] : '';
            me_get_template('custom-fields/field-' . $field['field_type'], array('field' => $field, 'value' => $value));
        endforeach;
    }
endif;
?>
</div>