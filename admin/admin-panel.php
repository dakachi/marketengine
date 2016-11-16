<?php
function marketengine_get_list_of_page() {
    $args = array(
        'post_type'   => 'page',
        'post_status' => 'publish',
    );

    $pages        = get_pages($args);
    $list_of_page = array();
    foreach ($pages as $page) {
        $list_of_page[$page->ID] = $page->post_title;
    }
    return $list_of_page;
}

function marketengine_option_view() {

    marketengine_option_header();
    //include 'option-view.php';
    $tabs = array(
        'marketplace-settings'  => array(
            'title'    => __("Marketplace", "enginethemes"),
            'slug'     => 'marketplace-settings',
            'template' => include (dirname(__FILE__) . '/options/marketplace.php'),
        ),
        'payment-gateways'      => array(
            'title'    => __("Payment Gateways", "enginethemes"),
            'slug'     => 'payment-gateways',
            'template' => include (dirname(__FILE__) . '/options/payment-gateways.php'),
        ),
        'pages-settings'     => array(
            'title'    => __("Pages", "enginethemes"),
            'slug'     => 'pages-settings',
            'template' => include (dirname(__FILE__) . '/options/pages.php'),
        )
    );

    /**
     * Filter admin settings table
     *
     * @param array $tabs The admin settings tabs
     * @since 1.0
     */
    $tabs = apply_filters('marketengine_settings_tab', $tabs);

    echo '<div class="marketengine-tabs">';

    echo '<ul class="me-nav me-tabs-nav">';

    if (empty($_REQUEST['tab'])) {
        $requested_tab = 'marketplace-settings';
    } else {
        $requested_tab = $_REQUEST['tab'];
    }

    foreach ($tabs as $key => $tab) {
        $class = '';
        // check is current tab
        if ($requested_tab == $key) {
            $class = 'class="active"';
        }
        echo '<li ' . $class . '><a href="?page=me-settings&tab=' . $tab['slug'] . '">' . $tab['title'] . '</a></li>';
    }
    echo '</ul>';
    echo '<div class="me-tabs-container">';

    $tab = new ME_Tab($tabs[$requested_tab]);
    $tab->render();

    echo '</div>';

    echo '</div>';
    marketengine_option_footer();
}

function marketengine_report_view() {
    marketengine_option_header();
    me_get_template('admin/overview', $_REQUEST);
    marketengine_option_footer();
}

/**
 * Add marketengine admin menu
 */
function marketengine_option_menu() {
    global $submenu;
    unset($submenu['edit.php?post_type=listing'][10]);
    // Hide link on listing page
    if (isset($_GET['post_type']) && $_GET['post_type'] == 'me_order') {
        echo '<style type="text/css">
            #favorite-actions, .add-new-h2, .page-title-action { display:none; }
        </style>';
    }

    if (isset($_GET['post_type']) && $_GET['post_type'] == 'listing') {
        echo '<style type="text/css">
            #favorite-actions, .add-new-h2, .page-title-action { display:none; }
            .sign {font-weight: bold;}
        </style>';
    }

    add_menu_page(
        __("MarketEngine Dashboard", "enginethemes"),
        __("MarketEngine", "enginethemes"),
        'manage_options',
        'marketengine',
        null,
        null,
        28
    );

    add_submenu_page(
        'marketengine',
        __("Reports", "enginethemes"),
        __("Reports", "enginethemes"),
        'manage_options',
        'me-reports',
        'marketengine_report_view'
    );

    add_submenu_page(
        'marketengine',
        __("Settings", "enginethemes"),
        __("Settings", "enginethemes"),
        'manage_options',
        'me-settings',
        'marketengine_option_view'
    );
}
add_action('admin_menu', 'marketengine_option_menu');

function marketengine_load_admin_option_script_css() {
    if (!empty($_REQUEST['page']) && (strpos($_REQUEST['page'], 'me') !== false)) {
        wp_register_style('scrollbar-css', ME_PLUGIN_URL . 'assets/admin/jquery.mCustomScrollbar.min.css', array(), '1.0');
        wp_enqueue_style('marketengine-font-icon', ME_PLUGIN_URL . 'assets/css/marketengine-font-icon.css', array(), '1.0');
        wp_enqueue_style('me-option-css', ME_PLUGIN_URL . 'assets/admin/marketengine-admin.css');

        wp_enqueue_script('backbone');
        wp_enqueue_script('jquery-scrollbar', ME_PLUGIN_URL . 'assets/admin/jquery.mCustomScrollbar.min.js', array('jquery'), '1.0', true);
        wp_enqueue_script('marketengine-option', ME_PLUGIN_URL . 'assets/admin/script-admin.js', array('jquery', 'jquery-scrollbar'), '1.0', true);
        wp_enqueue_script('option-view', ME_PLUGIN_URL . 'assets/admin/option-view.js', array('jquery', 'backbone', 'jquery-scrollbar'), '1.0', true);
        wp_localize_script(
            'backbone',
            'me_globals',
            array(
                'ajaxurl' => admin_url('admin-ajax.php'),
            )
        );
    }
    ?>
    <style type="text/css">
    .toplevel_page_marketengine, #menu-posts-listing {
        margin-top: 10px;
    }
    </style>
    <?php
}
add_action('admin_enqueue_scripts', 'marketengine_load_admin_option_script_css');

/**
 * Render marketengine admin option header
 * @since 1.0
 */
function marketengine_option_header() {
    ?>

<div class="marketengine-admin">
    <div class="me-header">
        <span class="pull-left"><?php _e("MARKETENGINE", "enginethemes");?></span>
        <span class="pull-right"><?php _e("Power by", "enginethemes");?><a href="https://www.enginethemes.com/"><i class="icon-me-logo"></i></a></span>
    </div>
    <div class="me-body">
<?php
}

/**
 * Render marketengine admin option footer
 * @since 1.0
 */
function marketengine_option_footer() {
    ?>
    </div>
</div>

<?php
}

function me_admin_menu_class() {
    global $menu;
    $menu[28][6] .= '-enginethemes-icon';
    // print_r($menu);
}
add_action( 'admin_menu', 'me_admin_menu_class', 10 );
