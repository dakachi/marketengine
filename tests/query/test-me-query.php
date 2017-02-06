<?php
class Test_ME_Query extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
        $this->post_factory = new WP_UnitTest_Factory_For_Post();
        $this->options = ME_Options::get_instance();
        $this->me_query = ME_Query::instance();
    }

    public function setUp() {
        parent::setUp();
        // $this->create_test_pages();
        // register_post_type('me_order', array(
        //     'public'             => false,
        //     'publicly_queryable' => true,
        //     'rewrite'            => array(
        //         'slug' => marketengine_get_endpoint_name('order-id') . '/%post_id%',
        //     ),
        //     'has_archive'        => true,
        //     'query_var'          => true,
        //     'capability_type'    => 'post',
        // ));
    }

    public function tearDown() {
        // global $wp_post_types;
        // if ( isset( $wp_post_types[ 'me_order' ] ) ) {
        //     unset( $wp_post_types[ 'me_order' ] );
        // }
    }

    public function test_me_get_option_page_id() {
        $pages = $this->get_list_of_pages();
        foreach( $pages as $page ) {
            $result = marketengine_get_option_page_id( $page );
            $this->assertEquals(-1, $result);

            $page_id = $this->post_factory->create_object( array(
                'post_type' => 'page',
                'post_name' => $page,
            ) );
            $name = "me_{$page}_page_id";
            $this->options->$name = $page_id;
            $this->options->save();
            $result = marketengine_get_option_page_id($page);
            $this->assertEquals($page_id, $result);
        }
    }

    public function test_me_get_endpoint_name() {
        $result = marketengine_get_endpoint_name('forgot-password');
        $this->assertEquals('forgot-password', $result);

        $option_name = 'ep_forgot_password';
        $this->options->$option_name = 'quen-mat-khau';
        $this->options->save();
        $result = marketengine_get_endpoint_name('forgot_password');
        $this->assertEquals('quen-mat-khau', $result);
    }

    public function test_rewrite_payment_flow_url() {
        global $wp_rewrite;

        $pages = $this->get_payment_pages();
        $this->create_test_pages($pages);
        $rewrite_args = $this->get_payment_rewrite_args();

        $redirect = array();
        $pattern = array();

        foreach ($rewrite_args as $key => $value) {
            $page = get_post($value['page_id']);

            $redirect[] = 'index.php?page_id=' . $value['page_id'] . '&' . $value['query_var'] . '=$matches[1]';
            $pattern[] = '^/' . $page->post_name . '/' . $value['endpoint_name'] . '/([^/]*)/?';

            add_rewrite_rule($pattern[$key], $redirect[$key], 'top');
        }

        flush_rewrite_rules();
        $rewrite_rules = $wp_rewrite->extra_rules_top;

        foreach ($pages as $key => $page) {
            $this->assertSame( $redirect[$key], $rewrite_rules[ $pattern[$key] ] );
        }

        unset($this->options);
    }

    public function test_rewrite_user_account_url() {
        global $wp_rewrite;

        $endpoints = array('orders', 'purchases', 'listings');
        foreach ($endpoints as $key => $endpoint) {
            $pattern[] = '^(.?.+?)/' . marketengine_get_endpoint_name($endpoint) . '/page/?([0-9]{1,})/?$';
            $redirect[] = 'index.php?pagename=$matches[1]&paged=$matches[2]&' . $endpoint;

            add_rewrite_rule($pattern[$key], $redirect[$key], 'top');
        }

        flush_rewrite_rules();
        $rewrite_rules = $wp_rewrite->extra_rules_top;

        foreach ($endpoints as $key => $endpoint) {
            $this->assertSame( $redirect[$key], $rewrite_rules[ $pattern[$key] ] );
        }
    }

    public function test_rewrite_edit_listing_url() {
        global $wp_rewrite;
        $edit_listing_page = marketengine_get_option_page_id('edit_listing');

        $this->assertEquals( -1, $edit_listing_page);

        $edit_listing_page = $post_id = $this->post_factory->create_object( array(
            'post_type' => 'page',
            'post_name' => 'edit-listing',
        ) );
        $page = get_post($edit_listing_page);

        $pattern = '^/' . $page->post_name . '/' . marketengine_get_endpoint_name('listing_id') . '/?([0-9]{1,})/?$';
        $redirect = 'index.php?page_id=' . $edit_listing_page . '&listing_id' . '=$matches[1]';
        add_rewrite_rule($pattern, $redirect, 'top');

        flush_rewrite_rules();
        $rewrite_rules = $wp_rewrite->extra_rules_top;

        $this->assertSame( $redirect, $rewrite_rules[ $pattern ] );
    }

    public function test_rewrite_order_detail_url() {
        global $wp_rewrite;
        $order_endpoint = marketengine_get_endpoint_name('order_id');

        $pattern = $order_endpoint . '/([0-9]+)/?$';
        $redirect = 'index.php?post_type=me_order&p=$matches[1]';
        add_rewrite_rule($pattern, $redirect, 'top');

        flush_rewrite_rules();
        $rewrite_rules = $wp_rewrite->extra_rules_top;

        $this->assertSame( $redirect, $rewrite_rules[ $pattern ] );
    }

    public function test_custom_order_link_if_not_order() {
        $post_id = $this->post_factory->create_object( array(
            'post_content' => 'This is not order',
        ) );

        $post = get_post($post_id);

        $this->assertSame( site_url( '?p='.$post_id ), get_the_permalink($post) );
    }

    public function test_custom_order_link() {
        $order_id = $this->post_factory->create_object( array(
            'post_type' => 'me_order',
        ) );

        $order = get_post($order_id);
        $this->assertSame( site_url('?post_type=me_order&p='.$order_id), get_the_permalink($order) );
    }

    public function test_custom_order_link_with_pretty_url() {
        // global $wp_rewrite;
        // $wp_rewrite->extra_permastructs['me_order'] = '/order/%post_id%/%me_order%';

        // $order_id = $this->post_factory->create_object( array(
        //     'post_type' => 'me_order',
        // ) );
        // $order_endpoint = marketengine_get_endpoint_name('order_id');

        // $this->set_permalink_structure('%postname%');

        // $order = get_post($order_id);
        // $this->assertSame( site_url($order_endpoint.'/'.$order_id), get_the_permalink($order) );
    }

    function get_list_of_pages() {
        return array('user_account', 'post_listing', 'edit_listing', 'checkout', 'confirm_order', 'cancel_order', 'inquiry');
    }

    function create_test_pages( $pages ) {
        foreach( $pages as $page ) {
            $page_id = $this->post_factory->create_object( array(
                'post_type' => 'page',
                'post_name' => $page,
            ) );

            $option_name = "me_{$page}_page_id";
            $this->options->$option_name = $page_id;
            $this->options->save();
        }
    }

    function get_list_of_endpoints() {
        return array('forgot-password', 'register', 'edit-profile', 'change-password', 'listings', 'orders', 'purchases', 'order');
    }

    function get_payment_pages() {
        return array('checkout', 'confirm_order', 'cancel_order');
    }

    function get_payment_rewrite_args() {
        $rewrite_args = array(
            array(
                'page_id'       => marketengine_get_option_page_id('confirm_order'),
                'endpoint_name' => marketengine_get_endpoint_name('order-id'),
                'query_var'     => 'order-id',
            ),

            array(
                'page_id'       => marketengine_get_option_page_id('cancel_order'),
                'endpoint_name' => marketengine_get_endpoint_name('order-id'),
                'query_var'     => 'order-id',
            ),
            array(
                'page_id'       => marketengine_get_option_page_id('checkout'),
                'endpoint_name' => marketengine_get_endpoint_name('pay'),
                'query_var'     => 'pay',
            ),
        );

        return $rewrite_args;
    }
}
