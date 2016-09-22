<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Paypal Adaptive class
 */
class ME_PPAdaptive extends ME_Payment {
    /**
     * The single instance of the class.
     *
     * @var ME_PPAdaptive
     * @since 1.0
     */
    static $_instance;

    /**
     * @var string $appID
     * The paypal adaptive application id
     */
    public $appID;
    /**
     * @var array $api
     * The paypal adaptive api settings
     */
    public $api;

    /**
     * @var string $_enpoint
     * The Paypal Adaptive process payment endpoint
     */
    protected $_endpoint;

    /**
     * @var string $_paypal_url
     * The paypal authentication url
     */
    protected $_paypal_url;

    /**
     * Main ME_PPAdaptive Instance.
     *
     * Ensures only one instance of ME_PPAdaptive is loaded or can be loaded.
     *
     * @since 1.0
     * @return ME_PPAdaptive - Main instance.
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constuctor
     * @since 1.0
     */
    public function __construct() {

        // $api       = ae_get_option('escrow_paypal_api', array());
        $this->api = ae_get_option('escrow_paypal_api',
            array(
                'username'  => 'dinhle1987-biz_api1.yahoo.com',
                'password'  => '1362804968',
                'signature' => 'A6LFoneN6dpKOQkj2auJBwoVZBiLAE-QivfFWXkjxrvJZ6McADtMu8Pe',
            )
        );

        $this->appID = isset($this->api['appID']) ? $this->api['appID'] : 'APP-80W284485P519543T';

        $testmode = ae_get_option('test_mode', true);
        // test mod is on
        $this->endpoint        = 'https://svcs.sandbox.paypal.com/AdaptivePayments/';
        $this->paypal_url      = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_ap-payment&paykey=';
        $this->preapproval_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_ap-preapproval&preapprovalkey=';
        // live mod is on
        if (!$testmode) {
            $this->endpoint        = 'https://svcs.paypal.com/AdaptivePayments/';
            $this->paypal_url      = 'https://www.paypal.com/cgi-bin/webscr?cmd=_ap-payment&paykey=';
            $this->preapproval_url = 'https://www.paypal.com/cgi-bin/webscr?cmd=_ap-preapproval&preapprovalkey=';
        }

        $this->feesPayer = "EACHRECEIVER";
    }

    /**
     * Retrieve the paypal pending reason message
     *
     * @param string $pending_reason The pending reson keyword
     * @since 1.0
     *
     * @return string
     */
    public function get_pending_message($pending_reason) {
        $pending_reason = strtoupper($pending_reason);
        $reason         = array(
            'ECHECK'         => __('The payment is pending because it was made by an eCheck that has not yet cleared.', 'enginethemes'),
            'MULTI_CURRENCY' => __('The receiver does not have a balance in the currency sent, and does not have the Payment Receiving Preferences set to automatically convert and accept this payment. Receiver must manually accept or deny this payment from the Account Overview.', 'enginethemes'),
            'UPGRADE'        => __('The payment is pending because it was made via credit card and the receiver must upgrade the account to a Business account or Premier status to receive the funds. It can also mean that receiver has reached the monthly limit for transactions on the account', 'enginethemes'),
            'VERIFY'         => __('The payment is pending because the receiver is not yet verified.', 'enginethemes'),
            'RISK'           => __('The payment is pending while it is being reviewed by PayPal for risk.', 'enginethemes'),
            'OTHER'          => __('The payment is pending for review. For more information, contact PayPal Customer Service.', 'enginethemes'),
        );
        if (isset($reason[$pending_reason])) {
            return $reason[$pending_reason];
        }
        return $reason['OTHER'];
    }

