<?php
function me_locate_template($template_names, $load = false, $require_once = true) {
    $located = '';
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
    if ($load && '' != $located) {
        load_template($located, $require_once);
    }

    return $located;
}

function me_get_template_part($slug, $name = null) {
    /**
     * Fires before the specified template part file is loaded.
     *
     * The dynamic portion of the hook name, `$slug`, refers to the slug name
     * for the generic template part.
     *
     * @since 1.0.0
     *
     * @param string $slug The slug name for the generic template.
     * @param string $name The name of the specialized template.
     */
    do_action("me_get_template_part_{$slug}", $slug, $name);

    $templates = array();
    $name = (string) $name;
    if ('' !== $name) {
        $templates[] = "{$slug}-{$name}.php";
    }

    $templates[] = "{$slug}.php";

    me_locate_template($templates, true, false);
}

// TODO: can dat ham nay cho dung vi tri file
function me_get_page_permalink($page_name) {
    $page = get_page_by_path($page_name);
    if (!$page) {
        return;
    }
    return get_permalink($page->ID);
}

/**
 * Returns the url to the lost password endpoint url.
 *
 * @access public
 * @param  string $default_url
 * @return string
 */
function me_lostpassword_url($default_url = '') {
    $password_reset_url = me_get_page_permalink('reset-pass');

    if (false !== $password_reset_url) {
        return $password_reset_url;
    } else {
        return $default_url;
    }
}
// add_filter( 'lostpassword_url',  'me_lostpassword_url', 10, 1 );

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
function me_get_endpoint_url($endpoint, $value = '', $permalink = '') {
    if (!$permalink) {
        $permalink = get_permalink();
    }

    if (get_option('permalink_structure')) {
        if (strstr($permalink, '?')) {
            $query_string = '?' . parse_url($permalink, PHP_URL_QUERY);
            $permalink = current(explode('?', $permalink));
        } else {
            $query_string = '';
        }
        $url = trailingslashit($permalink) . $endpoint . '/' . $value . $query_string;
    } else {
        $url = add_query_arg($endpoint, $value, $permalink);
    }

    return apply_filters('marketengine_get_endpoint_url', $url, $endpoint, $value, $permalink);
}