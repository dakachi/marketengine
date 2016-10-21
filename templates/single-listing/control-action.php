<div class="me-action">
	<?php if( 'purchasion' === $listing_type ) : ?>
	<?php
		$price = $listing->get_price();
		$pricing_unit = $listing->get_pricing_unit();
	?>

		<span class="me-price">
		<b itemprop="priceCurrency" content="USD">$</b>
		<?php printf(__('<b itemprop="price" content="10">%d</b>%s', 'enginethemes'), $price, $pricing_unit) ?>
		</span>
		<span class="me-instock"><?php _e("In Stock", "enginethemes"); ?></span>
	<?php endif; ?>
		<form method="post">
			<?php me_get_template('account/my-listing-action', array('listing_status' => $listing_status, 'listing_id' => get_the_ID())); ?>
			<?php wp_nonce_field( 'me_update_listing_status' ); ?>
			<input type="hidden" id="listing_id" value="<?php the_ID(); ?>" />
			<input type="hidden" id="redirect_url" value="<?php the_permalink(); ?>" />
		</form>
</div>