    /**
     * Build HTTP headers specifying authentication, the application ID, the device ID or IP address for each request
     *
     * @since 1.0
     * @return array
     */
    public function build_headers() {
        $headers = array(
            'X-PAYPAL-APPLICATION-ID'       => $this->appID,
            'X-PAYPAL-SECURITY-USERID'      => $this->api['username'],
            'X-PAYPAL-SECURITY-PASSWORD'    => $this->api['password'],
            'X-PAYPAL-SECURITY-SIGNATURE'   => $this->api['signature'],
            // 'X-PAYPAL-SECURITY-SUBJECT: ' . $this->APISubject,
            // 'X-PAYPAL-SECURITY-VERSION: ' . $this->APIVersion,
            'X-PAYPAL-REQUEST-DATA-FORMAT'  => 'NV',
            'X-PAYPAL-RESPONSE-DATA-FORMAT' => 'JSON',
            // 'X-PAYPAL-DEVICE-ID: ' . $this->DeviceID,
            // 'X-PAYPAL-DEVICE-IPADDRESS: ' . $this->IPAddress
        );

        return $headers;
    }
    /**
     * The GetVerifiedStatus API operation lets you determine whether the specified PayPal account's status is verified or unverified.
     */
    public function get_verified_account($info) {

        $testmode = ae_get_option('test_mode');
        // test mod is on
        $endpoint = 'https://svcs.sandbox.paypal.com/AdaptiveAccounts/';
        // live mod is on
        if (!$testmode) {
            $endpoint = 'https://svcs.paypal.com/AdaptiveAccounts/';
        }

        $endpoint = $endpoint . 'GetVerifiedStatus';
        $headers  = $this->build_headers();
        $response = wp_remote_post($endpoint, array(
            'headers'     => $headers,
            'body'        => $info,
            'httpversion' => '1.1',
        ));

        if (!is_wp_error($response)) {
            return json_decode($response['body']);
        }
        return $response;
    }

    /**
     * Send request to paypal adaptive endpoint
     *
     * @param string $endpoint The API endpoint
     * @param array $data The request data send to Paypal Adaptive API
     *
     * @since 1.0
     * @return Object | WP_Error
     */
    protected function send_request($endpoint, $data = array()) {
        $endpoint = $this->endpoint . $endpoint;
        $headers  = $this->build_headers();

        $data['requestEnvelope.errorLanguage'] = get_bloginfo('language');
        $response                              = wp_remote_post($endpoint, array(
            'headers'     => $headers,
            'body'        => $data,
            'httpversion' => '1.1',
        ));

        if (!is_wp_error($response)) {
            $response = json_decode($response['body']);
            if (empty($response->error)) {
                $response->transaction_url = $this->paypal_url . $response->payKey;
            } else {
                $error    = $response->error;
                $response = new WP_Error('payment_fail', $error[0]->message);
            }
        }

        return $response;

    }

    /**
     * The ExecutePayment API operation lets you execute a payment set up with
     * the Pay API operation with the actionType CREATE.
     * To pay receivers identified in the Pay call, pass the pay key you received from the PayResponse message in the ExecutePaymentRequest message.
     *
     * https://developer.paypal.com/docs/classic/api/adaptive-payments/ExecutePayment_API_Operation/
     *
     * @param $payKey (Optional) The pay key that identifies the payment to be executed.
     *          This is the pay key returned in the PayResponse message.
     *
     * @since 1.0
     * @return object | WP_Error
     */
    public function execute_payment($paykey) {
        $data = array('payKey' => $paykey);
        return $this->send_request('ExecutePayment', $data);
    }

    /**
     * Use the Pay API operation to transfer funds from a sender's PayPal account to one or more receivers' PayPal accounts.
     * You can use the Pay API for simple payments and parallel payments.
     *
     * @param ME_Order $order
     *          - receiverList.receiver(0).email
     *          - receiverList.receiver(0).amount
     *          - currencyCode
     * @since 1.0
     * @author Dakachi
     */
    public function pay($order) {
        $data               = $order;
        $data['actionType'] = 'PAY';
        // Pay, PAY_PRIMARY
        return $this->send_request('Pay', $data);
    }

    /**
     * Use the Pay API operation to transfer funds from a sender's PayPal account to one or more receivers' PayPal accounts.
     * You can use the Pay API for delayed chained payments.
     *
     * @param ME_Order $order
     *          - receiverList.receiver(0).email
     *          - receiverList.receiver(0).amount
     *          - currencyCode
     * @since 1.0
     * @author Dakachi
     */
    public function pay_primary($order) {
        $data               = $order;
        $data['actionType'] = 'PAY_PRIMARY';
        return $this->send_request('Pay', $data);
    }

    /**
     * Use the Refund API operation to refund all or part of a payment.
     * https://developer.paypal.com/docs/classic/api/adaptive-payments/Refund_API_Operation/
     *
     * @param ME_Order $order
     *
     * @since 1.0
     * @return object | WP_Error
     */
    public function refund($order) {
        $payKey = $order->get_payment_key();
        $data   = array('payKey' => $paykey);
        return $this->send_request('Refund', $data);
    }

