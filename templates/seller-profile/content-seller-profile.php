<?php
/**
 * 	The Template for displaying profile content of seller.
 * 	This template can be overridden by copying it to yourtheme/marketengine/seller-profile/content-seller-profile.php.
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 * @version     1.0.0
 */

$about_seller = get_user_meta( $user_id, 'description' , true );

?>

<div id="me-tabs-section" style="display: block;">
	<div class="me-section-about">
		<h4><?php _e('About seller', 'enginethemes'); ?></h4>
		<p><?php echo nl2br($about_seller); ?></p>
	</div>
</div>

<div id="me-tabs-section" style="display: none;">
	<div class="me-section-listing">
		<?php me_get_template('seller-profile/listing-of-seller', array('user_id' => $user_id) ); ?>
	</div>
</div>