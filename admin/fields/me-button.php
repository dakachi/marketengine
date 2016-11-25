<?php
/**
 * Class ME Button
 */
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Class ME Button option
 * Render button in admin options
 * 
 * @category Class
 * @package Admin/Options
 * @version 1.0
 */
class ME_Button extends ME_Input{
    /**
     * Contruct the field attribute
     * @param $args The field args
     * @param $options The field option value
     */
    function __construct( $args, $options ) {
        $args = wp_parse_args($args, array('name' => 'option_name', 'description' => '', 'label' => ''));

        $this->_type        = 'button';
        $this->_name        = $args['name'];
        $this->_label       = $args['label'];
        $this->_slug        = $args['slug'];
        $this->_container   = $options;

        $this->_options = $options;
    }
    /**
     * Render button html
     */
    function render() {
        echo '<input id="'.$this->_slug.'" type="submit" name="'.$this->_name.'" value="'.$this->_label.'"/>';
    }
}
