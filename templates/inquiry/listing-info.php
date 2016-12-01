<?php
/**
 * The template for displaying listing information of the conversation page.
 *
 * This template can be override by copying it to yourtheme/marketengine/inquiry/listing-info.php.
 *
 * @author EngineThemes
 * @package MarketEngine/Templates
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<div class="me-orderlisting-info">

	<?php me_get_template('purchases/order-listing-image', array('listing_obj' => $listing)); ?>
	<div class="me-listing-info">
		<a href="<?php echo $listing->is_available() ? $listing->get_permalink() : 'javascript:void(0)'; ?>">
			<?php echo esc_html( $listing->get_title() ); ?>
		</a>

		<?php echo $listing->get_short_description(); ?>

	</div>

	<?php me_get_template('purchases/archived-listing-notice', array('listing_obj' => $listing) ); ?>
</div>