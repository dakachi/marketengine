<?php
/**
 * 	The Template for displaying content of listing detail.
 * 	This template can be overridden by copying it to yourtheme/marketengine/content-single-listing.php.
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 * @version     1.0.0
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

$listing_type = $listing->get_listing_type();
$is_owner = $listing->post_author == get_current_user_id();
$listing_status = get_post_status_object($listing->post_status);
?>
<div id="marketengine-page">
	<div class="marketengine me-container">
		<div itemscope itemtype="http://schema.org/Product" class="marketengine-listing-detail">
			<div class="me-row">
				<div class="me-col-md-12">
					<?php me_get_template('single-listing/title');?>
					<?php me_get_template('single-listing/statistic', array('listing' => $listing));?>
				</div>
			</div>
			<div class="me-row">
				<div class="me-col-md-9">

					<?php do_action('marketengine_before_single_listing_details'); ?>

					<div class="marketengine-content-detail">
						<?php me_get_template('single-listing/gallery', array('listing' => $listing));?>
						<div class="me-box-shadow">
							<?php me_get_template('single-listing/description', array('listing' => $listing));?>
							<?php me_get_template('single-listing/rating', array('listing' => $listing));?>
						</div>
					</div>

					<?php do_action('marketengine_after_single_listing_details'); ?>

				</div>

				<?php if(!me_is_activated_user()) : ?>
				<div class="me-col-md-3">
					<p><?php _e("You need to active your account via email before buy listings.", "enginethemes"); ?></p>
				<?php
					$profile_link = me_get_page_permalink('user_account');
	                $activate_email_link = add_query_arg(array( 'resend-confirmation-email' => true, '_wpnonce' => wp_create_nonce('me-resend_confirmation_email') ), $profile_link);
	            ?>
	                <p><a href="<?php echo $activate_email_link; ?>"><?php _e("Resend activation email.", "enginethemes"); ?></a></p>
				</div>
				<?php endif; ?>

				<div class="me-col-md-3">

					<?php do_action('marketengine_before_single_listing_sidebar'); ?>

					<div class="marketengine-sidebar-detail">

						<?php
						if($listing_type) :
							if( $is_owner ) :
								me_get_template('single-listing/status', array('listing_status' => $listing_status) );
								me_get_template('single-listing/control-action', array('listing_type' => $listing_type , 'listing' => $listing, 'listing_status' => $listing_status) );
							else :
								me_get_template('single-listing/'. $listing_type , array('listing' => $listing));
							endif;
						endif;
						?>
						<?php me_get_template('single-listing/category');?>
						<?php
						if( !$is_owner ) :
							me_get_template('user-info', array('author_id' => $listing->post_author));
							me_get_template('single-listing/report');
						endif;
						?>
					</div>

					<?php do_action('marketengine_after_single_listing_sidebar'); ?>

				</div>
			</div>
		</div>
	</div>
</div>
