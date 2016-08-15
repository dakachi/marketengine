<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}


class ME_Section extends ME_Container {
    protected $_controls;
    public function __construct($args, $option) {
        $this->_name     = $args['slug'];
        $this->_template = $args['template'];
    }

    public function start() {
        echo '<div class="me-section-content">';
    }

    public function end() {
        echo '</div>';
    }
}