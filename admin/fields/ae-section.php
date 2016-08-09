<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class AE_Tab {
    protected $_controls;
    public function __construct($args) {
    	$this->_name = $args['slug'];
    	$this->_controls = array();
    }

    public function render() {
    	//if(!$this->_controls) return;
        echo '<div class="me-tab">';
        echo $this->_name;
        foreach ($this->_controls as $key => $control) {
            $control->render();
        }
        echo '</div>';
    }
}

class AE_Section {
    protected $_controls;
    public function __construct() {

    }

    public function render() {
        echo '<div class="me-section">';
        if(!$this->_controls) return;
        foreach ($this->_controls as $key => $control) {
            $control->render();
        }
        echo '</div>';
    }
}

class AE_Group {
    protected $_title;
    protected $_description;
    protected $_fields;
    /**
     *
     */
    public function __construct($args, $option) {

    }

    public function render() {
        echo '<div class="me-group-field">';
        foreach ($this->_fields as $key => $field) {
            $field->render();
        }
        echo '</div>';
    }
}

abstract class AE_Input {
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
        $parent = $this->_container;
        $options = $this->_options;
        $option_name = $this->_name;

        return $options->$parent->$option_name;
    }
}

class AE_Textbox extends AE_Input {
    public function __construct($args, $options, $parent) {
        $args = wp_parse_args($args, array('name' => 'option_name', 'description' => '', 'label' => ''));

        $this->_type        = 'textbox';
        $this->_name        = $args['name'];
        $this->_label       = $args['label'];
        $this->_description = $args['description'];
        $this->_container   = $parent;

        $this->_options = $options;
    }

    public function render() {
        $this->label();
        $this->description();
        echo '<input type="text" class="input-field" value="' . $this->get_value() . '" />';

    }
}