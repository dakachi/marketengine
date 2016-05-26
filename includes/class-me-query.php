<?php
add_action('init', 'me_init');
function me_init() {
    add_rewrite_endpoint('forgot-password', EP_ROOT | EP_PAGES);
}

// add_filter('query_vars', 'me_add_query_vars');
// function me_add_query_vars($vars) {
//     $vars[] = 'forgot-pass';
//     return $vars;
// }