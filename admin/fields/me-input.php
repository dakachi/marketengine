<?php
abstract class ME_Input
{
    /**
     * Input Field Name
     *
     * @var string
     */
    protected $_name;
    /**
     * Input Field Name
     *
     * @var string
     */
    protected $_type;
    /**
     * Input Field Type
     *
     * @var string
     */
    protected $_label;
    /**
     * Input Feild Description
     *
     * @var string
     */
    protected $_description;

    /**
     * Input Container
     *
     * @var string
     */
    protected $_container;

    /**
     * Input Value
     *
     * @var void
     */
    protected $_value;

    /**
     * Input Default Value
     *
     * @var void
     */
    protected $_default_value;
    /**
     * Input Options
     * 
     * @var void
     */
    protected $_options;
    abstract public function render();

    protected function label()
    {
        if (!empty($this->_label)) {
            echo '<label class="me-title">' . $this->_label . '</label>';
        }
    }

    protected function description()
    {
        if (!empty($this->_description)) {
            echo '<span class="me-subtitle">' . $this->_description . '</span>';
        }
    }

    protected function get_id()
    {
        return $this->_slug ? 'id="' . $this->_slug . '"' : '';
    }

    protected function get_value()
    {
        if (!$this->_container || !$this->_options) {
            return '';
        }
        $parent      = $this->_options;
        $options     = $this->_options;
        $option_name = $this->_name;

        $option_value = me_option($option_name);

        return !empty($option_value) ? $option_value : $this->_default_value;
    }
}
