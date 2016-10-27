<?php
/**
 * Retrieve the name of the highest priority template file that exists.
 *
 * Searches in the STYLESHEETPATH before TEMPLATEPATH and marketengine/templates
 * so that themes which inherit from a parent theme can just overload one file.
 *
 * @since 1.0
 *
 * @param string|array $template_names Template file(s) to search for, in order.
 * @param bool         $load           If true the template file will be loaded if it is found.
 * @param bool         $require_once   Whether to require_once or require. Default true. Has no effect if $load is false.
 *
 * @return string The template filename if one is located.
 */
function me_locate_template($template_names) {
    $located          = '';
    $me_template_path = ME()->template_path();
    foreach ((array) $template_names as $template_name) {
        if (!$template_name) {
            continue;
        }
        if (file_exists(STYLESHEETPATH . '/' . $me_template_path . $template_name)) {
            $located = STYLESHEETPATH . '/' . $me_template_path . $template_name;
            break;
        } elseif (file_exists(TEMPLATEPATH . '/' . $me_template_path . $template_name)) {
            $located = TEMPLATEPATH . '/' . $me_template_path . $template_name;
            break;
        } elseif (file_exists(ME()->plugin_path() . '/templates/' . $template_name)) {
            $located = ME()->plugin_path() . '/templates/' . $template_name;
            break;
        }
    }
    return $located;
}
/**
 * Load a template part into a template
 *
 * Makes it easy for a theme to reuse sections of code in a easy to overload way
 * for child themes.
 *
 * Includes the named template part for a theme or if a name is specified then a
 * specialised part will be included. If the theme contains no {slug}.php file
 * then no template will be included.
 *
 * The template is included using require, not require_once, so you may include the
 * same template part multiple times.
 *
 * For the $name parameter, if the file is called "{slug}-special.php" then specify
 * "special".
 *
 * @since 1.0
 *
 * @param string $slug The slug name for the generic template.
 * @param string $args The array of the varaible.
 */
function me_get_template($template_name, $args = array()) {
    if ( ! empty( $args ) && is_array( $args ) ) {
        extract( $args );
    }
    /**
     * Fires before the specified template part file is loaded.
     *
     * The dynamic portion of the hook name, `$slug`, refers to the slug name
     * for the generic template part.
     *
     * @since 1.0.0
     *
     * @param string $slug The slug name for the generic template.
     * @param string $args The array of the varaible.
     */
    do_action("me_get_template_$template_name", $template_name, $args);

    $templates = array();

    if ('' !== $template_name) {
        $templates[] = "$template_name.php";
    }

    $located = me_locate_template($templates);
    include( $located );
}

function me_get_sidebar() {
    /**
     * Fires before the sidebar template file is loaded.
     *
     * The hook allows a specific sidebar template file to be used in place of the
     * default sidebar template file. If your file is called sidebar-new.php,
     * you would specify the filename in the hook as get_sidebar( 'new' ).
     *
     * @since 1.0
     *
     * @param string $name Name of the specific sidebar file to use.
     */
    do_action('me_get_sidebar', $name);

    $templates = array();
    $name      = (string) $name;
    if ('' !== $name) {
        $templates[] = "sidebar-{$name}.php";
    }

    $templates[] = 'sidebar.php';

    me_locate_template($templates, true);
}

// TODO: can dat ham nay cho dung vi tri file
if(! function_exists('me_get_page_permalink') ){
    function me_get_page_permalink( $page_name ) {
        $page = me_option('me_'. $page_name .'_page_id');
        if (!$page) {
            return home_url();
        }
        return get_permalink($page);
    }
}


/**
 * Returns the url to the lost password endpoint url.
 *
 * @access public
 * @param  string $default_url
 * @return string
 */
function me_lostpassword_url($default_url = '') {
    $profile_link       = me_get_page_permalink('user_account');
    $password_reset_url = me_get_endpoint_url('forgot-password', '', $profile_link);
    if (false !== $password_reset_url) {
        return $password_reset_url;
    } else {
        return $default_url;
    }
}
add_filter('lostpassword_url', 'me_lostpassword_url', 10, 1);

/**
 * Get endpoint URL.
 *
 * Gets the URL for an endpoint, which varies depending on permalink settings.
 *
 * @param  string $endpoint
 * @param  string $value
 * @param  string $permalink
 *
 * @return string
 */
