<?php
$user_id = get_current_user_id();
$args = array(
		'post_type' => 'me_order', 
		'post_author' => $user_id, 
		'paged' => get_query_var('paged')
	);
query_posts($args);
?>
<div class="me-orderlist-filter">
	<div class="me-row">
		<div class="me-col-sm-6 me-col-sm-pull-6">
			<a href="#" class="me-export-report">Export report</a>
		</div>
		<div class="me-col-sm-6 me-col-sm-push-6">
			<select name="" id="">
				<option value="">Filter order's status</option>
				<option value="complete">Complete</option>
				<option value="pending">Pending</option>
				<option value="close">Close</option>
				<option value="Dispute">Dispute</option>
			</select>
		</div>
	</div>
</div>
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
		$listing_item = me_get_order_items(get_the_ID(), 'listing_item');
		$item_id = me_get_order_item_meta($listing_item[0]->order_item_id, '_listing_id', true);
	?>
		<div class="me-table-row">
			<div class="me-table-col me-order-id"><a href="">#ME123456</a></div>
			<div class="me-table-col me-order-status">
				<span class="me-order-<?php echo get_post_status(); ?>">
					<?php echo get_post_status_object(get_post_status())->label; ?>
				</span>
			</div>
			<div class="me-table-col me-order-amount">$630001200.00</div>
			<div class="me-table-col me-order-date"><?php echo get_the_date(); ?></div>
			<div class="me-table-col me-order-listing">
				<div class="me-order-listing-info">
					<p><?php echo esc_html( get_the_title($item_id) ); ?></p>
				</div>
			</div>
		</div>

	<?php endwhile; ?>
	<!-- <div class="me-table-row">
		<div class="me-table-col me-order-id"><a href="">#ME123456</a></div>
		<div class="me-table-col me-order-status"><span class="me-order-pending">Pending</span></div>
		<div class="me-table-col me-order-amount">$1200.00</div>
		<div class="me-table-col me-order-date">7 july, 2016</div>
		<div class="me-table-col me-order-listing">
			<div class="me-order-listing-info">
				<p>Extra Slim Innovator Wool Blend Navy Suit Jacket</p>
			</div>
		</div>
	</div>
	<div class="me-table-row">
		<div class="me-table-col me-order-id"><a href="">#ME123456</a></div>
		<div class="me-table-col me-order-status"><span class="me-order-close">Close</span></div>
		<div class="me-table-col me-order-amount">$1200.00</div>
		<div class="me-table-col me-order-date">7 july, 2016</div>
		<div class="me-table-col me-order-listing">
			<div class="me-order-listing-info">
				<p>Extra Slim Innovator Wool Blend Navy Suit Jacket</p>
			</div>
		</div>
	</div>
	<div class="me-table-row">
		<div class="me-table-col me-order-id"><a href="">#ME123456</a></div>
		<div class="me-table-col me-order-status"><span class="me-order-dispute">Dispute</span></div>
		<div class="me-table-col me-order-amount">$1200.00</div>
		<div class="me-table-col me-order-date">7 july, 2016</div>
		<div class="me-table-col me-order-listing">
			<div class="me-order-listing-info">
				<p>Extra Slim Innovator Wool Blend Navy Suit Jacket</p>
			</div>
		</div>
	</div> -->
</div>

<div class="marketengine-paginations">
	<?php me_paginate_link(); ?>
	<!-- <a class="prev page-numbers" href="#">&lt;</a>
	<a class="page-numbers" href="#">1</a>
	<span class="page-numbers current">2</span>
	<a class="page-numbers" href="#">3</a>
	<a class="next page-numbers" href="">&gt;</a> -->
</div>
<div class="marketengine-loadmore">
	<a href="" class="me-loadmore me-loadmore-order">Load more</a>
</div>
<?php wp_reset_query(); ?>