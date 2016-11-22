<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

$price = $listing->get_price();
$pricing_unit = $listing->get_pricing_unit();
?>

<?php do_action('marketengine_before_single_listing_price'); ?>

<div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="me-amount">
	<span class="me-price">
		<?php echo me_price_html( $price, '', $pricing_unit ); ?>
	</span>
	<?php /* <span class="me-instock"><?php _e("In Stock", "enginethemes"); ?></span> */ ?>
	<div class="me-addtocart">
		<form method="post">

		<?php do_action('marketengine_single_listing_add_to_cart_form_start'); ?>

		<?php if('' !== $pricing_unit) : ?>
			<div class="me-quantily">
				<input type="number" required min="1" value="1" name="qty" />
			</div>
		<?php else : ?>
			<input type="hidden" required min="1" value="1" name="qty" />
		<?php endif; ?>

		<?php wp_nonce_field('me-add-to-cart'); ?>

		<?php do_action('marketengine_single_listing_add_to_cart_form_field'); ?>

		<input type="hidden" name="add_to_cart" value="<?php echo $listing->ID; ?>" />
		<input <?php disabled( !me_is_activated_user() ); ?> type="submit" class="me-buy-now-btn <?php echo !me_is_activated_user() ? 'me-disable-btn' : ''; ?>" value="<?php echo me_option('purchasion-action') ?  me_option('purchasion-action') : __("BUY NOW", "enginethemes"); ?>">

		<?php do_action('marketengine_single_listing_add_to_cart_form_end'); ?>

		</form>
	</div>
</div>
<?php do_action('marketengine_after_single_listing_price'); ?>