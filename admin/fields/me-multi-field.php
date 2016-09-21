<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class ME_Multi_Field extends ME_Input{
    function __construct( $args, $options ) {
        $args = wp_parse_args($args, array('name' => 'option_name', 'description' => '', 'label' => ''));

        $this->_type        = 'multi-field';
        $this->_id          = $args['id'];
        $this->_name        = $args['name'];
        $this->_label       = $args['label'];
        $this->_description = $args['description'];
        $this->_template 	= $args['template'];
        $this->_container   = $options;

        $this->_options = $options;
    }

    function render() {
        echo '<div class="me-group-field">';
        $this->label();
        $this->description();
        foreach( $this->_template as $template ){
        	$class = 'ME_' . ucfirst($template['type']);
        	$textbox = new $class($template, $this->_options);
        	$textbox->render();
        }
        echo '</div>';
    }

}