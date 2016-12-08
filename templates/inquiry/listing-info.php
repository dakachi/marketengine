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
<?php if($listing) : ?>

	<?php $author = $listing->get_author() ==  get_current_user_id(); ?>

	<?php me_get_template('purchases/order-listing-image', array('listing_obj' => $listing)); ?>
	<div class="me-listing-info <?php echo (!$listing->is_available() ) ? 'me-listing-info-archive' : ''; ?>">
		<?php if($author || $listing->is_available()) : ?>
			<a class="" href="<?php echo $listing->get_permalink(); ?>">
				<?php echo esc_html( $listing->get_title() ); ?>
			</a>
		<?php else : ?>
			<span>
				<?php echo esc_html( $listing->get_title() ); ?>
			</span>
		<?php endif; ?>
		
		<?php if( $listing->is_available()) : ?>
			<?php echo $listing->get_short_description(); ?>
		<?php endif; ?>

	</div>

<?php endif; ?>
	<?php me_get_template('purchases/archived-listing-notice', array('listing_obj' => $listing) ); ?>
</div>
