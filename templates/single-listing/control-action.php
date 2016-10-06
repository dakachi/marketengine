<?php
$price = $listing->get_price();
$pricing_unit = $listing->get_pricing_unit();
?>

<div class="me-action">
	<?php if( 'purchasion' === $listing_type ) : ?>
		<span class="me-price">
		<b itemprop="priceCurrency" content="USD">$</b>
		<?php printf(__('<b itemprop="price" content="10">%d</b>%s', 'enginethemes'), $price, $pricing_unit) ?>
		</span>
		<span class="me-instock"><?php _e("In Stock", "enginethemes"); ?></span>
	<?php endif; ?>
	<span class="icon-me-pause"></span>
	<span class="icon-me-edit"></span>
	<span class="icon-me-delete"></span>
</div>