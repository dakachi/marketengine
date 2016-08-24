<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

abstract class ET_PaymentVisitor {
    protected $_order;
    protected $_settings;
    protected $_payment_type;

    public function __construct(ET_Order $order) {

    }

    public function set_order($order = array()) {
        
    }

    public function add_return_param() {
        
    }

    public function set_settings($args = array()) {
        

    }

    abstract public function setup_checkout(ET_Order $order);
    abstract public function do_checkout(ET_Order $order);
}

class ET_PaypalVisitor extends ET_PaymentVisitor {

    protected $_payment_type = 'paypal';

    public function setup_checkout(ET_Order $order) {

    }

    /**
     * checkout and process payment when post back
     * @param $order object ET_Order
     * @return array
     * @since 1.0
     * @author Dakachi
     */
    public function do_checkout(ET_Order $order) {

    }
    /**
     * when the ipn post back fail, check the order status and do a check with the return back
     * @param object $order ET_Order
     * @return array
     * @since 1.2
     * @author Dakachi
     */
    public function do_checkout_get_back(ET_Order $order) {
    }
}