function me_get_endpoint_url($ep_query_var, $value = '', $permalink = '') {
    if (!$permalink) {
        $permalink = get_permalink();
    }

    $endpoint = me_get_endpoint_name($ep_query_var);

    if (get_option('permalink_structure')) {
        if (strstr($permalink, '?')) {
            $query_string = '?' . parse_url($permalink, PHP_URL_QUERY);
            $permalink    = current(explode('?', $permalink));
        } else {
            $query_string = '';
        }
        $url = trailingslashit($permalink) . $endpoint . '/' . $value . $query_string;
    } else {
        $url = add_query_arg($endpoint, $value, $permalink);
    }

    return apply_filters('marketengine_get_endpoint_url', $url, $endpoint, $value, $permalink);
}

/**
 * Display listing tags form fields.
 *
 * @since 1.0
 *
 * @todo Create taxonomy-agnostic wrapper for this.
 *
 * @param string $default The tax default value
 * @param array   $taxonomy {
 *     Tags meta box arguments.
 * }
 */
function me_post_tags_meta_box($default, $taxonomy) {
    $tax_name              = esc_attr($taxonomy);
    $taxonomy              = get_taxonomy($taxonomy);
    $user_can_assign_terms = current_user_can($taxonomy->cap->assign_terms);
    $comma                 = _x(',', 'tag delimiter');
    $terms_to_edit         = '';

    $terms_to_edit = $default;
    ?>
    <?php if ($user_can_assign_terms): ?>
        <div class="tagsdiv" id="<?php echo $tax_name; ?>">
            <div class="jaxtag">
            <div class="nojs-tags hide-if-js">
                <label class="me-field-title" for="tax-input-<?php echo $tax_name; ?>"><?php echo $taxonomy->labels->add_or_remove_items; ?></label>
                <textarea style="display:none;" name="<?php echo $tax_name; ?>" rows="3" cols="20" class="the-tags" id="tax-input-<?php echo $tax_name; ?>" <?php disabled(!$user_can_assign_terms);?> aria-describedby="new-tag-<?php echo $tax_name; ?>-desc"><?php echo str_replace(',', $comma . ' ', $terms_to_edit); // textarea_escaped by esc_attr()    ?></textarea>
            </div>

            <div class="ajaxtag hide-if-no-js">
                <p><input type="text" id="new-tag-<?php echo $tax_name; ?>" name="newtag[<?php echo $tax_name; ?>]" class="newtag form-input-tip" size="16" autocomplete="off" aria-describedby="new-tag-<?php echo $tax_name; ?>-desc" placeholder="Type here and press enter to create listing tags." value="" />
            </div>

            </div>
            <div class="tagchecklist"></div>
        </div>

        <p class="hide-if-no-js"><a href="#titlediv" class="tagcloud-link" id="link-<?php echo $tax_name; ?>"><?php echo $taxonomy->labels->choose_from_most_used; ?></a></p>
    <?php endif;?>
<?php
}

/**
 * MarketEngine Paginate Link
 *
 * @since 1.0
 */
function me_paginate_link( $me_query = array() ) {
    $max_num_pages = 0;
    if( $me_query === array() ) {
        global $wp_query;
        $max_num_pages = $wp_query->max_num_pages;
    }
    else {
        $max_num_pages = $me_query->max_num_pages;
    }

    $big = 999999999; // need an unlikely integer

    $args = array(
        'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format'    => '?paged=%#%',
        'total'     => $max_num_pages,
        'current'   => max(1, get_query_var('paged')),
        'show_all'  => false,
        'end_size'  => 1,
        'mid_size'  => 2,
        'prev_next' => true,
        'prev_text' => __("&lt;", "enginethemes"),
        'next_text' => __('&gt;', "enginethemes"),
        'type'      => 'plain',
        'add_args'  => false,
    );

    echo paginate_links($args);
}

function marketengine_sidebar() {
    me_get_template('global/sidebar');
}
add_action('marketengine_sidebar', 'marketengine_sidebar');

// TODO: tam thoi de day
function ae_get_option($option, $default = '') {
    return get_option( $option, $default );
}

function me_option($option){
    $options = ME_Options::get_instance();
    return $options->get_option($option);
}

// TODO: noi bo ham nay
function me_get_client_ip() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function me_get_client_agent() {
    return !empty($_SERVER['HTTP_USER_AGENT'])? strtolower($_SERVER['HTTP_USER_AGENT']) : '';
}

/**
 * Returns url of user account page or an its endpoint.
 *
 * @param $query_var
 * @return $url if user_account page is existed
 *          $home_url if no user_account page
 *
 */

function me_get_auth_url( $query_var = '', $value = '' ) {
    $url = me_get_page_permalink( 'user_account' );
    if($url){
        $url = me_get_endpoint_url( $query_var, $value, $url );
        return $url;
    }
    return home_url();
}

/**
 * Returns url to process order
 *
 * @param $query_var
 * @return $url if user_account page is existed
 *          $home_url if no user_account page
 *
 */

