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
		wp_localize_script( 
			'setup-wizard.js', 
			'me_globals', 
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'reload_notice' => __("Data will be lost if you leave the page, are you sure?", "enginethemes")
			) 
		);
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
    		<?php wp_nonce_field( 'marketengine-setup' ); ?>
			<!-- Overview -->
			<div class="me-setup-container me-setup-overview active" data-step="0">
				<h2><?php _e("Welcome!", "enginethemes"); ?></h2>
				<p><?php _e("Thank you for choosing MarketEngine to build your marketplace!", "enginethemes"); ?></p>
				<br/>
				<p><?php _e("If this is your first time using MarketEngine, you can get started by using this quick setup wizard. It usually takes less than five minutes. You can also skip any steps and get back to them later in the settings area.", "enginethemes"); ?></p>
				<div class="me-setup-control">
					<a href="<?php echo esc_url( admin_url() ); ?>" class="me-sbeak-btn"><?php _e("ANOTHER TIME", "enginethemes"); ?></a>
					<a href="#page" class="me-scontinue-btn wizard-start"><?php _e("START NOW", "enginethemes"); ?></a>
				</div>
			</div>
			<!-- Page setup -->
			<div class="me-setup-container me-setup-page" id="page" data-step="1">
				<form>
					<h2><?php _e("Page Setup", "enginethemes"); ?></h2>
					<p><?php _e("To run your marketplace properly, MarketEngine needs to create some specific pages. This step will automatically generate these needed pages if they don,t exist:", "enginethemes"); ?></p>
					<div class="me-spage-group">
						<h3><?php _e("Account", "enginethemes"); ?></h3>
						<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy </p>
					</div>
					<div class="me-spage-group">
						<h3><?php _e("Listing", "enginethemes"); ?></h3>
						<p>consectetuer adipiscing elit, sed diam nonummy consectetuer adipiscing elit, sed diam nonummy Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy </p>
					</div>
					<div class="me-spage-group">
						<h3><?php _e("Payment Flow", "enginethemes"); ?></h3>
						<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy </p>
					</div>
					<div class="me-spage-group">
						<h3><?php _e("Inquiry", "enginethemes"); ?></h3>
						<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy </p>
					</div>
					<div class="me-setup-control">
						<a href="#intro" class="me-sprevious-btn me-skip-btn"><?php _e("Skip this step", "enginethemes"); ?></a>
						<a href="#page" class="me-scontinue-btn me-next"><?php _e("CONTINUE", "enginethemes"); ?></a>
					</div>
					<input type="hidden" name="step" value="page" />

				</form>
			</div>
			<!-- Personalize -->
			<div class="me-setup-container me-setup-personalize" id="personalize" data-step="2">
				<form>
					<h2><?php _e("Personalize", "enginethemes"); ?></h2>
					<div class="me-sfield-group">
						<label for="me-setup-listing"><?php _e("1- How should people understand “listings” in your marketplace?", "enginethemes"); ?></label>
						<input id="me-setup-listing" type="text" name="listing_label">
					</div>
					<div class="me-sfield-group">
						<label for="me-setup-seller"><?php _e("2- What should we call the Seller role in your marketplace?", "enginethemes"); ?></label>
						<input id="me-setup-seller" type="text" name="seller_label">
					</div>
					<div class="me-sfield-group">
						<label for="me-setup-buyer"><?php _e("3- What should we call the Buyer role in your marketplace?", "enginethemes"); ?></label>
						<input id="me-setup-buyer" type="text" name="buyer_label">
					</div>
					<div class="me-setup-control">
						<a href="#payment" class="me-sprevious-btn me-skip-btn"><?php _e("Skip this step", "enginethemes"); ?></a>
						<a href="#payment" class="me-scontinue-btn me-next"><?php _e("CONTINUE", "enginethemes"); ?></a>
					</div>
					<input type="hidden" name="step" value="personalize" />
				</form>
			</div>

			<!-- More Settings -->
			<div class="me-setup-container me-setup-more-settings" id="payment" data-step="3">
				<form>
					<h2><?php _e("More Settings", "enginethemes"); ?></h2>
					<div class="me-sfield-group">
						<label for=""><?php _e("1- Create some listing categories for your marketplace", "enginethemes"); ?></label>
						<input type="text" name="cat[]"> <span class="me-setup-add-cat"><i class="icon-me-add"></i><?php _e("Add more", "enginethemes"); ?></span>
						<div class="more-cat" style="display:none">
							<input type="text" name="cat[]" /> <input type="text" name="cat[]" /><small><?php _e("More categories can be added later in MarketEngine settings", "enginethemes"); ?></small>
						</div>
					</div>
					<div class="me-sfield-group">
						<label for=""><?php _e("2- What is your commission fee ?", "enginethemes"); ?></label>
						<input id="me-setup-commission" name="commission" type="number">
						<span>%</span>
					</div>
					<div class="me-sfield-group">
						<label for="">3- Define the currency in your marketplace ?</label>
						<select name="currency" id="">
							<option value="usd">US Dollar ($) (USD)</option>
							<option value="aud">Australian Dollar ($) (AUD)</option>
							<option value="eur">Euro (EUR) (EUR)</option>
						</select>
					</div>
					<div class="me-setup-control">
						<a href="#finish" class="me-sprevious-btn me-skip-btn"><?php _e("Skip this step", "enginethemes"); ?></a>
						<a href="#finish" class="me-scontinue-btn me-next"><?php _e("CONTINUE", "enginethemes"); ?></a>
					</div>
					<input type="hidden" name="step" value="payment" />
				</form>
			</div>
			<!-- That's it -->
			<div class="me-setup-container me-setup-that-it" id="finish" data-step="4">
				<div class="me-setup-wrap">
					<h2><?php _e("That's It", "enginethemes"); ?></h2>
					<p><?php _e("Congragulations! You have successfully made some steps on building your marketplace.", "enginethemes"); ?><br/><?php _e("What's next?", "enginethemes"); ?></p>
				</div>
				<div class="me-setup-wrap">
					<form>
						<h3><?php _e("Sample Data", "enginethemes"); ?></h3>
						<div class="me-setup-sample">
							<p><?php _e("You can add some sample data to grasp some clearer ideas of how your marketplace will look like.<br/>4 sample listings will be generated in each of your categories, together with a few users &amp; orders to demonstrate the checkout flows.<br/>You will be able to remove those samples with another click later.", "enginethemes"); ?></p>
							<label class="me-setup-data-btn" id="me-add-sample-data" for="me-setup-sample-data">
								<span id="me-setup-sample-data"><?php _e("ADD SAMPLE DATA", "enginethemes"); ?></span>
							</label>
						</div>
						<div class="me-setup-sample-finish">
							<p><?php _e("Few users, orders and 4 sample listings have already been generated in each of your categories.", "enginethemes"); ?></p>
							<p><?php _e("You will be able to remove those samples with another click later.", "enginethemes"); ?></p>
						</div>
					</form>
				</div>

				<div class="me-setup-wrap">
					<h3><?php _e("Mailing List", "enginethemes"); ?></h3>
					<div class="me-setup-mailing">
						<p><?php _e("Join the mailing list to get latest news, tips &amp; updates about the plugin.", "enginethemes"); ?></p>
							<form id="me-setup-mailing-form" action="">
								<div class="me-smail-control">
									<label for="me-smail-name"><?php _e("Name", "enginethemes"); ?></label>
									<input id="me-smail-name" type="text">
								</div>
								<div class="me-smail-control">
									<label for="me-smail-email"><?php _e("Email address", "enginethemes"); ?></label>
									<input id="me-smail-email" type="text">
								</div>
								<input class="me-smail-submit-btn" type="submit" value="SUBMIT">
							</form>
					</div>
					<div class="me-setup-mailing-finish">
						<p><?php _e("Thank you for joining the mailing list.", "enginethemes"); ?></p>
					</div>
				</div>
				<div class="me-setup-wrap">
					<div class="me-setup-control">
						<a href="" class="me-sfinish-btn"><?php _e("FINISH", "enginethemes"); ?></a>
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
}
new ME_Setup_Wizard();