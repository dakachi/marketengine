<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class ME_Radio
 * 
 * ME Html radio input tag
 *
 * @since 1.0
 * @package Admin/Options
 * @category Class
 *
 * @version 1.0
 */
class ME_Radio extends ME_Input {
    public function __construct($args, $options) {
        $args = wp_parse_args($args, array('name' => 'option_name', 'description' => '', 'label' => ''));

        $this->_type        = 'radio';
        $this->_name        = $args['name'];
        $this->_label       = $args['label'];
        $this->_description = $args['description'];
        $this->_slug        = $args['slug'];
        $this->_data        = isset($args['data']) ? $args['data'] : array();
        $this->_container   = $options;

        $this->_options = $options;
    }

    public function render() {
        $id = $this->_slug ? 'id="'.$this->_slug.'"' : '';
        echo '<div class="me-group-field" '.$id.'>';
        $this->label();
        $this->description();
        $checked_rad = $this->get_value();
        foreach($this->_data as $key => $value){
            $checked = $checked_rad == $value ? 'checked' : '';
            echo '<input type="radio" class="me-radio-field" name="'.$this->_name.'" value="' . $value . '" '.$checked.' />' . $value;
        }
        echo '</div>';
    }
}

