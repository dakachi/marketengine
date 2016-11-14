<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class ME_Setup_Wizard
{	
	private $step;
    /**
     * Hook in tabs.
     */
    public function __construct()
    {

        add_action('admin_menu', array($this, 'admin_menus'));
        add_action('admin_init', array($this, 'setup_wizard'));

    }

    public function admin_menus()
    {
        add_dashboard_page(
            '',
            '',
            'manage_options',
            'marketengine-setup',
            ''
        );
    }

    public function setup_wizard()
    {
    	if ( empty( $_GET['page'] ) || 'marketengine-setup' !== $_GET['page'] ) {
			return;
		}
		$this->setup_wizard_header();
		$this->setup_wizard_footer();
    }

    /**
	 * Setup Wizard Header.
	 */
	public function setup_wizard_header() {
		?>
		<!DOCTYPE html>
		<html <?php language_attributes(); ?>>
		<head>
			<meta name="viewport" content="width=device-width" />
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title><?php _e( 'MarketEngine &rsaquo; Setup Wizard', 'enginethemes' ); ?></title>
			<?php do_action( 'admin_print_styles' ); ?>
			<?php do_action( 'admin_head' ); ?>
		</head>
		<body class="wc-setup wp-core-ui">
		qwieqwop 
		<?php
	}

	/**
	 * Setup Wizard Footer.
	 */
	public function setup_wizard_footer() {
		?>
			<?php if ( 'next_steps' === $this->step ) : ?>
				<a class="wc-return-to-dashboard" href="<?php echo esc_url( admin_url() ); ?>"><?php _e( 'Return to the WordPress Dashboard', 'enginethemes' ); ?></a>
			<?php endif; ?>
			</body>
		</html>
		<?php
		exit;
	}

    public function instro()
    {
        echo 1;
    }

    public function setup_page() {

    }

    public function personalize() {

    }

    public function more_settings() {

    }

    public function ready() {
    	
    }

}

new ME_Setup_Wizard();
