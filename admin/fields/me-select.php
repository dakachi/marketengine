<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class ME_Select extends ME_Input{
    function __construct( $args, $options ) {
        $args = wp_parse_args($args, array('name' => 'option_name', 'description' => '', 'label' => ''));

        $this->_type        = 'select';
        $this->_name        = $args['name'];
        $this->_label       = $args['label'];
        $this->_description = $args['description'];
        $this->_slug        = $args['slug'];
        $this->_data        = isset($args['data']) ? $args['data'] : array();
        $this->_container   = $options;

        $this->_options = $options;
    }

    function render() {
        $id = $this->_slug ? 'id="'. $this->_slug . '"' : '';
        $option_value = $this->get_value();
        $selected = '';

        echo '<div class="me-group-field" '.$id.'>';
        $this->label();
        $this->description();
        echo '<select class="select-field" name="'. $this->_name .'">';
        echo '<option value="">Select a page...</option>';
        foreach ($this->_data as $key => $value) {
            if($option_value == $key) $selected = 'selected';
            echo '<option '.$selected.' value="'. $key .'">' . $value . '</option>';
            $selected = '';
        }
        echo '</select>';
        echo '</div>';
    }

}