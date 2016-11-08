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
						<li class="active"><span><?php _e('About Seller', 'enginethemes'); ?></span></li>
						<li><span><?php _e('Listing of Seller', 'enginethemes'); ?></span></li>
					</ul>
					<div class="me-tabs-container">
						<?php me_get_template('seller-profile/content-seller-profile', array ('user_id' => $user_id) ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>