<?php
/**
 * The template for displaying the dispute form.
 * This template can be overridden by copying it to yourtheme/marketengine/resolution/dispute-form.php.
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 * @version     1.0.0
 * @since 		1.0.1
 */

$listings = $transaction->get_listing_items();

if($listings) :
	foreach($listings as $id => $listing)
?>
<div class="me-disputed-product-info">
	<h3><?php _e('You purchased item:', 'enginethemes'); ?></h3>
	<a href="<?php echo get_permalink($id); ?>"><?php echo get_the_post_thumbnail($id); ?></a>
	<div class="me-disputed-product">
		<h2><a href="<?php echo get_permalink($id); ?>"><?php echo $listing['title']; ?></a></h2>
		<p><span><?php _e('Unit price:', 'enginethemes'); ?></span><?php echo me_price_format($listing['price']); ?></p>
		<p><span><?php _e('Quantity:', 'enginethemes'); ?></span><?php echo $listing['qty']; ?></p>
		<p><span><?php _e('Total amount:', 'enginethemes'); ?></span><?php echo me_price_format($transaction->get_total()); ?></p>
	</div>
</div>
<?php
endif;
?>