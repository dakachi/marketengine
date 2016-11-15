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
function me_locate_template($template_names)
{
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
function me_get_template($template_name, $args = array())
{
    if (!empty($args) && is_array($args)) {
        extract($args);
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
    include $located;
}

function me_get_sidebar()
{
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
if (!function_exists('me_get_page_permalink')) {
    function me_get_page_permalink($page_name)
    {
        $page = me_option('me_' . $page_name . '_page_id');
        if (!$page = get_post($page)) {
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
function me_lostpassword_url($default_url = '')
{
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
function me_get_endpoint_url($ep_query_var, $value = '', $permalink = '')
{
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
function me_post_tags_meta_box($default, $taxonomy)
{
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
                <textarea style="display:none;" name="<?php echo $tax_name; ?>" rows="3" cols="20" class="the-tags" id="tax-input-<?php echo $tax_name; ?>" <?php disabled(!$user_can_assign_terms);?> aria-describedby="new-tag-<?php echo $tax_name; ?>-desc"><?php echo str_replace(',', $comma . ' ', $terms_to_edit); // textarea_escaped by esc_attr()       ?></textarea>
            </div>

            <div class="ajaxtag hide-if-no-js">
                <p><input type="text" id="new-tag-<?php echo $tax_name; ?>" name="newtag[<?php echo $tax_name; ?>]" class="newtag form-input-tip" size="16" autocomplete="off" aria-describedby="new-tag-<?php echo $tax_name; ?>-desc" value="" />
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
function me_paginate_link($me_query = array())
{
    $max_num_pages = 0;
    if ($me_query === array()) {
        global $wp_query;
        $max_num_pages = $wp_query->max_num_pages;
    } else {
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

    echo paginate_links($args) ? '<div>' . paginate_links($args) . '</div>' : '';
}

function marketengine_sidebar()
{
    me_get_template('global/sidebar');
}
add_action('marketengine_sidebar', 'marketengine_sidebar');

// TODO: tam thoi de day
function me_get_option($option, $default = '')
{
    return get_option($option, $default);
}

function me_option($option, $default = '')
{
    $options = ME_Options::get_instance();
    return $options->get_option($option, $default);
}

function me_update_option($option, $value)
{
    $options = ME_Options::get_instance();
    return $options->update_option($option, $value);
}

// TODO: noi bo ham nay
function me_get_client_ip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function me_get_client_agent()
{
    return !empty($_SERVER['HTTP_USER_AGENT']) ? strtolower($_SERVER['HTTP_USER_AGENT']) : '';
}

/**
 * Returns url of user account page or an its endpoint.
 *
 * @param $query_var
 * @return $url if user_account page is existed
 *          $home_url if no user_account page
 *
 */

function me_get_auth_url($query_var = '', $value = '')
{
    $url = me_get_page_permalink('user_account');
    if ($url) {
        $url = me_get_endpoint_url($query_var, $value, $url);
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

function me_get_order_url($page, $query_var = 'order-id', $value = '')
{
    $url                 = me_get_page_permalink($page);
    $order_endpoint      = me_get_endpoint_name($query_var);
    $permalink_structure = get_option('permalink_structure');

    if ($url) {
        $url = me_get_endpoint_url($query_var, $value, $url);
        return $url;
    }
    return home_url();
}

/**
 * Returns url of seller profile
 *
 * @param $query_var
 * @return $url if user_account page is existed
 *          $home_url if no user_account page
 *
 */

function me_get_seller_profile_url($seller_id)
{
    if (!$seller_id) {
        return;
    }

    $url            = me_get_page_permalink('seller_profile');
    $order_endpoint = me_get_endpoint_name('seller_id');

    if ($url) {
        $url = me_get_endpoint_url('seller_id', $seller_id, $url);
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
function me_shop_categories_action()
{
    me_get_template('global/shop-categories');
}
add_action('me_shop_categories', 'me_shop_categories_action');

/**
 * Prints account menu.
 *
 * Adds an action to get account menu selectbox template.
 *
 */
function me_account_menu_action()
{
    me_get_template('global/account-menu');
}
add_action('me_account_menu', 'me_account_menu_action');
function me_account_menu_flag_filter($flag)
{
    $flag = false;
    return $flag;
}
add_filter('me_account_menu_flag', 'me_account_menu_flag_filter');

/**
 * Prints post listing button.
 *
 */
function me_post_listing_button_action()
{
    me_get_template('global/post-listing-button');
}
add_action('me_post_listing_button', 'me_post_listing_button_action');

function me_search_form_action()
{
    marketengine_get_search_form();
}
add_action('me_search_form', 'me_search_form_action');

function me_status_list_action($type = '')
{
    me_get_template('global/status-list', array('type' => $type));
}
add_action('me_status_list', 'me_status_list_action');

/**
 *  Returns css class for each order status
 *  @param: $status
 *  @param: $needed style or index of order process
 */
function me_get_order_status_info($status, $info_type = '')
{
    $status_list = me_get_order_status_list();

    switch ($status) {
        case 'me-pending':
            $style         = 'me-order-pending';
            $text          = __('Your payment has not been completed yet', 'enginethemes');
            $order_process = 1;
            break;
        case 'publish':
            $style         = 'me-order-complete';
            $text          = __('', 'enginethemes');
            $order_process = 2;
            break;
        // chua co class cho status nay
        case 'me-active':
            $style         = 'me-order-complete';
            $text          = __('', 'enginethemes');
            $order_process = 2;
            break;
        case 'me-complete':
            $style         = 'me-order-complete';
            $text          = __('', 'enginethemes');
            $order_process = 3;
            break;
        case 'me-disputed':
            $style         = 'me-order-disputed';
            $text          = __('This order has been disputed by the Buyer', 'enginethemes');
            $order_process = 4;
            break;
        case 'me-closed':
            $style         = 'me-order-closed';
            $text          = __('', 'enginethemes');
            $order_process = 5;
            break;
        case 'me-resolved':
            $style         = 'me-order-resolved';
            $text          = __('', 'enginethemes');
            $order_process = 5;
            break;
        default:
            $style         = 'me-order-pending';
            $text          = __('', 'enginethemes');
            $order_process = 1;
            break;
    }
    if ('style' === $info_type) {
        return $style;
    }
    if ('text' === $info_type) {
        return $text;
    }
    return $order_process;
}

/**
 *  Prints html of order status
 */
function me_print_order_status($status)
{
    $status_list = me_get_order_status_list();
    $style       = me_get_order_status_info($status, 'style');
    echo '<span class="' . $style . '">' . $status_list[$status] . '</span>';
}

/**
 *  Prints buyer's information
 *  @param: $address
 */
function me_print_buyer_information($address)
{
    echo "Name: {$address['first_name']} {$address['last_name']} ";
    foreach ($address as $key => $value) {
        if ($key === 'first_name' || $key === 'last_name') {
            continue;
        }

        $key = ucfirst($key);
        echo "<p>{$key}: {$value}</p>";
    }
}

/**
 *  Returns html of price
 *  @param: $price
 */
function me_price_html($price, $args = array(), $unit = '')
{
    $sign = me_option('payment-currency-sign');
    $code = me_option('payment-currency-code');

    $args = wp_parse_args($args, array('code' => $code, 'sign' => $sign));

    extract($args);

    $sign_position = me_option('currency-sign-postion') ? true : false;
    $html          = '';

    if ($sign_position) {
        $html .= '<span class="sign" itemprop="priceCurrency" content="' . $code . '">' . $sign . '</span><span itemprop="price" content="' . $price . '">' . $price . '</span>';
    } else {
        $html .= '<span itemprop="price" content="' . $price . '">' . $price . '</span><span class="sign"  itemprop="priceCurrency" content="' . $code . '">' . $sign . '</span>';
    }

    if (!empty($unit)) {
        $html .= " {$unit}";
    }

    return $html;
}

/**
 * Get the price format with currency
 *
 * @param float $price
 * @param array the array of currency code and sign
 *
 * @return string
 */
function me_price_format($price, $args = array())
{
    $sign = me_option('payment-currency-sign');
    $code = me_option('payment-currency-code');

    $args = wp_parse_args($args, array('code' => $code, 'sign' => $sign));
    extract($args);

    $format = '';

    $sign_position_is_align_right = me_option('currency-sign-postion') ? true : false;

    if ($sign_position_is_align_right) {
        $format .= $sign . $price;
    } else {
        $format .= $price . $sign;
    }

    return $format;
}

/**
 * Retrieve listing comment list item
 */
function marketengine_comments($comment, $args, $depth)
{
    me_get_template('single-listing/review-item', array('comment' => $comment, 'args' => $args, 'depth' => $depth));
}

/**
 * Display listing search form.
 *
 * @since 1.0
 *
 * @param bool $echo Default to echo and not return the form.
 * @return string|void String when $echo is false.
 */
function marketengine_get_search_form($echo = true)
{
    /**
     * Fires before the search form is retrieved, at the start of get_search_form().
     *
     * @since 1.0
     *
     */
    do_action('marketengine_pre_get_search_form');

    $format = current_theme_supports('html5', 'search-form') ? 'html5' : 'xhtml';

    // $format = apply_filters( 'marketengine_search_form_format', $format );

    // $search_form_template = locate_template( 'searchform.php' );
    // if ( '' != $search_form_template ) {
    //     ob_start();
    //     require( $search_form_template );
    //     $form = ob_get_clean();
    // } else {

    // }
    $url = get_post_type_archive_link('listing');
    if (is_tax('listing_category')) {
        $url = get_term_link(get_queried_object(), 'listing_category');
    }

    if ('html5' == $format) {
        $form = '<form role="search" method="get" class="search-form" action="' . $url . '">
                <div class="me-search me-hidden-xs">
                    <input type="search" class="search-field" placeholder="' . esc_attr(__("Type here and hit enter...", "enginethemes")) . '" value="' . esc_attr(get_query_var('keyword')) . '" name="keyword" />
                    <i id="search-btn" class="icon-me-search me-search-btn"></i>
                </div>
            </form>
            <form method="get" class="mobile-search-form" action="' . $url . '">
                <span class="me-search-btn-xs me-visible-xs"><i class="icon-me-search me-search-btn"></i></span>
                <div class="me-search-xs me-visible-xs">
                    <input type="search" name="s" value="' . esc_attr(get_query_var('keyword')) . '" placeholder="' . esc_attr(__("Type here and hit enter...", "enginethemes")) . '">
                    <i id="mobile-search-btn" class="icon-me-search me-search-btn"></i>
                </div>
            </form>';
    } else {
        $form = '<form role="search" method="get" class="search-form" action="' . $url . '">
                <div class="me-search me-hidden-xs">
                    <input type="text" class="search-field" placeholder="' . esc_attr(__("Type here and hit enter...", "enginethemes")) . '" value="' . esc_attr(get_query_var('keyword')) . '" name="keyword" />
                    <i id="search-btn" class="icon-me-search me-search-btn"></i>
                </div>
            </form>
            <form method="get" class="mobile-search-form" action="' . $url . '">
                <span class="me-search-btn-xs me-visible-xs"><i class="icon-me-search me-search-btn"></i></span>
                <div class="me-search-xs me-visible-xs">
                    <input type="text" name="s" value="' . esc_attr(get_query_var('keyword')) . '" placeholder="' . esc_attr(__("Type here and hit enter...", "enginethemes")) . '">
                    <i id="mobile-search-btn" class="icon-me-search me-search-btn"></i>
                </div>
            </form>';

    }

    /**
     * Filters the HTML output of the search form.
     *
     * @since 1.0
     *
     * @param string $form The search form HTML output.
     */
    $result = apply_filters('marketengine_get_search_form', $form);

    if (null === $result) {
        $result = $form;
    }

    if ($echo) {
        echo $result;
    } else {
        return $result;
    }

}

/**
 * Display the archive title based on the queried object.
 *
 * @since 1.0
 *
 * @see marketengine_get_the_archive_title()
 *
 * @param string $before Optional. Content to prepend to the title. Default empty.
 * @param string $after  Optional. Content to append to the title. Default empty.
 */
function marketengine_the_archive_title($before = '', $after = '')
{
    $title = marketengine_get_the_archive_title();

    if (!empty($title)) {
        echo $before . $title . $after;
    }
}

/**
 * Retrieve the archive listing title based on the queried object.
 *
 * @since 1.0
 *
 * @return string Archive title.
 */
function marketengine_get_the_archive_title()
{
    if (is_post_type_archive()) {
        $title = sprintf(__('Archives: %s', 'enginethemes'), post_type_archive_title('', false));
        if (get_query_var('keyword')) {
            $title = sprintf(__("Search result for: %s", "enginethemes"), esc_attr(get_query_var('keyword')));
        }

    } elseif (is_tax()) {
        $tax = get_taxonomy(get_queried_object()->taxonomy);
        /* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
        $title = sprintf(__('%1$s: %2$s'), $tax->labels->singular_name, single_term_title('', false));
    } else {
        $title = __('Archives', 'enginethemes');
    }

    /**
     * Filters the archive title.
     *
     * @since 4.1.0
     *
     * @param string $title Archive title to be displayed.
     */
    return apply_filters('marketengine_get_the_archive_title', $title);
}

/**
 * Trims text to a certain number of words.
 *
 * This function is localized. For languages that count 'words' by the individual
 * character (such as East Asian languages), the $num_words argument will apply
 * to the number of individual characters.
 *
 * @since 1.0
 *
 * @param string $text      Text to trim.
 * @param int    $num_words Number of words. Default 55.
 * @param string $more      Optional. What to append if $text needs to be trimmed. Default '&hellip;'.
 * @return string Trimmed text.
 */
function me_trim_words($text, $num_words = 55, $more = null)
{
    if (null === $more) {
        $more = __('&hellip;');
    }

    $original_text = $text;
    //$text = wp_strip_all_tags( $text );

    /*
     * translators: If your word count is based on single characters (e.g. East Asian characters),
     * enter 'characters_excluding_spaces' or 'characters_including_spaces'. Otherwise, enter 'words'.
     * Do not translate into your own language.
     */
    if (strpos(_x('words', 'Word count type. Do not translate!'), 'characters') === 0 && preg_match('/^utf\-?8$/i', get_option('blog_charset'))) {
        //$text = trim( preg_replace( "/[\n\r\t ]+/", ' ', $text ), ' ' );
        //preg_match_all( '/./u', $text, $words_array );
        $words_array = array_slice($words_array[0], 0, $num_words + 1);
        $sep         = '';
    } else {
        $words_array = preg_split("/[\n\r\t ]+/", $text, $num_words + 1, PREG_SPLIT_NO_EMPTY);
        $sep         = ' ';
    }

    if (count($words_array) > $num_words) {
        array_pop($words_array);
        $text = implode($sep, $words_array);
        $text = $text . $more;
    } else {
        $text = implode($sep, $words_array);
    }

    /**
     * Filters the text content after words have been trimmed.
     *
     * @since 3.3.0
     *
     * @param string $text          The trimmed text.
     * @param int    $num_words     The number of words to trim the text to. Default 5.
     * @param string $more          An optional string to append to the end of the trimmed text, e.g. &hellip;.
     * @param string $original_text The text before it was trimmed.
     */
    return apply_filters('me_trim_words', $text, $num_words, $more, $original_text);
}

/**
 * Format file size Unit
 *
 * @param int $bytes
 * @return string
 */
function me_format_size_units($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' kB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}