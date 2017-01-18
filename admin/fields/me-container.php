<?php 
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

            $first = true;
            foreach ($template as $key => $control) {
                $class   = 'ME_' . ucfirst($control['type']);
                $control['first'] = $first;
                $control = new $class($control, $this);
                $control->render();
                $first = false;
            }

            $this->wrapper_end();
        }

        $this->end();
    }

    public function wrapper_start() {}

    public function wrapper_end() {}
}