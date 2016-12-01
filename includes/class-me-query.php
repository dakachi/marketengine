<?php
class ME_Query
{
    static $instance = null;

    public static function instance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct()
    {
        add_action('pre_get_posts', array($this, 'filter_pre_get_posts'));
    }

    /**
     *
     */
    public function filter_pre_get_posts($query)
    {
        // Only affect the main query
        if (!$query->is_main_query()) {
            return;
        }

        if (is_archive('listing') && !is_admin()) {
            $query->set('post_status', 'publish');
        }

        if ($query->is_author()) {
            $query->set('post_type', 'listing');
            $query->set('post_status', 'publish');
        }

        global $wp_post_types;
        if (is_search()) {
            $wp_post_types['listing']->exclude_from_search = true;
        }

        return $this->filter_listing_query($query);

    }

    /**
     * Filter, sort listing
     */
    public function filter_listing_query($query)
    {
        if (!$query->is_post_type_archive('listing') && !$query->is_tax(get_object_taxonomies('listing'))) {
            return $query;
        }

        $query = $this->sort_listing_query($query);
        $query = $this->filter_price_query($query);
        $query = $this->filter_listing_type_query($query);
        $query = $this->filter_search_query($query);
    }
    /**
     * Filter query listing by price
     * @param object $query The WP_Query Object
     * @since 1.0
     */
    public function filter_price_query($query)
    {
        if (!empty($_GET['price-min']) && !empty($_GET['price-max'])) {
            $min_price                                       = $_GET['price-min'];
            $max_price                                       = $_GET['price-max'];
            $query->query_vars['meta_query']['filter_price'] = array(
                'key'     => 'listing_price',
                'value'   => array($min_price, $max_price),
                'type'    => 'numeric',
                'compare' => 'BETWEEN',
            );

            $query->query_vars['meta_query']['type'] = array(
                'key'     => '_me_listing_type',
                'value'   => 'purchasion',
                'compare' => '=',
            );

            $query->query_vars['meta_query']['relation'] = 'AND';

        }
        return $query;
    }

    /**
     * Filter query listing by listing type
     * @param object $query The WP_Query Object
     * @since 1.0
     */
    public function filter_listing_type_query($query)
    {
        if (!empty($_GET['type'])) {
            $query->query_vars['meta_query']['filter_type'] = array(
                'key'     => '_me_listing_type',
                'value'   => $_GET['type'],
                'compare' => '=',
            );
        }
        return $query;
    }

    /**
     * Filter query listing by keyword
     * @param object $query The WP_Query Object
     * @since 1.0
     */
    public function filter_search_query($query)
    {
        if (!empty($_GET['keyword'])) {
            $query->query_vars['s'] = $_GET['keyword'];
        }
        return $query;
    }

    /**
     * Sort the listing
     * @param object $query The WP_Query Object
     * @since 1.0
     */
    public function sort_listing_query($query)
    {
        if (!empty($_GET['orderby'])) {
            switch ($_GET['orderby']) {
                case 'date':
                    $query->set('orderby', 'date');
                    break;
                case 'price':
                    $query = $this->sort_by_price($query, 'asc');
                    break;
                case 'price-desc':
                    $query = $this->sort_by_price($query, 'desc');
                    break;
                case 'rating':
                    $query->set('meta_key', '_me_rating');
                    $query->set('orderby', 'meta_value_num');
                    $query->set('order', 'desc');
            }
        }
        return $query;
    }

    public function sort_by_price($query, $asc = 'asc')
    {
        $query->set('meta_key', 'listing_price');
        $meta_query = array(
            'relation'     => 'AND',
            'filter_price' => array(
                'key' => 'listing_price',
            ),
            'type'         => array(
                'key'     => '_me_listing_type',
                'value'   => 'purchasion',
                'compare' => '=',
            ),
        );
        $query->set('meta_query', $meta_query);
        $query->set('orderby', 'meta_value_num');
        $query->set('order', $asc);
        return $query;
    }
}

ME_Query::instance();

function me_products_plugin_query_vars($vars)
{
    $vars[] = 'order-id';
    $vars[] = 'keyword';

    return $vars;
}
add_filter('query_vars', 'me_products_plugin_query_vars');

/**
 * Returns the page id
 *
 * @access public
 * @param  string $page
 * @return int
 */
function me_get_page_id($page)
{
    $page_id  = me_option('me_' . $page . '_page_id');
    $page_obj = get_post($page_id);
    return $page_id && isset($page_obj) ? absint($page_id) : -1;
}

/**
 * Returns the endpoint name by query_var.
 *
 * @access public
 * @param  string $query_var
 * @return string
 */
