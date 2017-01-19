<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class ME_Case_List extends WP_List_Table
{

    /** Class constructor */
    public function __construct()
    {

        parent::__construct(array(
            'singular' => __('Case', 'enginethemes'), //singular name of the listed records
            'plural'   => __('Cases', 'enginethemes'), //plural name of the listed records
            'ajax'     => false, //does this table support ajax?
        ));

    }

    /**
     * Retrieve cases data from the database
     *
     * @param int $per_page
     * @param int $page_number
     *
     * @return mixed
     */
    public static function get_cases($per_page = 20, $page_number = 1)
    {

        global $wpdb;

        $sql = "SELECT * FROM {$wpdb->prefix}marketengine_message_item WHERE post_type = 'dispute'";

        if (!empty($_REQUEST['orderby'])) {
            $sql .= ' ORDER BY ' . esc_sql($_REQUEST['orderby']);
            $sql .= !empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
        }

        $sql .= " LIMIT $per_page";
        $sql .= ' OFFSET ' . ($page_number - 1) * $per_page;

        $result = $wpdb->get_results($sql, 'ARRAY_A');

        return $result;
    }

    /**
     * Delete a case record.
     *
     * @param int $id case ID
     */
    public static function delete_case($id)
    {
        global $wpdb;

        $wpdb->delete(
            "{$wpdb->prefix}marketengine_message_item",
            array('ID' => $id),
            array('%d')
        );
    }

    /**
     * Returns the count of records in the database.
     *
     * @return null|string
     */
    public static function record_count()
    {
        global $wpdb;

        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}marketengine_message_item WHERE post_type = 'dispute'";

        return $wpdb->get_var($sql);
    }

    /** Text displayed when no customer data is available */
    public function no_items()
    {
        _e('No cases avaliable.', 'enginethemes');
    }

    /**
     * Render a column when no column specific method exist.
     *
     * @param array $item
     * @param string $column_name
     *
     * @return mixed
     */
    public function column_default($item, $column_name)
    {
        $item_detail = '';
        $item_detail .= '<tr class="me-case-detail" id="case-'. $item['ID'] .'">'; 
        $item_detail .= '<th class="check-column"></th>';
        $item_detail .= '<td colspan="4">'. $this->table_detail_case($item) .'</td>';
        $item_detail .= '</tr>';

        switch ($column_name) {
            case 'case':
	            $case_link = '<a href="'. me_rc_dispute_link($item['ID']) . '">#' .$item['ID'] .'</a>';
	            $author_link  = '<a href="' . get_author_posts_url( $item['sender'] ) . '">' . get_the_author_meta( 'display_name', $item['sender'] ) . '</a>';
	            printf(__("%s by %s", "enginethemes"), $case_link, $author_link);
	            break;
            case 'status':
                echo me_dispute_status_label($item['post_status']);
                break;
            case 'date' :
             	echo date_i18n( get_option( 'date_format' ), strtotime($item['post_date']) );
             	break;
            case 'actions' :
            	echo '<span class="me-action-case" data-case-id="case-'. $item['ID'] .'"><i class="icon-me-eye"></i><i class="icon-me-eye-slash"></i></span>' . $item_detail;
            	?>
            	<?php 
            	break;
            case 'issue' :
            	echo '<span>' .__("Dispute Order", "enginethemes"). '</span>';
            	break;
        }
    }

    /**
     *
     * @param array $item
     * @param string $column_name
     *
     * @return mixed
     */
    public function table_detail_case($item) {
        $tb = '<table class="me-table-case-detail">';
        $tb .= '<tr>';
        $tb .= '<td class="me-td-case-detail">Open date:</td>';
        $tb .= '<td>'. date_i18n( get_option( 'date_format' ), strtotime($item['post_date']) ) .'</td>';
        $tb .= '</tr>';
        $tb .= '<tr>'; 
        $tb .= '<td class="me-td-case-detail">Opened By:</td>';
        $tb .= '<td>'. get_the_author_meta( 'display_name', $item['sender'] ) .'</td>';
        $tb .= '</tr>';
        $tb .= '<tr>'; 
        $tb .= '<td class="me-td-case-detail">Listing:</td>';
        $tb .= '<td>'. get_the_author_meta( 'display_name', $item['sender'] ) .'</td>';
        $tb .= '</tr>';
        $tb .= '<tr>'; 
        $tb .= '<td class="me-td-case-detail">Problem:</td>';
        $tb .= '<td>'. get_the_author_meta( 'display_name', $item['sender'] ) .'</td>';
        $tb .= '</tr>';
        $tb .= '<tr>'; 
        $tb .= '<td class="me-td-case-detail">Buyer wants to:</td>';
        $tb .= '<td>'. get_the_author_meta( 'display_name', $item['sender'] ) .'</td>';
        $tb .= '</tr>';
        $tb .= '<tr>'; 
        $tb .= '<td class="me-td-case-detail">Order ID:</td>';
        $tb .= '<td>'. get_the_author_meta( 'display_name', $item['sender'] ) .'</td>';
        $tb .= '</tr>';
        $tb .= '<tr>'; 
        $tb .= '<td class="me-td-case-detail">Total amount:</td>';
        $tb .= '<td>'. get_the_author_meta( 'display_name', $item['sender'] ) .'</td>';
        $tb .= '</tr>';
        $tb .= '<tr>'; 
        $tb .= '<td class="me-td-case-detail">Order date:</td>';
        $tb .= '<td>'. get_the_author_meta( 'display_name', $item['sender'] ) .'</td>';
        $tb .= '</tr>';
        $tb .= '<tr>'; 
        $tb .= '<td class="me-td-case-detail">Related party:</td>';
        $tb .= '<td>'. get_the_author_meta( 'display_name', $item['sender'] ) .'</td>';
        $tb .= '</tr>';
        $tb .= '</table>';
        return $tb;
    }

    /**
     * Render the bulk edit checkbox
     *
     * @param array $item
     *
     * @return string
     */
    public function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['ID']
        );
    }

    /**
     * Method for name column
     *
     * @param array $item an array of DB data
     *
     * @return string
     */
    public function column_name($item)
    {

        $delete_nonce = wp_create_nonce('me_delete_case');

        $title = '<strong>' . $item['name'] . '</strong>';

        $actions = [
            'delete' => sprintf('<a href="?page=%s&action=%s&customer=%s&_wpnonce=%s">Delete</a>', esc_attr($_REQUEST['page']), 'delete', absint($item['ID']), $delete_nonce),
        ];

        return $title . $this->row_actions($actions);
    }

    /**
     *  Associative array of columns
     *
     * @return array
     */
    public function get_columns()
    {
        $columns = array(
            'cb'      => '<input type="checkbox" />',
            'status'    => __("Status", "enginethemes"),
            'case' => __("Case", "enginethemes"),
            //'issue' => __("Issue", "enginethemes"),
            'date' => __("Date", "enginethemes"),
            'actions' => __("Actions", "enginethemes")
        );

        return $columns;
    }

    /**
     * Columns to make sortable.
     *
     * @return array
     */
    public function get_sortable_columns()
    {
        $sortable_columns = array(
            'date' => array('post_date', false),
        );

        return $sortable_columns;
    }

    /**
     * Returns an associative array containing the bulk action
     *
     * @return array
     */
    public function get_bulk_actions()
    {
        $actions = array(
            'bulk-delete' => __("Delete", "enginethemes"),
        );

        return $actions;
    }

    /**
     * Handles data query and filter, sorting, and pagination.
     */
    public function prepare_items()
    {

        $this->_column_headers = $this->get_column_info();

        /** Process bulk action */
        $this->process_bulk_action();

        $per_page     = $this->get_items_per_page('cases_per_page', 20);
        $current_page = $this->get_pagenum();
        $total_items  = self::record_count();

        $this->set_pagination_args(array(
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page'    => $per_page, //WE have to determine how many items to show on a page
        ));

        $this->items = self::get_cases($per_page, $current_page);
    }

    public function process_bulk_action()
    {

        //Detect when a bulk action is being triggered...
        if ('delete' === $this->current_action()) {

            // In our file that handles the request, verify the nonce.
            $nonce = esc_attr($_REQUEST['_wpnonce']);

            if (!wp_verify_nonce($nonce, 'me_delete_case')) {
                die('Go get a life script kiddies');
            } else {
                self::delete_case(absint($_GET['customer']));

                // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
                // add_query_arg() return the current url
                wp_redirect(esc_url_raw(add_query_arg()));
                exit;
            }

        }

        // If the delete bulk action is triggered
        if ((isset($_POST['action']) && $_POST['action'] == 'bulk-delete')
            || (isset($_POST['action2']) && $_POST['action2'] == 'bulk-delete')
        ) {

            $delete_ids = esc_sql($_POST['bulk-delete']);

            // loop over the array of record IDs and delete them
            foreach ($delete_ids as $id) {
                self::delete_case($id);
            }

            // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
            // add_query_arg() return the current url
            wp_redirect(esc_url_raw(add_query_arg()));
            exit;
        }
    }

    protected function get_views() { 
	    $status_links = array(
	        "all"       => __("<a href='#'>All</a>",'enginethemes'),
	        "published" => __("<a href='#'>Published</a>",'enginethemes'),
	        "trashed"   => __("<a href='#'>Trashed</a>",'enginethemes')
	    );
	    return $status_links;
	}
}

