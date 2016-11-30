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

	<a class="me-orderlisting-thumbs" href="<?php echo $listing->get_permalink(); ?>">
		<?php echo $listing->get_listing_thumbnail(); ?>
	</a>
	<div class="me-listing-info">
		<a href="<?php echo $listing->get_permalink(); ?>">
			<?php echo esc_html( $listing->get_title() ); ?>
		</a>

		<?php echo $listing->get_short_description(); ?>

	</div>

<?php if($listing->post_status === 'me-archived') : ?>
	<p class="me-item-archive"><i class="icon-me-info-circle"></i><?php _e('This listing has been archived.', 'enginethemes'); ?></p>
<?php endif; ?>
</div>