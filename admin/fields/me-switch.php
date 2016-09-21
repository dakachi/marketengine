<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class ME_Switch extends ME_Input{
    function __construct( $args, $options ) {
        $args = wp_parse_args($args, array('name' => 'option_name', 'description' => '', 'label' => ''));

        $this->_type        = 'switch';
        $this->_name        = $args['name'];
        $this->_label       = $args['label'];
        $this->_description = $args['description'];
        $this->_slug        = $args['slug'];
        $this->_checked     = $args['checked'];
        $this->_container   = $options;

        $this->_options = $options;
    }

    function render() {
        $enable_text = __("Enable", 'enginethemes');
        $disable_text = __("Disable", 'enginethemes');
        $id = $this->_slug ? 'id="'. $this->_slug . '"' : '';
        $value = $this->get_value();

        $this->open_form();
        echo '<div class="me-group-field" '.$id.'>';
        $this->label();
        $this->description();
        echo '<label class="me-switch">
                <input type="checkbox" name="'.$this->_name.'" ' . $value . '>
                <div class="me-switch-slider">
                    <span class="me-enable">'. $enable_text .'</span>
                    <span class="me-disable">'. $disable_text .'</span>
                </div>
            </label>';
        echo '</div>';
        $this->close_form();
    }
}
