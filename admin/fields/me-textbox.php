<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class ME_Textbox extends ME_Input {
    public function __construct($args, $options) {
        $args = wp_parse_args($args, array('name' => 'option_name', 'description' => '', 'label' => ''));

        $this->_type        = 'textbox';
        $this->_name        = $args['name'];
        $this->_label       = $args['label'];
        $this->_description = $args['description'];
        $this->_slug        = $args['slug'];
        $this->_container   = $options;

        $this->_options = $options;
    }

    public function render() {
        $id = $this->_slug ? 'id="'.$this->_slug.'"' : '';
        $this->open_form();
        echo '<div class="me-group-field" '.$id.'>';
        $this->label();
        $this->description();
        echo '<input type="text" name="'.$this->_name.'" class="me-input-field" value="' . $this->get_value() . '" />';
        echo '</div>';
        $this->close_form();
    }
}

