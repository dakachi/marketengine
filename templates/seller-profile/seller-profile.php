<?php
/**
 * 	The Template for displaying information of seller.
 * 	This template can be overridden by copying it to yourtheme/marketengine/seller-profile/seller-profile.php.
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 * @version     1.0.0
 */

if( !isset($user_id) || !$user_id ) {
	return;
}

$redirect = add_query_arg(array('seller-id' => $user_id), me_get_page_permalink('seller_profile'));;
?>
<div class="marketengine-content">
	<div class="me-row">
		<div class="me-col-md-3">
			<div class="me-content-sidebar">
				<?php me_get_template('seller-profile/seller-info', array('user_id' => $user_id) ); ?>
			</div>
		</div>
		<div class="me-col-md-9">
			<div class="me-content-profile">
				<div class="marketengine-tabs">

					<ul class="me-tabs">
						<li <?php echo (!isset($_GET['tab']) || $_GET['tab'] == 'about') ? 'class="active"' : ''; ?>>
						<?php $redirect = add_query_arg(array( 'tab' => 'about' ), $redirect); ?>
							<a href="<?php echo $redirect ?>">
								<span><?php _e('About Seller', 'enginethemes'); ?></span>
							</a>
						</li>
						<li <?php echo (isset($_GET['tab']) && $_GET['tab'] == 'listing') ? 'class="active"' : ''; ?>>
						<?php $redirect = add_query_arg(array( 'tab' => 'listing' ), $redirect); ?>
							<a href="<?php echo $redirect ?>">
								<span><?php _e('Listing of Seller', 'enginethemes'); ?></span>
							</a>
						</li>
					</ul>

					<div class="me-tabs-container">
						<?php me_get_template('seller-profile/content-seller-profile', array ('user_id' => $user_id) ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>