class ME_Case_Screen
{

    // class instance
    static $instance;

    // case WP_List_Table object
    public $cases_obj;

    // class constructor
    public function __construct()
    {
        add_filter('set-screen-option', array(__CLASS__, 'set_screen'), 10, 3);
        add_action('admin_menu', array($this, 'plugin_menu'));
    }

    public static function set_screen($status, $option, $value)
    {
        return $value;
    }

    public function plugin_menu()
    {

        $hook = add_submenu_page(
            'marketengine',
            __("Cases", "enginethemes"),
            __("Cases", "enginethemes"),
            'manage_options',
            'me-dispute-cases',
            array($this, 'plugin_settings_page')
        );

        add_action("load-$hook", array($this, 'screen_option'));

    }

    /**
     * Screen options
     */
    public function screen_option()
    {

        $option = 'per_page';
        $args   = array(
            'label'   => __("Cases", "enginethemes"),
            'default' => 20,
            'option'  => 'cases_per_page',
        );

        add_screen_option($option, $args);

        $this->cases_obj = new ME_Case_List();
    }

    /**
     * Plugin settings page
     */
    public function plugin_settings_page()
    {
        ?>
			<div class="wrap">
				<h2><?php _e("Cases", "enginethemes")?></h2>
				
				<?php $this->cases_obj->views(); ?>
				<form method="post">
					<?php
						$this->cases_obj->prepare_items();
        				$this->cases_obj->display();
					?>
				</form>
							
					
			</div>
		<?php
	}

    /** Singleton instance */
    public static function get_instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}

add_action('plugins_loaded', function () {
    ME_Case_Screen::get_instance();
});
