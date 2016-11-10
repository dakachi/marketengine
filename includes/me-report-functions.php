<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

function me_order_report_data( $args ) {
	global $wpdb;
    $defaults['showposts'] = -1;
    $args = wp_parse_args($args, $defaults);
    extract($args);

    if (empty($from_date)) {
        $from_date = '1970-1-1';
    }

    if (empty($to_date)) {
        $to_date = date('Y-m-d 23:59:59', time());
    }

    $select = "SELECT SQL_CALC_FOUND_ROWS {$time} ,
                count( DISTINCT {$wpdb->posts}.ID) as count,
                count(A.meta_value) as contact_type ,
                count(B.meta_value) as purchase_type
            ";

    $from = " FROM {$wpdb->posts}";

    $join = " LEFT JOIN  $wpdb->postmeta as A ON  A .post_id = {$wpdb->posts}.ID AND A.meta_key = '_me_listing_type' AND A.meta_value = 'contact' ";
    $join .= " LEFT JOIN  $wpdb->postmeta as B ON  B.post_id = {$wpdb->posts}.ID AND B.meta_key = '_me_listing_type' AND B.meta_value = 'purchasion' ";

    $where   = " WHERE post_type = 'listing' AND post_date BETWEEN '{$from_date}' AND '{$to_date}'";
    $groupby = " GROUP BY `quant` ,`year`";
    $orderby = " ORDER BY {$orderby} {$order}";

    $limits  = ' LIMIT ' . $pgstrt . $showposts;

    $sql = $select . $from . $join . $where . $groupby . $orderby . $limits;

    $result = $wpdb->get_results($sql);

    $found_rows     = $wpdb->get_var('SELECT FOUND_ROWS() as row');
    $max_numb_pages = ceil($found_rows / $showposts);
    return array(
        'found_posts'    => $found_rows,
        'max_numb_pages' => $max_numb_pages,
        'posts'          => $result,
    );
}

function me_transaction_report_data( $args ) {
	global $wpdb;
	$defaults = array(
        'from_date' => '2016-04-22',
        'to_date'   => '2016-12-22',
        'orderby'   => 'post_date',
        'order'     => 'DESC',
        'order_status' => 'any',
        'showposts' => get_option('posts_per_page'),
        'keyword'	=> ''
    );
    $args = wp_parse_args($args, $defaults);

    extract($args);

    if (empty($from_date)) {
        $from_date = '1970-1-1';
    }

    if (empty($to_date)) {
        $to_date = date('Y-m-d', time());
    }

	$user = get_current_user_id();

	$query = "SELECT DISTINCT(P.ID) as transaction_id,
			P.post_status as status,
			PM.meta_value as amount,
			P.post_date as date_of_order,
			O.order_item_name as listing_title

	 		FROM $wpdb->posts as P
	 		LEFT JOIN $wpdb->marketengine_order_items as O
	 			ON P.ID = O.order_id
	 		LEFT JOIN  $wpdb->postmeta as PM ON  PM.post_id = P.ID AND PM.meta_key = '_order_subtotal'
	 		WHERE P.post_type = 'me_order'
	 		    AND P.post_author = {$user}
	 		    AND P.post_date BETWEEN '{$from_date}' AND '{$to_date}'";

	if( empty($order_status) || $order_status == 'any' ) {
		$query .= " AND (";
		$order_status = array( 'me-complete', 'me-pending', 'me-closed' );
		$order_status = apply_filters( 'me_export-order_status', $order_status );
		foreach($order_status as $key => $status) {
			if($key != 0) {
				$query .= " OR ";
			}
			$query .= "P.post_status = '{$status}'";
		}
		$query .= ")";
	} else {
		$query .= " AND P.post_status = '{$order_status}'";
	}

	if( !empty($keyword) ) {
		$query .= " AND (P.ID IN (
	 		        SELECT order_items.order_id
	 		        FROM $wpdb->marketengine_order_items as order_items
	 		        WHERE order_items.order_item_type = 'listing_item'
	 		        AND order_items.order_item_name LIKE '%{$keyword}%'
	 		        )";
	 	if( is_numeric($keyword) ) {
	 		$query .= " OR
	 		        P.ID IN ({$keyword})";
	 	}
	 	$query .= ")";
	}

	$query .= " GROUP BY P.ID";

    $result = $wpdb->get_results($query);

	return $result;
}