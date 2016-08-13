<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

abstract class ME_Container {
    protected $_controls;
    protected $_template;
    abstract public function start();
    abstract public function end();

    public function menus() {

    }

    public function render() {
        $this->start();

        $template = $this->_template;
        if (is_string($template) && is_file($template)) {
            include $template;
        } else {
            $this->menus();
            $this->wrapper_start();

            foreach ($template as $key => $control) {
                $class   = 'ME_' . ucfirst($control['type']);
                $control = new $class($control, $this);
                $control->render();
            }

            $this->wrapper_end();
        }

        $this->end();
    }

    public function wrapper_start() {}

    public function wrapper_end() {}
}

class ME_Tab extends ME_Container {
    protected $_controls;
    public function __construct($args) {
        $this->_name     = $args['slug'];
        $this->_template = $args['template'];
    }

    public function menus() {
        echo '<ul class="me-nav me-section-nav">';
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
        echo '<div class="me-tab">';
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

class ME_Group extends ME_Container {
    protected $_title;
    protected $_description;
    protected $_fields;
    /**
     *
     */
    public function __construct($args, $option) {
        $this->_name     = $args['slug'];
        $this->_controls = array();
    }

    public function start() {
        echo '<div class="me-group-field">';
    }

    public function end() {
        echo '</div>';
    }
}

abstract class ME_Input {
    protected $_name;
    protected $_type;
    protected $_label;
    protected $_description;
    protected $_container;
    protected $_value;

    protected $_options;
    abstract public function render();

    protected function label() {
        if (!empty($this->_label)) {
            echo '<label class="me-title">' . $this->_label . '</label>';
        }
    }

    protected function description() {
        if (!empty($this->_description)) {
            echo '<span class="me-subtitle">' . $this->_description . '</span>';
        }
    }

    protected function get_value() {
        if (!$this->_container || !$this->_options) {
            return '';
        }
        $parent      = $this->_options;
        $options     = $this->_options;
        $option_name = $this->_name;

        //return $options->$parent->$option_name;
    }
}

class ME_Textbox extends ME_Input {
    public function __construct($args, $options) {
        $args = wp_parse_args($args, array('name' => 'option_name', 'description' => '', 'label' => ''));

        $this->_type        = 'textbox';
        $this->_name        = $args['name'];
        $this->_label       = $args['label'];
        $this->_description = $args['description'];
        $this->_container   = $options;

        $this->_options = $options;
    }

    public function render() {
    	echo '<div class="me-group-field">';
        $this->label();
        $this->description();
        echo '<input type="text" class="me-input-field" value="' . $this->get_value() . '" />';
        echo '</div>';
    }
}