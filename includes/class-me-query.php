<?php
add_action('init', 'me_init');
function me_init() {
    add_rewrite_endpoint('forgot-password', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('reset-password', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('register', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('edit-profile', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('change-password', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('listings', EP_ROOT | EP_PAGES);
}

// add_filter('query_vars', 'me_add_query_vars');
// function me_add_query_vars($vars) {
//     $vars[] = 'forgot-pass';
//     return $vars;
// }

// todo: query listing order by date, rating, price
// todo: filter listing by price
// todo: filter listing by listing type