    /**
     * Use the Preapproval API operation to set up an agreement between yourself
     * and a sender for making payments on the sender's behalf.
     * You set up a preapprovals for a specific maximum amount over a specific period of time and,
     * optionally, by any of the following constraints:
     *  - the number of payments,
     *  - a maximum per-payment amount,
     *  - a specific day of the week or the month,
     *  - and whether or not a PIN is required for each payment request.
     *
     * @param $endingDate Last date for which the preapproval is valid. It cannot be later than one year from the starting date. Contact PayPal if you do not want to specify an ending date.
     * @param $startingDate First date for which the preapproval is valid. It cannot be before today's date or after the ending date.
     * @since 1.2
     * @author Dakachi
     */
    public function pre_approval($order) {
        return $this->send_request('Preapproval', $order);
    }

    /**
     * Retrieve the pre-approval payment details
     * @param string $preapproval_key
     *
     * @since 1.0
     * @return object | WP_Error
     */
    public function pre_approval_details($preapproval_key) {
        $data = array('preapprovalKey' => $paykey);
        return $this->send_request('PreapprovalDetails', $data);
    }

    /**
     * Use the CancelPreapproval API operation to handle the canceling of preapprovals.
     * Preapprovals can be canceled regardless of the state they are in, such as active, expired, deactivated, and previously canceled.
     *
     * @param string $paykey The payment pre-approval key
     *
     * @since 1.0
     * @return object | WP_Error
     */
    public function cancel_approval($preapproval_key) {
        $data = array('preapprovalKey' => $preapproval_key);
        return $this->send_request('CancelPreapproval', $data);
    }

    /**
     * Use the PaymentDetails API operation to obtain information about a payment.
     * You can identify the payment by the tracking ID, the PayPal transaction ID in an IPN message, or the pay key associated with the payment.
     *
     * @param $payKey
     *
     * @since 1.0
     * @return object | WP_Error
     */
    public function payment_details($paykey) {
        $data = array('payKey' => $paykey);
        return $this->send_request('PaymentDetails', $data);
    }

    /**
     * Use the GetFundingPlans API operation to determine the funding sources that are available for a specified payment,
     * identified by its key, which takes into account the preferences and country of the receiver as well as the payment amount.
     * You must be both the sender of the payment and the caller of this API operation
     *
     * https://developer.paypal.com/docs/classic/api/adaptive-payments/GetFundingPlans_API_Operation/
     *
     * @param string $payKey
     * @since 1.0
     * @return object | WP_Error
     */
    public function get_funding_plans($payKey) {
        $data = array('payKey' => $paykey);
        return $this->send_request('GetFundingPlans', $data);
    }

    /**
     * Specifies the settings for a payment.
     * If you start a payment by specifying an actionType of CREATE in a Pay API call, you can use the SetPaymentOptions API to specify settings
     * for the payment.
     *
     * @param string $paykey
     * @param array $options
     *
     * @since 1.0
     * @return Object | WP_Error
     */
    public function set_payment_options($paykey, $options) {
        $options['payKey'] = $paykey;
        return $this->send_request('GetPaymentOptions', $options);
    }

    /**
     * Use the GetPaymentOptions API to retrieve the options previously specified in the SetPaymentOptions API.
     *
     * @param $payKey
     * @since 1.0
     * @return Object | WP_Error
     */
    public function get_payment_options($payKey) {
        $data = array('payKey' => $payKey);
        return $this->send_request('GetPaymentOptions', $data);
    }

    /**
     * Use the GetPrePaymentDisclosure API to get the pre-Payment disclosure and response.
     * This API is specific for merchants who must support the Consumer Financial Protection Bureau's Remittance Transfer Rule.
     * @param $payKey
     * @param $receiverInfoList
     * @since 1.3
     * @author Dakachi
     */
    public function GetPrePaymentDisclosure() {
    }

    public function GetShippingAddresses() {
    }

}

/**
 * ME Paypal Adaptive Request
 * The class handle setup and receive post back from paypal
 *
 * @version     1.0
 * @package     Payment
 * @category    Includes/Gateways
 *
 * @author      Dakachi
 */
class ME_PPAdaptive_Request {

    /**
     * The ME_PPAdaptive instance
     * @var ME_PPAdaptive
     */
    private $gateway;

