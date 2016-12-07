<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Class ME Tab
 * 
 * Render admin option tabs
 *
 * @package Admin/Options
 * @category Class
 *
 * @version 1.0
 */
class ME_Tab extends ME_Container {
    /**
     * Contructor
     * @param array $args
     */
    public function __construct($args) {
        $args = wp_parse_args( $args, array('class' => '' ) );
        $this->_name     = $args['slug'];
        $this->_template = $args['template'];
        $this->_class    = $args['class'];
    }

    public function menus() {
        if (count($this->_template) == 1) {
            return;
        }

        echo '<ul class="me-nav me-section-nav '.$this->_class.'">';
        $class = 'class="active"';
        foreach ($this->_template as $key => $tab) {
            if ($tab['type'] == 'section') {
                echo '<li ' . $class . '><span>' . $tab['title'] . '</span></li>';
            }
            $class = '';
        }
        echo '</ul>';
    }

    public function start() {
        echo '<div class="me-tab" >';
    }

    public function end() {
        echo '</div>';
    }

    public function wrapper_start() {
        echo '<div class="me-section-container">';
    }

    public function wrapper_end() {
        echo '</div>';
    }
}