<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class ME_Translate extends ME_Input{
    function __construct( $args, $options ) {
        $args = wp_parse_args($args, array('name' => 'option_name', 'description' => '', 'label' => ''));

        $this->_type        = 'translate';
        $this->_id          = $args['id'] ? $args['id'] : '';
        $this->_name        = $args['name'];
        $this->_label       = $args['label'];
        $this->_description = $args['description'];
        $this->_slug        = $args['slug'];
        $this->_opts        = $args['options'];
        $this->_template 	= $args['template'];
        $this->_container   = $options;

        $this->_options = $options;
    }

    function render() {
        $id = $this->_slug ? 'id="'. $this->_slug . '"' : '';

        $this->open_form();
        echo '<div class="me-group-field" '.$id.'>';
        $this->label();
        $this->description();
        $this->render_select();
        //$this->render_language_box( $key, $value );
        echo '</div>';
        $this->close_form();
    }

    function render_select() {
        echo '<select class="select-field" name="'. $this->_name .'">';
        foreach ($this->_opts as $key => $value) {
            $selected = $key == $this->get_value() ? 'selected' : '';
            echo '<option '.$this->get_value().' '.$selected.' value="'. $key .'">' . $value . '</option>';
        }
        echo '</select>';
    }

    function render_language_box( $key, $value ) {
        echo '<div class="me-scroll-language" id="'.$key.'">';
        echo '<div class="me-group-field">';
        foreach( $value['translate'] as $default => $new ){
            echo '<label class="me-title">'.$default.'</label>';
            echo '<input type="text" name="'.$default.'" class="me-input-field" value="' . $new . '" />';
        }
        echo '</div>';
        echo '</div>';
    }

    function get_current_language() {
        // TODO: get current language to render
    }

}