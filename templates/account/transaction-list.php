<?php
/**
 *	The Template for displaying list of transactions that buyer purchased.
 * 	This template can be overridden by copying it to yourtheme/marketengine/account/transaction-list.php.
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 * @version     1.0.0
 */

$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$args = array(
	'post_type' 	=> 'me_order',
	'paged'			=> $paged,
);

$args = array_merge(apply_filters( 'me_filter_order', $_GET ), $args);

query_posts( $args );
?>
<!--Mobile-->
<div class="me-orderlist-filter-tabs">
	<span><?php echo __('Filter', 'enginethemes'); ?></span>
	<span><?php echo __('Filter list', 'enginethemes'); ?></span>
</div>

<?php me_get_template('global/order-filter'); ?>

<div class="me-table me-orderlist-table">
	<?php
	if( have_posts() ) : ?>
		<div class="me-table-rhead">
			<div class="me-table-col me-order-id"><?php _e("TRANSACTION ID", "enginethemes"); ?></div>
			<div class="me-table-col me-order-status"><?php _e("STATUS", "enginethemes"); ?></div>
			<div class="me-table-col me-order-amount"><?php _e("AMOUNT", "enginethemes"); ?></div>
			<div class="me-table-col me-order-date"><?php _e("DATE OF ORDER", "enginethemes"); ?></div>
			<div class="me-table-col me-order-listing"><?php _e("LISTING", "enginethemes"); ?></div>
		</div>
	<?php
		while( have_posts() ) : the_post();

			$order = new ME_Order( get_the_ID() );
			$order_total = $order->get_total();

			$order_listing = me_get_order_items( get_the_ID() );
			$order_date = get_the_date(get_option('date_format'), get_the_ID());
			$order_status = get_post_status( get_the_ID() );
	?>
	<div class="me-table-row">
	<?php // TODO: replace this with transaction number ?>
		<div class="me-table-col me-order-id"><a href="<?php the_permalink(); ?>">#<?php the_ID(); ?></a></div>
		<div class="me-table-col me-order-status">
			<?php echo me_print_order_status( $order_status ); ?>
		</div>
		<div class="me-table-col me-order-amount"><?php echo me_price_html($order_total); ?></div>
		<div class="me-table-col me-order-date"><?php echo $order_date; ?></div>
		<div class="me-table-col me-order-listing">
			<div class="me-order-listing-info">
				<p><?php echo isset($order_listing[0]) ? esc_html($order_listing[0]->order_item_name) : '' ?></p>
			</div>
		</div>
	</div>
	<?php
		endwhile;
	?>
</div>

<div class="marketengine-paginations">
	<?php me_paginate_link(); ?>
</div>
<div class="marketengine-loadmore">
	<a href="" class="me-loadmore me-loadmore-order"><?php _e("Load more", "enginethemes"); ?></a>
</div>

<?php
	else:
?>
	<div class="me-table-rhead me-table-rhead-empty">
		<div class="me-table-col me-order-id"><?php _e("TRANSACTION ID", "enginethemes"); ?></div>
		<div class="me-table-col me-order-status"><?php _e("STATUS", "enginethemes"); ?></div>
		<div class="me-table-col me-order-amount"><?php _e("AMOUNT", "enginethemes"); ?></div>
		<div class="me-table-col me-order-date"><?php _e("DATE OF ORDER", "enginethemes"); ?></div>
		<div class="me-table-col me-order-listing"><?php _e("LISTING", "enginethemes"); ?></div>
	</div>
	<div class="me-table-row-empty">
		<div>
			<span><?php _e('There are no transactions yet.', 'enginethemes'); ?></span>
		</div>
	</div>
<?php
	endif;
	wp_reset_query();
?>