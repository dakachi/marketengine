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
    function me_get_page_permalink($page_name) {
        $options = ME_Options::get_instance();
        $page = $options->get_option('me_'. $page_name .'_page_id');
        // $page = get_page_by_path($page_name);
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
                <label class="text" for="tax-input-<?php echo $tax_name; ?>"><?php echo $taxonomy->labels->add_or_remove_items; ?></label>
                <p><textarea style="display:none;" name="<?php echo $tax_name; ?>" rows="3" cols="20" class="the-tags" id="tax-input-<?php echo $tax_name; ?>" <?php disabled(!$user_can_assign_terms);?> aria-describedby="new-tag-<?php echo $tax_name; ?>-desc"><?php echo str_replace(',', $comma . ' ', $terms_to_edit); // textarea_escaped by esc_attr()    ?></textarea></p>
            </div>

            <div class="ajaxtag hide-if-no-js">
                <label class="screen-reader-text" for="new-tag-<?php echo $tax_name; ?>"><?php echo $taxonomy->labels->add_new_item; ?></label>
                <p><input type="text" id="new-tag-<?php echo $tax_name; ?>" name="newtag[<?php echo $tax_name; ?>]" class="newtag form-input-tip" size="16" autocomplete="off" aria-describedby="new-tag-<?php echo $tax_name; ?>-desc" value="" />
            </div>
            <p class="howto" id="new-tag-<?php echo $tax_name; ?>-desc"><?php echo $taxonomy->labels->separate_items_with_commas; ?></p>

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
    me_get_template('sidebar');
}
add_action('marketengine_sidebar', 'marketengine_sidebar');

// TODO: tam thoi de day
function ae_get_option($option, $default = '') {
    return get_option( $option, $default );
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

function me_get_auth_url( $query_var = '' ) {
    $url = me_get_page_permalink( 'user_account' );
    if($url){
        $url = me_get_endpoint_url( $query_var, '', $url );
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
function me_shop_categories_action(){
    me_get_template('global/shop-categories');
}
add_action( 'me_shop_categories', 'me_shop_categories_action' );

/**
 * Prints account menu.
 *
 * Adds an action to get account menu selectbox template.
 *
 */
function me_account_menu_action(){
    me_get_template('global/account-menu');
}
add_action( 'me_account_menu', 'me_account_menu_action' );

/**
 * Prints post listing button.
 *
 */
function me_post_listing_button_action(){
    me_get_template('global/post-listing-button');
}
add_action( 'me_post_listing_button', 'me_post_listing_button_action' );