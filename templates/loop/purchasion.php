<?php
$price = $listing->get_price();
$pricing_unit = $listing->get_pricing_unit();
?>
<div class="me-item-price">
	<span itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="me-price pull-left">
		<b itemprop="priceCurrency" content="USD">$</b>
		<?php printf(__('<b itemprop="price" content="10">%d</b>%s', 'enginethemes'), $price, $pricing_unit) ?>
	</span>
	<!-- <div class="me-rating pull-right">
		<i class="icon-me-star"></i>
		<i class="icon-me-star"></i>
		<i class="icon-me-star"></i>
		<i class="icon-me-star"></i>
		<i class="icon-me-star-o"></i>
	</div> -->
</div>
<div class="me-buy-now">
	<form method="post">
		<input type="hidden" required min="1" value="1" name="qty" />
		<?php wp_nonce_field('me-add-to-cart'); ?>

		<?php do_action('marketengine_single_listing_add_to_cart_form_field'); ?>

		<input type="hidden" name="add_to_cart" value="<?php echo $listing->ID; ?>" />
		<input type="submit" class="me-buy-now-btn" value="<?php _e("BUY NOW", "enginethemes"); ?>">
	</form>
</div>