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

		wp_register_script('setup-wizard.js', ME_PLUGIN_URL . 'assets/admin/setup-wizard.js', array('jquery'));

		$this->setup_wizard_header();
		$this->instro();
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
			<?php 
				wp_print_scripts('setup-wizard.js');
				wp_enqueue_style('setup-wizard.css', ME_PLUGIN_URL . 'assets/admin/setup-wizard.css');
			 ?>
			<?php do_action( 'admin_print_styles' ); ?>
			<?php do_action( 'admin_head' ); ?>
			
		</head>
		<body class="wc-setup wp-core-ui">
		<div class="marketengine-setup-wrap" class="marketengine">
			<div class="marketengine-setup">
				<div class="me-setup-title">
					<h1><span>Market</span><span>Engine</span></h1>
				</div>
				<div class="me-setup-line">
					<div class="me-setup-line-step active">
						<span class="me-ss-title"><?php _e("Overview", "enginethemes"); ?></span>
						<span class="me-ss-point"></span>
					</div>
					<div class="me-setup-line-step">
						<span class="me-ss-title"><?php _e("Page Setup", "enginethemes"); ?></span>
						<span class="me-ss-point"></span>
					</div>
					<div class="me-setup-line-step">
						<span class="me-ss-title"><?php _e("Personalize", "enginethemes"); ?></span>
						<span class="me-ss-point"></span>
					</div>
					<div class="me-setup-line-step">
						<span class="me-ss-title"><?php _e("More Settings", "enginethemes"); ?></span>
						<span class="me-ss-point"></span>
					</div>
					<div class="me-setup-line-step">
						<span class="me-ss-title"><?php _e("That's it!", "enginethemes"); ?></span>
						<span class="me-ss-point"></span>
					</div>
				</div>
		<?php
	}

	/**
	 * Setup Wizard Footer.
	 */
	public function setup_wizard_footer() {
		?>
					<div class="me-setup-footer">
						<a href="<?php echo esc_url( admin_url() ); ?>"><?php _e( 'Return to the WordPress Dashboard', 'enginethemes' ); ?></a>
					</div>
				</div>
			</div>
			</body>
		</html>
		<?php
		exit;
	}

    public function instro()
    {
    ?>
    	<div class="me-setup-section">
			<!-- Overview -->
			<div class="me-setup-container me-setup-overview active" data-step="0">
				<h2><?php _e("Welcome!", "enginethemes"); ?></h2>
				<p><?php _e("Thank you for choosing MarketEngine to build your marketplace!", "enginethemes"); ?></p>
				<br/>
				<p><?php _e("If this is your first time using MarketEngine, you can get started by using this quick setup wizard. It usually takes less than five minutes. You can also skip any steps and get back to them later in the settings area.", "enginethemes"); ?></p>
				<div class="me-setup-control">
					<a href="" class="me-sbeak-btn"><?php _e("ANOTHER TIME", "enginethemes"); ?></a>
					<a href="" class="me-scontinue-btn wizard-start"><?php _e("START NOW", "enginethemes"); ?></a>
				</div>
			</div>
			<!-- Page setup -->
			<div class="me-setup-container me-setup-page" data-step="1">
				<h2><?php _e("Page Setup", "enginethemes"); ?></h2>
				<p><?php _e("To run your marketplace properly, MarketEngine needs to create some specific pages. This step will automatically generate these needed pages if they don,t exist:", "enginethemes"); ?></p>
				<div class="me-spage-group">
					<h3>Listing page</h3>
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy </p>
				</div>
				<div class="me-spage-group">
					<h3>Post a listing</h3>
					<p>consectetuer adipiscing elit, sed diam nonummy consectetuer adipiscing elit, sed diam nonummy Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy </p>
				</div>
				<div class="me-spage-group">
					<h3>Check out page</h3>
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy </p>
				</div>
				<div class="me-setup-control">
					<a href="" class="me-sprevious-btn">PREVIOUS</a>
					<a href="" class="me-scontinue-btn">CONTINUE</a>
				</div>
			</div>
			<!-- Personalize -->
			<div class="me-setup-container me-setup-personalize" data-step="2">
				<h2>Personalize</h2>
				<div class="me-sfield-group">
					<label for="me-setup-listing">1- How should people understand “listings” in your marketplace?</label>
					<input id="me-setup-listing" type="text">
				</div>
				<div class="me-sfield-group">
					<label for="me-setup-seller">2- What should we call the Seller role in your marketplace?</label>
					<input id="me-setup-seller" type="text">
				</div>
				<div class="me-sfield-group">
					<label for="me-setup-buyer">3- What should we call the Buyer role in your marketplace?</label>
					<input id="me-setup-buyer" type="text">
				</div>
				<div class="me-setup-control">
					<a href="" class="me-sprevious-btn">PREVIOUS</a>
					<a href="" class="me-scontinue-btn">CONTINUE</a>
				</div>
			</div>

			<!-- More Settings -->
			<div class="me-setup-container me-setup-more-settings" data-step="3">
				<h2>More Settings</h2>
				<div class="me-sfield-group">
					<label for="">1- Create some listing categories for your marketplace</label>
					<input type="text"> <span class="me-setup-add-cat"><i class="icon-me-add"></i>Add more</span>
				</div>
				<div class="me-sfield-group">
					<label for="">2- What is your commission fee ?</label>
					<input id="me-setup-commission" type="number">
					<span>%</span>
				</div>
				<div class="me-sfield-group">
					<label for="">3- Define the currency in your marketplace ?</label>
					<select name="" id="">
						<option value="">US Dollar ($) (USD)</option>
						<option value="">Australian Dollar ($) (AUD)</option>
					</select>
				</div>
				<div class="me-setup-control">
					<a href="" class="me-sprevious-btn">PREVIOUS</a>
					<a href="" class="me-scontinue-btn">CONTINUE</a>
				</div>
			</div>
			<!-- That's it -->
			<div class="me-setup-container me-setup-that-it" data-step="4">
				<div class="me-setup-wrap">
					<h2>That's It</h2>
					<p>Congragulations! You have successfully made some steps on building your marketplace.<br/>What's next?</p>
				</div>
				<div class="me-setup-wrap">
					<h3>Sample Data</h3>
					<div class="me-setup-sample">
						<p>You can add some sample data to grasp some clearer ideas of how your marketplace will look like.<br/>4 sample listings will be generated in each of your categories, together with a few users &amp; orders to demonstrate the checkout flows.<br/>You will be able to remove those samples with another click later.</p>
						<label class="me-setup-data-btn" for="me-setup-sample-data">
							<span>ADD SAMPLE DATA</span>
							<input id="me-setup-sample-data" type="file">
						</label>
					</div>
					<div class="me-setup-sample-finish">
						<p>Few users, orders and 4 sample listings have already been generated in each of your categories.</p>
						<p>You will be able to remove those samples with another click later.</p>
					</div>
				</div>

				<div class="me-setup-wrap">
					<h3>Mailing List</h3>
					<div class="me-setup-mailing">
						<p>Join the mailing list to get latest news, tips &amp; updates about the plugin.</p>
							<form id="me-setup-mailing-form" action="">
								<div class="me-smail-control">
									<label for="me-smail-name">Name</label>
									<input id="me-smail-name" type="text">
								</div>
								<div class="me-smail-control">
									<label for="me-smail-email">Email address</label>
									<input id="me-smail-email" type="text">
								</div>
								<input class="me-smail-submit-btn" type="submit" value="SUBMIT">
							</form>
					</div>
					<div class="me-setup-mailing-finish">
						<p>Thank you for joining the mailing list.</p>
					</div>
				</div>
				<div class="me-setup-wrap">
					<h3>Review</h3>
					<p>Lastly, if you enjoy the process, we would be super excited if you leave your review here.</p>
					<textarea name="" id=""></textarea>
				</div>
				<div class="me-setup-wrap">
					<div class="me-setup-control">
						<a href="" class="me-sprevious-btn">PREVIOUS</a>
						<a href="" class="me-sfinish-btn">FINISH</a>
					</div>
				</div>
			</div>
			<div class="me-setup-overlay">
				<div class="me-setup-overlay-container"></div>
				<div class="me-setup-overlay-loading">
					<div class="s1">
						<div class="s b sb1"></div>
						<div class="s b sb2"></div>
						<div class="s b sb3"></div>
						<div class="s b sb4"></div>
				    </div>
				    <div class="s2">
						<div class="s b sb5"></div>
						<div class="s b sb6"></div>
						<div class="s b sb7"></div>
						<div class="s b sb8"></div>
				    </div>
				    <div class="bigcon">
				      <!-- <div class="big b"></div> -->
				    </div>
				</div>
			</div>
		</div>
    <?php 
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
