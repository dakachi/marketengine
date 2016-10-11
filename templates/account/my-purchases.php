<?php
	$paged = get_query_var('paged') ? get_query_var('paged') : 1;
	$args = array(
		'post_type' 	=> 'me_order',
		'post_author'	=> get_current_user_id(),
		'paged'			=> $paged,
	);

	if( isset($_REQUEST['order_status']) && $_REQUEST['order_status'] !== '' ){
        $args['post_status'] = $_REQUEST['order_status'];
    }

    if( isset($_REQUEST['from_date']) && isset($_REQUEST['to_date']) ){
        $args['date_query'] = array(
            array(
                'after'     => $_REQUEST['from_date'],
                'before'    => $_REQUEST['to_date'] . '23:59:59',
            ),
        );
    }

	$query = new WP_Query( $args );
?>
<div class="me-orderlist">
	<div class="marketengine-tabs">
		<ul class="me-tabs">
			<li class="active"><span><?php echo __('Transactions', 'enginethemes'); ?></span></li>
			<li class=""><span><?php echo __('Inquiries', 'enginethemes'); ?></span></li>
		</ul>
		<div class="me-tabs-container">
			<!-- Tabs Orders -->
			<div class="me-tabs-section" style="display: block;">

				<!--Mobile-->
				<div class="me-orderlist-filter-tabs">
					<span>Filter</span>
					<span>Filter list</span>
				</div>

				<?php me_get_template('global/order-filter'); ?>

				<div class="me-table me-orderlist-table">
					<div class="me-table-rhead">
						<div class="me-table-col me-order-id">TRANSACTION ID</div>
						<div class="me-table-col me-order-status">STATUS</div>
						<div class="me-table-col me-order-amount">AMOUNT</div>
						<div class="me-table-col me-order-date">DATE OF ORDER</div>
						<div class="me-table-col me-order-listing">LISTING</div>
					</div>
					<?php
					if( $query->have_posts() ) :
						while( $query->have_posts() ) : $query->the_post();

							$order = new ME_Order( get_the_ID() );
							$order_total = $order->get_total();

							$order_listing = me_get_order_items( get_the_ID() );
							$order_date = get_the_date(get_option('date_format'), get_the_ID());
					?>
					<div class="me-table-row">
					<?php // TODO: replace this with transaction number ?>
						<div class="me-table-col me-order-id"><a href="<?php echo $order->get_transaction_detail_url(); ?>">#<?php the_ID(); ?></a></div>
						<div class="me-table-col me-order-status"><?php me_print_order_status( get_post_status( get_the_ID()) ); ?></div>
						<div class="me-table-col me-order-amount">$<?php echo $order_total; ?></div>
						<div class="me-table-col me-order-date"><?php echo $order_date; ?></div>
						<div class="me-table-col me-order-listing">
							<div class="me-order-listing-info">
								<p><?php echo isset($order_listing[0]) ? $order_listing[0]->order_item_name : '' ?></p>
							</div>
						</div>
					</div>
					<?php
						endwhile;
					?>
				</div>

				<div class="marketengine-paginations">
					<?php me_paginate_link( $query ); ?>
				</div>
				<div class="marketengine-loadmore">
					<a href="" class="me-loadmore me-loadmore-order">Load more</a>
				</div>

				<?php
					wp_reset_postdata();
					endif;
				?>

			</div>
			<!-- Tabs Inquiries -->
			<div class="me-tabs-section" style="display: none;">
				<div class="me-order-inquiries-filter">
					<div class="me-inquiries-filter">
						<select name="" id="">
							<option value="">View all listings</option>
							<option value="">View all unread</option>
							<option value="">View all read</option>
						</select>

					</div>
					<div class="me-inquiries-search">
						<span class="me-inquiries-refresh">
							<i class="icon-me-refresh"></i>
						</span>
						<input type="text">
						<i class="icon-me-search"></i>
					</div>
				</div>
				<div class="me-table me-order-inquiries-table">
					<div class="me-table-rhead">
						<div class="me-table-col me-order-listing">LISTING</div>
						<div class="me-table-col me-order-status">STATUS</div>
						<div class="me-table-col me-order-buyer">SELLER</div>
						<div class="me-table-col me-order-date-contact">DATE OF CONTACT</div>
					</div>
					<div class="me-table-row">
						<div class="me-table-col me-order-listing">
							<div class="me-order-listing-info">
								<p>Extra Slim Innovator Wool Blend Navy Suit Jacket Extra Slim Innovator Wool Blend Navy Suit Jacket</p>
							</div>
						</div>
						<div class="me-table-col me-order-status me-read">read</div>
						<div class="me-table-col me-order-buyer">Philip Anthony Hopkins</div>
						<div class="me-table-col me-order-date-contact">7 july, 2016</div>
					</div>
					<div class="me-table-row">
						<div class="me-table-col me-order-listing">
							<div class="me-order-listing-info">
								<p>Extra Slim Innovator Wool Blend Navy Suit Jacket</p>
							</div>
						</div>
						<div class="me-table-col me-order-status me-unread"><i class="icon-me-reply"></i>123 unread</div>
						<div class="me-table-col me-order-buyer">Philip Anthony Hopkins</div>
						<div class="me-table-col me-order-date-contact">7 july, 2016</div>
					</div>
					<div class="me-table-row">
						<div class="me-table-col me-order-listing">
							<div class="me-order-listing-info">
								<p>Extra Slim Innovator Wool Blend Navy Suit Jacket</p>
							</div>
						</div>
						<div class="me-table-col me-order-status me-unread"><i class="icon-me-reply"></i>123 unread</div>
						<div class="me-table-col me-order-buyer">Philip Anthony Hopkins</div>
						<div class="me-table-col me-order-date-contact">7 july, 2016</div>
					</div>
					<div class="me-table-row">
						<div class="me-table-col me-order-listing">
							<div class="me-order-listing-info">
								<span>Extra Slim Innovator Wool Blend Navy Suit Jacket Extra Slim</span>
							</div>
						</div>
						<div class="me-table-col me-order-status me-read">read</div>
						<div class="me-table-col me-order-buyer">Philip Anthony Hopkins</div>
						<div class="me-table-col me-order-date-contact">7 july, 2016</div>
					</div>
				</div>
				<div class="marketengine-paginations">
					<a class="prev page-numbers" href="#">&lt;</a>
					<a class="page-numbers" href="#">1</a>
					<span class="page-numbers current">2</span>
					<a class="page-numbers" href="#">3</a>
					<a class="next page-numbers" href="">&gt;</a>
				</div>
				<div class="marketengine-loadmore">
					<a href="" class="me-loadmore me-loadmore-order-inquiries">Load more</a>
				</div>
			</div>

		</div>
	</div>
</div>