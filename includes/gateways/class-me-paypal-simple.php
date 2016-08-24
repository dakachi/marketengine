<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class ME_Paypal_Simple extends ME_Payment {

    /**
     * The single instance of the class.
     *
     * @var ME_Paypal_Simple
     * @since 1.0
     */
    static $_instance;

    /**
     * @var string $_api_endpoint The server URL which you have to connect for submitting your API request.
     * @since 1.0
     */
    protected $_api_endpoint;

    /**
     * Version: this is the API version in the request.
     * It is a mandatory parameter for each API request.
     * The only supported value at this time is 2.3
     */
    protected $_version;

    /**
     * @var string $_paypal_url The URL that the buyer is first sent to to authorize payment with their paypal account change the URL depending if you are testing on the sandbox
     * or going to the live PayPal site
     * @since 1.0
     */
    protected $_paypal_url;

    /**
     * Main ME_Paypal_Simple Instance.
     *
     * Ensures only one instance of ME_Paypal_Simple is loaded or can be loaded.
     *
     * @since 1.0
     * @return ME_Paypal_Simple - Main instance.
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        $api = ae_get_option('simple_paypal_api', array('receiver_email' => 'david87dang@gmail.com'));

        $this->receiver_email = 'dinhle1987-biz@yahoo.com';

        // username : dinhle1987-biz_api1.yahoo.com
        // password: 1362804968
        // Signature: A6LFoneN6dpKOQkj2auJBwoVZBiLAE-QivfFWXkjxrvJZ6McADtMu8Pe

        $this->_api_endpoint = 'https://api-3t.sandbox.paypal.com/nvp';

        $this->_proxy    = false;
        $this->_test_mod = ae_get_option('is_test_mod', true);

        $this->_paypal_url = 'https://www.paypal.com/cgi-bin/webscr?';
        if ($this->_test_mod) {
            $this->_paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr?';
        }
    }

    /**
     * Function to perform the API call 3rd-Party Cart parameter
     *
     * @param array  $order
     *
     * @since 1.0
     * @return string
     */
    public function set_checkout($order) {
        // 2checkout url for direct purchase link using the 3rd-Party Cart parameters
        $paypal = $this->_paypal_url . $this->build_query($order);
        return $paypal;
    }

    // https://developer.paypal.com/docs/classic/paypal-payments-standard/integration-guide/formbasics/
    public function build_query($order) {
        $order_data =  apply_filters('marketengine_paypal_args', array_merge(
            array(
                'cmd'           => '_cart',
                'business'      => $this->gateway->get_option('email'),
                'no_note'       => 1,
                'currency_code' => get_woocommerce_currency(),
                'charset'       => 'utf-8',
                'rm'            => is_ssl() ? 2 : 1,
                'upload'        => 1,
                'return'        => esc_url_raw(add_query_arg('utm_nooverride', '1', $this->gateway->get_return_url($order))),
                'cancel_return' => esc_url_raw($order->get_cancel_order_url_raw()),
                'page_style'    => $this->gateway->get_option('page_style'),
                'paymentaction' => $this->gateway->get_option('paymentaction'),
                'bn'            => 'WooThemes_Cart',
                'invoice'       => $this->gateway->get_option('invoice_prefix') . $order->get_order_number(),
                'custom'        => json_encode(array('order_id' => $order->id, 'order_key' => $order->order_key)),
                'notify_url'    => $this->notify_url,
                'first_name'    => $order->billing_first_name,
                'last_name'     => $order->billing_last_name,
                'company'       => $order->billing_company,
                'address1'      => $order->billing_address_1,
                'address2'      => $order->billing_address_2,
                'city'          => $order->billing_city,
                'state'         => $this->get_paypal_state($order->billing_country, $order->billing_state),
                'zip'           => $order->billing_postcode,
                'country'       => $order->billing_country,
                'email'         => $order->billing_email,
            ),
            $this->get_phone_number_args($order),
            $this->get_shipping_args($order),
            $this->get_line_item_args($order)
        ), $order);

        return http_build_query($order_data);
    }

    public function setup_payment($order) {
        // 2checkout url for direct purchase link using the 3rd-Party Cart parameters
        $paypal = $this->_paypal_url . $this->build_query($order);
        return (object) array('transaction_url' => home_url());
    }
    public function process_payment($order) {}
    public function refund($order) {}
}