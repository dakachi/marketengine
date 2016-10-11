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