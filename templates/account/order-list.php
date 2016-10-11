<?php
$user_id = get_current_user_id();
$args = array(
		'post_type' => 'me_order',
		'post_author' => $user_id,
		'paged' => get_query_var('paged')
	);
$args = array_merge(apply_filters( 'me_filter_order', $_GET ), $args);

query_posts($args);
?>
<!--Mobile-->
<div class="me-orderlist-filter-tabs">
	<span><?php echo __('Filter', 'enginethemes'); ?></span>
	<span><?php echo __('Filter list', 'enginethemes'); ?></span>
</div>
<!--/Mobile-->
<?php me_get_template('global/order-filter', array('type' => 'order')); ?>

<a href="#" class="me-order-export"><i class="icon-me-download"></i>Export report</a>

<div class="me-table me-orderlist-table">
	<div class="me-table-rhead">
		<div class="me-table-col me-order-id"><?php _e("ORDER ID", "enginethemes"); ?></div>
		<div class="me-table-col me-order-status"><?php _e("STATUS", "enginethemes"); ?></div>
		<div class="me-table-col me-order-amount"><?php _e("AMOUNT", "enginethemes"); ?></div>
		<div class="me-table-col me-order-date"><?php _e("DATE OF ORDER", "enginethemes"); ?></div>
		<div class="me-table-col me-order-listing"><?php _e("LISTING", "enginethemes"); ?></div>
	</div>
	<?php while(have_posts()) : the_post(); ?>

	<?php
		$order = new ME_Order( get_the_ID() );
		$order_total = $order->get_total();

		$listing_item = me_get_order_items(get_the_ID(), 'listing_item');
		$item_id = me_get_order_item_meta($listing_item[0]->order_item_id, '_listing_id', true);
	?>
		<div class="me-table-row">
			<div class="me-table-col me-order-id"><a href="<?php echo $order->get_order_detail_url(); ?>">#ME123456</a></div>
			<div class="me-table-col me-order-status">
				<?php me_print_order_status( get_post_status( get_the_ID()) ); ?>
			</div>
			<div class="me-table-col me-order-amount">$<?php echo $order_total; ?></div>
			<div class="me-table-col me-order-date"><?php echo get_the_date(get_option('date_format'), get_the_ID()); ?></div>
			<div class="me-table-col me-order-listing">
				<div class="me-order-listing-info">
					<p><?php echo esc_html( get_the_title($item_id) ); ?></p>
				</div>
			</div>
		</div>

	<?php endwhile; ?>
</div>

<div class="marketengine-paginations">
	<?php me_paginate_link(); ?>
</div>
<div class="marketengine-loadmore">
	<a href="" class="me-loadmore me-loadmore-order">Load more</a>
</div>
<?php wp_reset_query(); ?>