    /**
     * The single instance of the class.
     *
     * @var ME_PPAdaptive
     * @since 1.0
     */
    static $_instance;

    /**
     * Main ME_PPAdaptive Instance.
     *
     * Ensures only one instance of ME_PPAdaptive is loaded or can be loaded.
     *
     * @since 1.0
     * @return ME_PPAdaptive - Main instance.
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        $this->gateway = ME_PPAdaptive::instance();
    }

    /**
     * Check the option pay primary or note
     */
    private function is_pay_primary() {
        return apply_filters('marketengine_ppadaptive_is_pay_primary', false);
    }

    /**
     * Get the site's commission fee
     */
    private function get_commission_fee() {
        return ae_get_option('commission_fee', 5);
    }

    /**
     * Get the site's receive commission email
     */
    private function get_commission_email() {
        return ae_get_option('commission_email', 'dinhle1987-pers@yahoo.com');
    }

    /**
     * Retrieve order receiver list item
     *
     * @param Object $order ME_Order object
     *
     * @since 1.0
     * @return array
     */
    private function get_receiver_list_args($order) {
        $receiver_list = array(
            'receiverList.receiver(0).amount' => $order->get_total(),
            'receiverList.receiver(0).email'  => $order->get_receiver_email(),
            //'receiverList.receiver(0).primary' => !$this->is_pay_primary(),

            // freelancer receiver
            'receiverList.receiver(1).amount' => $this->get_commission_fee(),
            'receiverList.receiver(1).email'  => $this->get_commission_email(),
            //'receiverList.receiver(1).primary' => $this->is_pay_primary(),
        );

        $receiver_0 = (object) array(
            'user_name'  => 'dinhle',
            'email'      => $order->get_receiver_email(),
            'amount'     => $order->get_total(),
            'is_primary' => true,
        );

        $receiver_1 = (object) array(
            'user_name'  => 'admin',
            'email'      => $this->get_commission_email(),
            'amount'     => $this->get_commission_fee(),
            'is_primary' => false,
        );

        $order->add_receiver($receiver_0);
        $order->add_receiver($receiver_1);

        return apply_filters('marketegnine_ppadaptive_receiver_list', $receiver_list, $order);
    }

    /**
     * Setup the request data send to ppadaptive
     *
     * @param object $order The me_order object
     *
     * @since 1.0
     * @return object
     */
    public function setup_payment($order) {
        // TODO: setup order payment

        $order_data = array_merge(array(
            //esc_url_raw(add_query_arg('utm_nooverride', '1', $this->gateway->get_return_url($order))),
            'returnUrl'                     => $order->get_confirm_url(),
            'cancelUrl'                     => $order->get_cancel_url(),
            'ipnNotificationUrl'            => home_url('?me-payment=ME_PPAdaptive_Request'),

            'currencyCode'                  => get_marketengine_currency(),
            'feesPayer'                     => 'EACHRECEIVER',
            'requestEnvelope.errorLanguage' => get_bloginfo('language'),
        ),
            $this->get_receiver_list_args($order)
        );

        $response = $this->gateway->pay($order_data);
        if (!empty($response->payKey)) {
            update_post_meta($order->id, '_me_ppadaptive_paykey', $response->payKey);
        }

        return $response;
    }

    /**
     * Catch the post back from paypal adaptive to update order
     *
     * @since 1.0
     * @return void
     */
    public function complete_payment() {
        $order_id = get_query_var('order-id');
        if (!$order_id) {
            return;
        }
        $payKey = get_post_meta($order_id, '_me_ppadaptive_paykey', true);
        $this->process_order($order_id, $payKey);
    }

    /**
     * Process the order
     *
     * @param Int $order_id The order id
     * @param String $paykey The paypal adaptive pay key
     * @since 1.0
     */
    public function process_order($order_id, $payKey) {

        $response = $this->gateway->payment_details($payKey);
        if (is_wp_error($response)) {
            return;
        }

        switch ($response->status) {

        case 'COMPLETED':
            $this->order_finish($response, $order_id);
            break;
        case 'INCOMPLETE':
            $this->order_incomplete($response, $order_id);
        case 'PROCESSING':
        case 'PENDING':
            $this->order_pending($response, $order_id);
        case 'REVERSALERROR':
        default:
            $this->order_error($response, $order_id);
            break;
        }

        update_post_meta($order_id, '_sender_email', $response->senderEmail);
        update_post_meta($order_id, '_sender_account_id', $response->sender->accountId);
        update_post_meta($order_id, '_action_type', $response->actionType);
        update_post_meta($order_id, '_fees_payer', $response->feesPayer);
    }

