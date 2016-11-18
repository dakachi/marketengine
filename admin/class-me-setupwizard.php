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

    	add_action( 'admin_notices', array( $this, 'notices' ) );

        add_action('admin_menu', array($this, 'admin_menus'));
        add_action('admin_init', array($this, 'setup_wizard'));

        add_action('wp_ajax_me-do-setup', array($this, 'handle_setup'));
        add_action('wp_ajax_me-add-sample-data', array($this, 'add_sample_data'));

    }

    public function notices() {
    	if(!me_option('finish_wizard')) {
    		$skip_setup_nonce = wp_create_nonce('skip_setup_wizard');
    	?>
		<div id="message" class="updated marketengine-message me-setup-notices">
			<p>Welcome to <strong>MarketEngine</strong>  – You‘re almost ready to start your market :)</p>
			<a href="<?php echo admin_url("?page=marketengine-setup") ?>" class="run-setup"><?php _e("Run the setup wizard", "enginethemes"); ?></a>
			<a href="<?php echo admin_url("?skip-setup=1&nonce=".$skip_setup_nonce) ?>" class="skip-setup"><?php _e("Skip setup", "enginethemes"); ?></a>
		</div>
    	<?php 
    	} 
    }

    public function handle_setup()
    {
        if (!empty($_POST['step']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'marketengine-setup')) {
            
            switch ($_POST['step']) {
                case 'page':
                    $this->setup_page($_POST['content']);
                    break;
                case 'personalize':
                    $this->setup_personalize($_POST['content']);
                    break;
                case 'payment':
                    $this->setup_payment($_POST['content']);
                    break;
                default:
                    break;
            }

            wp_send_json(array('success' => true, 'step' => $_POST['step']));

        } else {
            wp_send_json(array('success' => false, 'msg' => __("Permission denied.", "enginethemes")));
        }
    }

    public function setup_page($content) {
    	me_create_functional_pages();
    }

    public function setup_personalize($content) {
    	parse_str($content);
    	me_update_option('listing-label', $listing_label);
    	me_update_option('seller-label', $seller_label);
    	me_update_option('buyer-label', $buyer_label);
    }

    public function setup_payment($content) {
    	parse_str($content);
		$currencies = $this->get_currency_list();

		if(!empty($cats)) {
    		foreach ($cats as $cat) {
    			if($cat) {
    				wp_insert_term( $cat, 'listing_category' );
    			}
    		}
    	}

    	if(!empty($commission) && is_numeric($commission)) {
    		me_update_option('paypal-commission-fee', absint( $commission ));
    	}

    	$currency = $currencies[$currency];
    	me_update_option('payment-currency-code', $currency['code']);
    	me_update_option('payment-currency-sign', $currency['sign']);
    	me_update_option('payment-currency-label', $currency['label']);
		
    }

    private function get_currency_list() {
    	$currencies = array(
			'usd' => array('label' => 'U.S. Dollar', 'code' => 'USD', 'sign' => '$'),
			'aud' => array('label' => 'Australian Dollar', 'code' => 'AUD', 'sign' => '$'),
			'cad' => array('label' => 'Canadian Dollar', 'code' => 'CAD', 'sign' => '$'),
			'eur' => array('label' => 'Euro', 'code' => 'EUR', 'sign' => '€'),
			'sgd' => array('label' => 'Singapore Dollar', 'code' => 'SGD', 'sign' => '$'),
		);
		return $currencies;
    }

    public function add_sample_data() {
    	if(!empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'marketengine-setup')) {
    		update_option( 'me-added-sample-data', 1 );
    		marketengine_add_sample_listing();
    	}
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
        
        if(!empty($_GET['skip-setup']) && !empty($_GET['nonce']) && wp_verify_nonce($_GET['nonce'], 'skip_setup_wizard')) {
        	me_update_option('finish_wizard', 1);
        }

        if (empty($_GET['page']) || 'marketengine-setup' !== $_GET['page']) {
            return;
        }

        wp_register_script('setup-wizard.js', ME_PLUGIN_URL . 'assets/admin/setup-wizard.js', array('jquery'));
        wp_localize_script(
            'setup-wizard.js',
            'me_globals',
            array(
                'ajaxurl'       => admin_url('admin-ajax.php'),
                'reload_notice' => __("Data will be lost if you leave the page, are you sure?", "enginethemes"),
            )
        );
        $this->header();
        $this->body();
        $this->footer();
    }

    /**
     * Setup Wizard Header.
     */
    public function header()
    {
        ?>
		<!DOCTYPE html>
		<html <?php language_attributes();?>>
		<head>
			<meta name="viewport" content="width=device-width" />
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title><?php _e('MarketEngine &rsaquo; Setup Wizard', 'enginethemes');?></title>
			<?php
				wp_print_scripts('setup-wizard.js');
        		wp_enqueue_style('setup-wizard.css', ME_PLUGIN_URL . 'assets/admin/setup-wizard.css');
        	?>
			<?php do_action('admin_print_styles');?>
			<?php do_action('admin_head');?>

		</head>
		<body class="wc-setup wp-core-ui">
		<div class="marketengine-setup-wrap" class="marketengine">
			<div class="marketengine-setup">
				<div class="me-setup-title">
					<h1><span>Market</span><span>Engine</span></h1>
				</div>
				<div class="me-setup-line">
					<div class="me-setup-line-step active">
						<span class="me-ss-title"><?php _e("Overview", "enginethemes");?></span>
						<span class="me-ss-point"></span>
					</div>
					<div class="me-setup-line-step">
						<span class="me-ss-title"><?php _e("Page Setup", "enginethemes");?></span>
						<span class="me-ss-point"></span>
					</div>
					<div class="me-setup-line-step">
						<span class="me-ss-title"><?php _e("Personalize", "enginethemes");?></span>
						<span class="me-ss-point"></span>
					</div>
					<div class="me-setup-line-step">
						<span class="me-ss-title"><?php _e("More Settings", "enginethemes");?></span>
						<span class="me-ss-point"></span>
					</div>
					<div class="me-setup-line-step">
						<span class="me-ss-title"><?php _e("That's it!", "enginethemes");?></span>
						<span class="me-ss-point"></span>
					</div>
				</div>
		<?php
	}

    /**
     * Setup Wizard Footer.
     */
    public function footer()
    {
        ?>
					<div class="me-setup-footer">
						<a href="<?php echo esc_url(admin_url()); ?>"><?php _e('Return to the WordPress Dashboard', 'enginethemes');?></a>
					</div>
				</div>
			</div>
			</body>
		</html>
		<?php
		exit;
    }

    public function body()
    {
    	$currencies = $this->get_currency_list();	
    	$skip_setup_nonce = wp_create_nonce('skip_setup_wizard');
        ?>
    	<div class="me-setup-section">
    		<?php wp_nonce_field('marketengine-setup');?>
			<!-- Overview -->
			<div class="me-setup-container me-setup-overview active" data-step="0">
				<h2><?php _e("Welcome!", "enginethemes");?></h2>
				<p><?php _e("Thank you for choosing MarketEngine to build your marketplace!", "enginethemes");?></p>
				<br/>
				<p><?php _e("If this is your first time using MarketEngine, you can get started by using this quick setup wizard. It usually takes less than five minutes. You can also skip any steps and get back to them later in the settings area.", "enginethemes");?></p>
				<div class="me-setup-control">
					<a href="<?php echo esc_url(admin_url()); ?>" class="me-sbeak-btn"><?php _e("ANOTHER TIME", "enginethemes");?></a>
					<a href="#page" class="me-scontinue-btn wizard-start"><?php _e("START NOW", "enginethemes");?></a>
				</div>
			</div>
			<!-- Page setup -->
			<div class="me-setup-container me-setup-page" id="page" data-step="1">
				<form>
					<h2><?php _e("Page Setup", "enginethemes");?></h2>
					<p><?php _e("To run your marketplace properly, MarketEngine needs to create some specific pages. This step will automatically generate these needed pages if they don,t exist:", "enginethemes");?></p>
					<div class="me-spage-group">
						<h3><?php _e("Account", "enginethemes");?></h3>
						<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy </p>
					</div>
					<div class="me-spage-group">
						<h3><?php _e("Listing", "enginethemes");?></h3>
						<p>consectetuer adipiscing elit, sed diam nonummy consectetuer adipiscing elit, sed diam nonummy Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy </p>
					</div>
					<div class="me-spage-group">
						<h3><?php _e("Payment Flow", "enginethemes");?></h3>
						<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy </p>
					</div>
					<div class="me-spage-group">
						<h3><?php _e("Inquiry", "enginethemes");?></h3>
						<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy </p>
					</div>
					<div class="me-setup-control">
						<a href="#personalize" class="me-sprevious-btn me-skip-btn"><?php _e("Skip this step", "enginethemes");?></a>
						<a href="#personalize" class="me-scontinue-btn me-next"><?php _e("CONTINUE", "enginethemes");?></a>
					</div>
					<input type="hidden" name="step" value="page" />

				</form>
			</div>
			<!-- Personalize -->
			<div class="me-setup-container me-setup-personalize" id="personalize" data-step="2">
				<form>
					<h2><?php _e("Personalize", "enginethemes");?></h2>
					<div class="me-sfield-group">
						<label for="me-setup-listing"><?php _e("1- How should people understand “listings” in your marketplace?", "enginethemes");?></label>
						<input id="me-setup-listing" type="text" name="listing_label" value="<?php echo me_option('listing-label', 'Listing') ?>">
					</div>
					<div class="me-sfield-group">
						<label for="me-setup-seller"><?php _e("2- What should we call the Seller role in your marketplace?", "enginethemes");?></label>
						<input id="me-setup-seller" type="text" name="seller_label" value="<?php echo me_option('seller-label', 'Seller') ?>">
					</div>
					<div class="me-sfield-group">
						<label for="me-setup-buyer"><?php _e("3- What should we call the Buyer role in your marketplace?", "enginethemes");?></label>
						<input id="me-setup-buyer" type="text" name="buyer_label" value="<?php echo me_option('buyer-label', 'Buyer') ?>">
					</div>
					<div class="me-setup-control">
						<a href="#payment" class="me-sprevious-btn me-skip-btn"><?php _e("Skip this step", "enginethemes");?></a>
						<a href="#payment" class="me-scontinue-btn me-next"><?php _e("CONTINUE", "enginethemes");?></a>
					</div>
					<input type="hidden" name="step" value="personalize" />
				</form>
			</div>

			<!-- More Settings -->
			<div class="me-setup-container me-setup-more-settings" id="payment" data-step="3">
				<form>
					<h2><?php _e("More Settings", "enginethemes");?></h2>
					<div class="me-sfield-group">
						<label for=""><?php _e("1- Create some listing categories for your marketplace", "enginethemes");?></label>
						<input type="text" name="cats[]"> <span class="me-setup-add-cat"><i class="icon-me-add"></i><?php _e("Add more", "enginethemes");?></span>
						<div class="more-cat" style="display:none">
							<input type="text" name="cats[]" /> <input type="text" name="cats[]" /><small><?php _e("More categories can be added later in MarketEngine settings", "enginethemes");?></small>
						</div>
					</div>
					<div class="me-sfield-group">
						<label for=""><?php _e("2- What is your commission fee?", "enginethemes");?></label>
						<input id="me-setup-commission" class="me-input-price" name="commission" type="number" min="0">
						<span>%</span>
					</div>
					<div class="me-sfield-group">
						<label for=""><?php _e("3- Define the currency in your marketplace?", "enginethemes"); ?></label>
						<select name="currency" id="">
						<?php foreach ($currencies as $key => $currency) : ?>
							<option value="<?php echo $key ?>"><?php echo $currency['label'] ?> (<?php echo $currency['sign'] ?>) (<?php echo $currency['code'] ?>)</option>
						<?php endforeach; ?>
						</select>
					</div>
					<div class="me-setup-control">
						<a href="#finish" class="me-sprevious-btn me-skip-btn"><?php _e("Skip this step", "enginethemes");?></a>
						<a href="#finish" class="me-scontinue-btn me-next"><?php _e("CONTINUE", "enginethemes");?></a>
					</div>
					<input type="hidden" name="step" value="payment" />
				</form>
			</div>
			<!-- That's it -->
			<div class="me-setup-container me-setup-that-it" id="finish" data-step="4">
				<div class="me-setup-wrap">
					<h2><?php _e("That's It", "enginethemes");?></h2>
					<p><?php _e("Congragulations! You have successfully made some steps on building your marketplace.", "enginethemes");?><br/><?php _e("What's next?", "enginethemes");?></p>
				</div>
				<div class="me-setup-wrap <?php if(get_option('me-added-sample-data')) {echo "active";} ?>">
					<form>
						<h3><?php _e("Sample Data", "enginethemes");?></h3>
						<div class="me-setup-sample">
							<p><?php _e("You can add some sample data to grasp some clearer ideas of how your marketplace will look like.<br/>Some sample listings will be generated in each of your categories, together with a few users &amp; orders to demonstrate the checkout flows.<br/>You will be able to remove those samples with another click later.", "enginethemes");?></p>
							<label class="me-setup-data-btn" id="me-add-sample-data" for="me-setup-sample-data">
								<span id="me-setup-sample-data"><?php _e("ADD SAMPLE DATA", "enginethemes");?></span>
							</label>
						</div>
						<div class="me-setup-sample-finish">
							<p><?php _e("Few users, orders and some sample listings have already been generated in each of your categories.", "enginethemes");?></p>
							<p><?php _e("You will be able to remove those samples with another click later.", "enginethemes");?></p>
						</div>
					</form>
				</div>

				<div class="me-setup-wrap">
					<h3><?php _e("Mailing List", "enginethemes");?></h3>
					<div class="me-setup-mailing">
						<p><?php _e("Join the mailing list to get latest news, tips &amp; updates about the plugin.", "enginethemes");?></p>
							<form id="me-setup-mailing-form" action="//enginethemes.us9.list-manage.com/subscribe/post?u=ba195a10aeadb30c31dd8e509&id=8e5611c859" method="post" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
								<div class="me-smail-control">
									<label for="me-smail-name"><?php _e("Name", "enginethemes");?></label>
									<input type="text" value="" name="FNAME" class="" id="mce-FNAME">
								</div>
								<div class="me-smail-control">
									<label for="me-smail-email"><?php _e("Email address", "enginethemes");?></label>
									<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
								</div>
								<input class="me-smail-submit-btn" type="submit" value="SUBMIT">
							</form>
					</div>
					<div class="me-setup-mailing-finish">
						<p><?php _e("Thank you for joining the mailing list.", "enginethemes");?></p>
					</div>
				</div>
				<div class="me-setup-wrap">
					<div class="me-setup-control">
						<a href="<?php echo admin_url("?skip-setup=1&nonce=".$skip_setup_nonce) ?>" class="me-sfinish-btn"><?php _e("FINISH", "enginethemes");?></a>
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