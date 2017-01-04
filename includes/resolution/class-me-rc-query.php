<?php
/**
 * MarketEngine Resolution Center Query
 *
 * @author EngineThemes
 * @package  Includes/Resolution
 * @category Class
 */
class ME_RC_Query
{
    /**
     * The single instance of the class.
     *
     * @var ME_RC_Query
     * @since 1.0
     */
    protected static $_instance = null;

    /**
     * Main ME_RC_Query Instance.
     *
     * Ensures only one instance of ME_RC_Query is loaded or can be loaded.
     *
     * @since 1.0
     * @static
     * @return ME_RC_Query - Main instance.
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
    }
    /**
     * ME_RC_Query Class contructor
     *
     * Initialize hooks to filter query, add enpoint, rewrite rules
     *
     * @since 1.0
     */
    public function __construct()
    {
        add_action('init', array($this, 'add_enpoint'));
        add_filter('query_vars', array($this, 'add_query_vars'));
    }

    /**
     * Add plugin supported enpoint
     * @since 1.0
     */
    public function add_enpoint()
    {
        $option_value = me_option('ep_resolution-center');
        if(!$option_value) {
            $option_value = 'resolution-center';
        }
        add_rewrite_endpoint($option_value, EP_ROOT | EP_PAGES, 'resolution-center');


        $this->rewrite_user_account_url();
    }

    /**
     * Rewrite user account url rule
     * @since 1.0
     */
    private function rewrite_user_account_url()
    {
        $endpoint = 'resolution-center';
        add_rewrite_rule('^(.?.+?)/' . me_get_endpoint_name($endpoint) . '/page/?([0-9]{1,})/?$', 'index.php?pagename=$matches[1]&paged=$matches[2]&' . $endpoint, 'top');
    }

    /**
     * Add query order-id, keyword
     * 
     * @param array $vars WP query var list
     * @since 1.0
     */
    public function add_query_vars($vars)
    {
        $vars[] = 'resolution-center';

        return $vars;
    }
}
