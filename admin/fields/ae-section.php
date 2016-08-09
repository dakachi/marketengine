<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}



class AE_Tab {
	protected $_controls;
    public function __construct() {

    }

    public function render() {
    	echo '<div class="me-tab">';
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
    public function __construct() {

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
    abstract public function render();
}

class AE_Textbox extends AE_Input {
    public function __construct() {

    }
    public function render() {
    ?>
    	<div class="me-group-field">
			<label class="me-title"><?php echo $this->_label; ?></label>
			<span class="me-subtitle"><?php echo $this->_description; ?></span>
			<input type="text" class="input-field" value="<?php echo $this->value; ?>" />
		</div>
    <?php
    }
}