    /**
     * Update order receiver list
     *
     * @param Object $response The paypal response Post back
     * @param Int $order_id Current processing order id
     *
     * @since 1.0
     * @author EngineThemes
     * @return void
     */
    private function update_receiver($response, $order_id) {
        $payment_info   = $response->paymentInfoList->paymentInfo;
        $receiver_items = me_get_order_items($order_id, 'receiver_item');
        foreach ($receiver_items as $key => $receiver) {
            if (!empty($payment_info[$key]->transactionId)) {
                me_add_order_item_meta($receiver->order_item_id, '_transaction_id', $payment_info[$key]->transactionId);
                me_add_order_item_meta($receiver->order_item_id, '_transaction_status', $payment_info[$key]->transactionStatus);
            }
            me_add_order_item_meta($receiver->order_item_id, 'refunded_amount', $payment_info[$key]->refundedAmount);
            me_add_order_item_meta($receiver->order_item_id, '_pending_refund', $payment_info[$key]->pendingRefund);
        }
    }

    /**
     * Finish the order
     * Order has been completed and is paid to the target account Seller & Admin
     *
     * @param Object $response The paypal response Post back
     * @param Int $order_id Current processing order id
     *
     * @since 1.0
     * @author EngineThemes
     * @return void
     */
    private function order_finish($response, $order_id) {
        $this->update_receiver($response, $order_id);
        wp_update_post(array(
            'ID'          => $order_id,
            'post_status' => 'me-complete',
        ));
    }

    /**
     * The order is incomplete, fund just sent to primary receiver.
     * Status of payment order was pay, but not yet eligible to transfer money to the Seller account
     *
     * @param Object $response The paypal response Post back
     * @param Int $order_id Current processing order id
     *
     * @since 1.0
     * @author EngineThemes
     * @return void
     */
    private function order_incomplete($response, $order_id) {
        $this->update_receiver($response, $order_id);
        // update order receiver item, commission fee item
        wp_update_post(array(
            'ID'          => $order_id,
            'post_status' => 'me-active',
        ));
    }

    private function order_pending($response, $order_id) {
    }

    private function order_error($response, $order_id) {
    }

    private function api_fee() {
        return array(
            'PRIMARYRECEIVER' => __("Primary receiver pays all fees", 'enginethemes'),
            'EACHRECEIVER'    => __("Each receiver pays their own fee", 'enginethemes'),
            'SECONDARYONLY'   => __("Secondary receivers pay all fees", 'enginethemes'),
        );
    }

}

// TODO: Paypal adaptive IPN class
// https://developer.paypal.com/docs/classic/adaptive-payments/integration-guide/APIPN/
class ME_Adaptive_IPN {
    /**
     * The single instance of the class.
     *
     * @var ME_Adaptive_IPN
     * @since 1.0
     */
    static $_instance;

    /**
     * Main ME_Adaptive_IPN Instance.
     *
     * Ensures only one instance of ME_Adaptive_IPN is loaded or can be loaded.
     *
     * @since 1.0
     * @return ME_Adaptive_IPN - Main instance.
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        add_action('marketegine_me_ppadaptive_request', array($this, 'handle_ipn'));
    }

    private function handle_ipn($response) {
        // update_option( 'paypal_ipn',$_POST );
        update_option('paypal_ipn', 'runned');
        if ($response['transaction_type'] == 'Adaptive Payment PAY') {
            $paykey   = $response['pay_key'];
            $order_id = $this->get_order_id($paykey);
            if ($order_id) {
                ME_PPAdaptive_Request::instance()->process_order($order_id, $paykey);
            }
        }

    }

    private function get_order_id($paykey) {
        global $wpdb;
        $sql    = "select post_id, meta_key from $wpdb->postmeta where meta_value = '{$paykey}'";
        $result = $wpdb->get_row($sql, ARRAY_A);
        if ($result) {
            return $result['post_id'];
        }
        return false;
    }
}
add_action( 'init', 'me_handle_ipn' );
function me_handle_ipn() {
    ME_Adaptive_IPN::instance();    
}
