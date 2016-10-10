<?php
function marketengine_get_list_of_page() {
    $args = array(
        'post_type' => 'page',
        'post_status' => 'publish'
    );

    $pages = get_pages( $args );
    $list_of_page = array();
    foreach($pages as $page){
        $list_of_page[$page->ID] = $page->post_title;
    }
    return $list_of_page;
}

function marketengine_option_view() {

    marketengine_option_header();
    //include 'option-view.php';
    $tabs = array(
        'general-settings'      => array(
            'title'    => __("General", "enginethemes"),
            'slug'     => 'general-settings',
            'template' => include (dirname(__FILE__). '/options/general.php')
        ),
        'authenticate-settings' => array(
            'title'    => __("Authentication", "enginethemes"),
            'slug'     => 'authenticate-settings',
            'template' => include (dirname(__FILE__). '/options/authentication.php'),
        ),
        'listings-settings' => array(
            'title'    => __("Listings", "enginethemes"),
            'slug'     => 'listings-settings',
            'template' => include (dirname(__FILE__). '/options/listings.php'),
        ),
        'me-payment' => array(
            'title'    => __("Payment", "enginethemes"),
            'slug'     => 'me-payment',
            'template' => include (dirname(__FILE__). '/options/payments.php'),
        ),
        'me-inquiry' => array(
            'title'    => __("Inquiry", "enginethemes"),
            'slug'     => 'me-inquiry',
            'template' => include (dirname(__FILE__). '/options/inquiry.php'),
        ),
    );
    echo '<div class="marketengine-tabs">';

    echo '<ul class="me-nav me-tabs-nav">';

    if (empty($_REQUEST['tab'])) {
        $requested_tab = 'general-settings';
    } else {
        $requested_tab = $_REQUEST['tab'];
    }

    foreach ($tabs as $key => $tab) {
        $class = '';
        // check is current tab
        if ($requested_tab == $key) {
            $class = 'class="active"';
        }
        echo '<li ' . $class . '><a href="?page=marketengine&tab=' . $tab['slug'] . '">' . $tab['title'] . '</a></li>';
    }
    echo '</ul>';
    echo '<div class="me-tabs-container">';

    $tab = new ME_Tab($tabs[$requested_tab]);
    $tab->render();

    echo '</div>';

    echo '</div>';
    marketengine_option_footer();
}

/**
 * Add marketengine admin menu
 */
function marketengine_option_menu() {
    add_menu_page(
        __("MarketEngine Dashboard", "enginethemes"),
        __("EngineThemes", "enginethemes"),
        'manage_options',
        'marketengine',
        'marketengine_option_view',
        '',
        null
    );
}
add_action('admin_menu', 'marketengine_option_menu');

function marketengine_load_admin_option_script_css() {
    if(!empty($_REQUEST['page']) && 'marketengine' == $_REQUEST['page']) {
        wp_register_style('marketengine-font-icon', ME_PLUGIN_URL . 'assets/admin/jquery.mCustomScrollbar.min.css', array(), '1.0');
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
        <span class="pull-right"><?php _e("Power by", "enginethemes");?> <a href="https://www.enginethemes.com/">EngineThemes</a></span>
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