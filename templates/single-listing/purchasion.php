<?php 
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

global $post;
$listing = new ME_Listing_Purchase($post);
$price = $listing->get_price();
$pricing_unit = $listing->get_pricing_unit();
?>
<div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="me-price">
	<span class="me-amount">
		<b itemprop="priceCurrency" content="USD">$</b>
		<?php printf(__('<b itemprop="price" content="10">%d</b>%s', 'enginethemes'), $price, $pricing_unit) ?>
	</span>
</div>
<div class="me-addtocart">
	<div class="me-quantily">
		<input type="number">
	</div>
	<button class="me-buy-now-btn">BUY NOW</button>
</div>
