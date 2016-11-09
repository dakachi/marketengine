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

<?php if(!isset($_GET['tab']) || $_GET['tab'] == 'about') : ?>

<div id="me-tabs-section">
	<div class="me-section-about">
		<h4><?php _e('About seller', 'enginethemes'); ?></h4>
		<p><?php echo nl2br($about_seller); ?></p>
	</div>
</div>

<?php else :?>

<div id="me-tabs-section">
	<div class="me-section-listing">
		<?php me_get_template('seller-profile/listing-of-seller', array('user_id' => $user_id) ); ?>
	</div>
</div>

<?php endif; ?>