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
        $order_data = apply_filters('marketengine_paypal_args', array_merge(
            array(
                'cmd'           => '_cart',
                'business'      => 'dinhle1987-biz@yahoo.com', //$this->gateway->get_option('email'),
                'no_note'       => 1,
                'currency_code' => get_marketengine_currency(),
                'charset'       => 'utf-8',
                'rm'            => 2, //is_ssl() ? 2 : 1,
                'upload'        => 1,
                'return'        => $order->get_confirm_url(), //esc_url_raw(add_query_arg('utm_nooverride', '1', $this->gateway->get_return_url($order))),
                'cancel_return' => $order->get_cancel_url(),
                // 'page_style'    => $this->gateway->get_option('page_style'),
                // 'paymentaction' => $this->gateway->get_option('paymentaction'),
                'bn'            => 'ShoppingCart',
                'invoice'       => 'ME-' . $order->get_order_number(),
                'custom'        => json_encode(array('order_id' => $order->id)),
                'notify_url'    => home_url('?me-payment=ME_Paypal_Simple'),
                'first_name'    => $order->billing_first_name,
                'last_name'     => $order->billing_last_name,
                'address1'      => $order->billing_address_1,
                'address2'      => $order->billing_address_2,
                'city'          => $order->billing_city,
                // 'state'         => $this->get_paypal_state($order->billing_country, $order->billing_state),
                'zip'           => $order->billing_postcode,
                'country'       => $order->billing_country,
                'email'         => $order->billing_email,
            ),
            // $this->get_phone_number_args($order),
            //$this->get_shipping_args($order),
            $this->get_listing_item_args($order)
        ), $order);

        return http_build_query($order_data);
    }

    public function get_listing_item_args($order) {
        $listing_item = me_get_order_items($order->id, 'listing_item');
        $listing      = array();
        $index        = 0;
        foreach ($listing_item as $key => $item) {
            $listing['item_name_' . $index]   = $item->order_item_name;
            $listing['quantity_' . $index]    = me_get_order_item_meta($item->order_item_id, '_qty', true);
            $listing['amount_' . $index]      = me_get_order_item_meta($item->order_item_id, '_listing_price', true);
            $listing['item_number_' . $index] = me_get_order_item_meta($item->order_item_id, '_listing_id', true);
            $index++;
        }
        return $listing;
    }

    /**
     * Get shipping args for paypal request.
     * @param  WC_Order $order
     * @return array
     */
    protected function get_shipping_args($order) {
        $shipping_args = array();

        if ('no' == 'yes') {
            $shipping_args['address_override'] = 'yes' === 'yes' ? 1 : 0;
            $shipping_args['no_shipping']      = 0;

            // If we are sending shipping, send shipping address instead of billing
            $shipping_args['first_name'] = $order->shipping_first_name;
            $shipping_args['last_name']  = $order->shipping_last_name;
            // $shipping_args['company']          = $order->shipping_company;
            $shipping_args['address1'] = $order->shipping_address;
            $shipping_args['address2'] = $order->shipping_address;
            $shipping_args['city']     = $order->shipping_city;
            // $shipping_args['state']            = $this->get_paypal_state( $order->shipping_country, $order->shipping_state );
            $shipping_args['country'] = $order->shipping_country;
            $shipping_args['zip']     = $order->shipping_postcode;
        } else {
            $shipping_args['no_shipping'] = 1;
        }

        return $shipping_args;
    }

    public function setup_payment($order) {
        // 2checkout url for direct purchase link using the 3rd-Party Cart parameters
        $paypal = $this->_paypal_url . $this->build_query($order);
        return (object) array('transaction_url' => $paypal);
    }

    public function complete_payment($response) {
        try {

            if(empty($response['custom'])) {
                throw new Exception(__("Invalid post back.", "enginethemes"));
            }

            $order = json_decode(stripslashes($response['custom']));
            $order = get_post($order->order_id);

            if (!$order || is_wp_error($order)) {
                throw new Exception(__("The order not existed.", "enginethemes"));
            }

            $order = new ME_Order($order);
            if ($this->validate_order($response, $order)) {

                $payment_status = $response['payment_status'];
                if($payment_status == 'Completed') {
                    $id = wp_update_post(array('ID' => $order->id, 'post_status' => 'publish'));    
                    update_post_meta($id, '_payer_id', $response['payer_id']);
                    update_post_meta($id, '_txn_id', $response['txn_id']);
                    update_post_meta($id, '_payer_email', $response['payer_email']);
                }

            } else {
                throw new Exception(__("Fraud.", "enginethemes"));
            }

        } catch (Exception $e) {
            return new WP_Error('payment_response_error', $e->getMessage());
        }
    }

    public function validate_order($response, $order) {
        $txn_id         = $response['txn_id'];
        $mc_gross       = $response['mc_gross'];
        $currency       = $response['mc_currency'];
        $receiver_email = $response['receiver_email'];

        if (!$this->validate_mcgross($mc_gross, $order) || !$this->validate_receiver($receiver_email, $order) || !$this->validate_currency($currency, $order)) {
            return false;
        }
        if ($this->check_txn_id($txn_id)) {
            return false;
        }

        return true;
    }

    private function validate_mcgross($mc_gross, $order) {
        return $mc_gross == $order->get_total();
    }

    private function validate_receiver($receiver_email, $order) {
        return $receiver_email === $order->get_receiver_email();
    }

    private function validate_currency($currency, $order) {
        return $currency === $order->get_currency();
    }

    private function check_txn_id($id) {
        global $wpdb;
        $query = "SELECT * FROM $wpdb->postmeta WHERE meta_value='{$id}'";

        $results = $wpdb->query($query);
        if (!$results) {
            return false;
        }
        return true;
    }

    public function refund($order) {}
}