function me_get_endpoint_name($query_var)
{
    $query_var         = str_replace('-', '_', $query_var);
    return me_option('ep_' . $query_var, 'order');
}

/**
 * Returns the default endpoints.
 *
 * @access public
 * @return array of endpoints
 */
function me_get_default_endpoints()
{
    $endpoint_arr = array(
        'forgot_password' => 'forgot-password',
        'reset_password'  => 'reset-password',
        'register'        => 'register',
        'edit_profile'    => 'edit-profile',
        'change_password' => 'change-password',
        'listings'        => 'listings',
        'orders'          => 'orders',
        'order_id'        => 'order',
        'purchases'       => 'purchases',
        'pay'             => 'pay',
        'listing_id'      => 'listing-id',
        'seller_id'       => 'seller',
    );
    return $endpoint_arr;
}

/**
 * Renames endpoints and returns them.
 *
 * @access public
 * @return array of endpoints
 */
function me_setting_endpoint_name()
{
    $endpoint_arr = me_get_default_endpoints();
    foreach ($endpoint_arr as $key => $value) {
        $option_value = me_option('ep_' . $key);
        if (isset($option_value) && !empty($option_value) && $option_value != $value) {
            $endpoint_arr[$key] = $option_value;
        }
    }
    return $endpoint_arr;
}

/**
 * Rewrite page url.
 *
 * @access public
 */
function me_page_rewrite_rule($rewrite_args)
{
    foreach ($rewrite_args as $key => $value) {
        if ($value['page_id'] > -1) {
            $page = get_post($value['page_id']);
            add_rewrite_rule('^/' . $page->post_name . '/' . $value['endpoint_name'] . '/([^/]*)/?', 'index.php?page_id=' . $value['page_id'] . '&' . $value['query_var'] . '=$matches[1]', 'top');
        }
    }
}

/**
 * add account endpoint
 */
function me_init_endpoint()
{
    $endpoint_arr = me_setting_endpoint_name();
    foreach ($endpoint_arr as $key => $value) {
        add_rewrite_endpoint($value, EP_ROOT | EP_PAGES, str_replace('_', '-', $key));
    }

    $rewrite_args = array(
        array(
            'page_id'       => me_get_page_id('confirm_order'),
            'endpoint_name' => me_get_endpoint_name('order-id'),
            'query_var'     => 'order-id',
        ),

        array(
            'page_id'       => me_get_page_id('cancel_order'),
            'endpoint_name' => me_get_endpoint_name('order-id'),
            'query_var'     => 'order-id',
        ),
        array(
            'page_id'       => me_get_page_id('me_checkout'),
            'endpoint_name' => me_get_endpoint_name('pay'),
            'query_var'     => 'pay',
        ),
    );
    me_page_rewrite_rule($rewrite_args);

    $endpoints = array('orders', 'purchases', 'listings');
    foreach ($endpoints as $endpoint) {
        add_rewrite_rule('^(.?.+?)/' . me_get_endpoint_name($endpoint) . '/page/?([0-9]{1,})/?$', 'index.php?pagename=$matches[1]&paged=$matches[2]&' . $endpoint, 'top');
    }

    $edit_listing_page = me_get_page_id('edit_listing');
    if ($edit_listing_page > -1) {
        $page = get_post($edit_listing_page);
        add_rewrite_rule('^/' . $page->post_name . '/' . me_get_endpoint_name('listing_id') . '/?([0-9]{1,})/?$', 'index.php?page_id=' . $edit_listing_page . '&listing_id' . '=$matches[1]', 'top');
    }

    rewrite_order_url();
}
add_action('init', 'me_init_endpoint');

/**
 * Filters order detail url.
 *
 * @since       1.0.0
 * @version     1.0.0
 */
function rewrite_order_url()
{
    $order_endpoint = me_get_endpoint_name('order_id');
    add_filter('post_type_link', 'custom_me_order_link', 1, 3);

    add_rewrite_rule($order_endpoint . '/([0-9]+)/?$', 'index.php?post_type=me_order&p=$matches[1]', 'top');
}

/**
 * Filters order detail url.
 *
 * @param       string $permalink
 * @param       object $post
 * @return      string $permalink
 *
 * @since       1.0.0
 * @version     1.0.0
 */
function custom_me_order_link($order_link, $post = 0)
{
    if ($post->post_type == 'me_order') {
        if (get_option('permalink_structure')) {
            $pos        = strrpos($order_link, '%/');
            $order_link = substr($order_link, 0, $pos + 1);
        }
        return str_replace('%post_id%', $post->ID, $order_link);
    } else {
        return $order_link;
    }
}