function me_get_order_url( $page, $query_var = 'order-id', $value = '' ) {
    $url           = me_get_page_permalink( $page );
    $order_endpoint = me_get_endpoint_name( $query_var );
    $permalink_structure = get_option( 'permalink_structure');

    if($url){
        $url = me_get_endpoint_url( $query_var, $value, $url );
        return $url;
    }
    return home_url();
}


/**
 * Prints shop categories.
 *
 * Adds an action to get shop categories selectbox template.
 *
 */
function me_shop_categories_action() {
    me_get_template('global/shop-categories');
}
add_action( 'me_shop_categories', 'me_shop_categories_action' );

/**
 * Prints account menu.
 *
 * Adds an action to get account menu selectbox template.
 *
 */
function me_account_menu_action() {
    me_get_template('global/account-menu');
}
add_action( 'me_account_menu', 'me_account_menu_action' );
function me_account_menu_flag_filter($flag) {
    $flag = false;
    return $flag;
}
add_filter('me_account_menu_flag', 'me_account_menu_flag_filter');

/**
 * Prints post listing button.
 *
 */
function me_post_listing_button_action() {
    me_get_template('global/post-listing-button');
}
add_action( 'me_post_listing_button', 'me_post_listing_button_action' );

function me_status_list_action( $type = '' ) {
    me_get_template('global/status-list', array('type' => $type) );
}
add_action( 'me_status_list', 'me_status_list_action' );

/**
 *  Returns css class for each order status
 *  @param: $status
 *  @param: $needed style or index of order process
 */
function me_get_order_status_info( $status, $needed = '' ) {
    $status_list = me_get_order_status_list();
    switch ($status) {
        case 'me-pending':
            $style = 'me-order-pending';
            $order_process = 1;
            break;
        // chua co class cho status nay
        case 'publish':
            $style = 'me-order-complete';
            $order_process = 2;
            break;
        case 'me-complete':
            $style = 'me-order-complete';
            $order_process = 3;
            break;
        case 'me-disputed':
            $style = 'me-order-disputed';
            $order_process = 4;
            break;
        case 'me-closed':
            $style = 'me-order-closed';
            $order_process = 5;
            break;
        case 'me-resolved':
            $style = 'me-order-resolved';
            $order_process = 5;
            break;
        default:
            $style = 'me-order-pending';
            $order_process = 1;
            break;
    }
    if('style' === $needed){
        return $style;
    }
    return $order_process;
}

/**
 *  Prints html of order status
 */
function me_print_order_status( $status ) {
    $status_list = me_get_order_status_list();
    $style = me_get_order_status_info( $status, 'style' );
    echo '<span class="'.$style.'">'.$status_list[$status].'</span>';
}

/**
 *  Prints buyer's information
 *  @param: $address
 */
function me_print_buyer_information( $address ) {
    echo "Name: {$address['first_name']} {$address['last_name']} ";
    foreach ($address as $key => $value) {
        if($key === 'first_name' || $key === 'last_name') continue;
        $key = ucfirst( $key );
        echo "<p>{$key}: {$value}</p>";
    }
}

/**
 *  Returns html of price
 *  @param: $price
 */
function me_price_html( $price, $currency_sign = '' , $unit = '' ) {
    $currency_sign = me_option('payment-currency-sign');
    $currency_code = me_option('payment-currency-code');
    $sign_position = me_option('currency-sign-postion') ? true : false;
    $html = '';

    if($sign_position) {
        $html .= '<b itemprop="priceCurrency" content="' . $currency_code .'">'. $currency_sign .'</b> <b itemprop="price" content="'. $price .'">'. $price .'</b>';
    } else {
        $html .= '<b itemprop="price" content="'. $price .'">'. $price .'</b> <b itemprop="priceCurrency" content="' . $currency_code .'">'. $currency_sign .'</b>';
    }

    if( !empty($unit) ) {
        $html .= " {$unit}";
    }

    return $html;
}

// TODO: sua lai ko xai dinh dang html
function me_price_format($price, $args = array()) {
    $sign = me_option('payment-currency-sign');
    $code = me_option('payment-currency-code');

    $args = wp_parse_args( $args, array('code' => $code, 'sign' => $sign) );
    extract($args);

    $format = '';

    $sign_position_is_align_right = me_option('currency-sign-postion') ? true : false;

    if($sign_position_is_align_right) {
        $format .= $sign .' '. $price;
    } else {
        $format .= $price .' '. $sign;
    }

    return $format;
}

function marketengine_comments( $comment, $args, $depth ){
    me_get_template('single-listing/review-item', array('comment' => $comment, 'args' => $args, 'depth' => $depth));
}