<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

function marketengine_get_quantity_report($col_name, $quant, $name = 'quant') {
    switch ($quant) {
    case 'week':
        $time = "WEEK({$col_name}) as `{$name}`, YEAR({$col_name}) as `year`";
        break;
    case 'quarter':
        $time = "QUARTER({$col_name}) as `{$name}` , YEAR({$col_name}) as `year`";
        break;
    case 'month':
        $time = "MONTH({$col_name}) as `{$name}` , YEAR({$col_name}) as `year`";
        break;
    case 'year':
        $time = "YEAR({$col_name}) as `{$name}` , YEAR({$col_name}) as `year`";
        break;
    default:
        $time = "date({$col_name}) as `{$name}` , YEAR({$col_name}) as `year`";
        break;
    }

    return $time;
}

function marketengine_get_start_and_end_date($quant, $week, $year) {
    $date_format = get_option('date_format');
    if ($quant == 'week') {
        $time = strtotime("1 January $year", time());
        $day  = date('w', $time);
        $time += ((7 * $week) + 1 - $day) * 24 * 3600;
        $return[0] = date_i18n($date_format, $time);
        $time += 6 * 24 * 3600;
        $return[1] = date_i18n($date_format, $time);
        return $return[0] . ' - ' . $return[1];
    }

    if ($quant == 'day') {
        return date_i18n($date_format, strtotime($week));
    }

    if ($quant == 'year') {
        return $week;
    }

    if ($quant == 'month') {
        $start_date = date_i18n($date_format, strtotime("01-{$week}-{$year}"));
        $ts         = strtotime("20-{$week}-{$year}");
        $ts         = date('t', $ts);
        $end_date   = date_i18n($date_format, strtotime("{$ts}-{$week}-{$year}"));
        echo $start_date . ' - ' . $end_date;
    }

    if ($quant == 'quarter') {
        $week       = (($week - 1) * 3) + 1;
        $start_date = date_i18n($date_format, strtotime("01-{$week}-{$year}"));

        $week = $week + 2;

        $ts       = strtotime("20-{$week}-{$year}");
        $ts       = date('t', $ts);
        $end_date = date_i18n($date_format, strtotime("{$ts}-{$week}-{$year}"));
        echo $start_date . ' - ' . $end_date;
    }
}

function marketengine_listing_report($args) {
    global $wpdb;
    $defaults = array(
        'quant'     => 'day',
        'from_date' => '2016-04-22',
        'to_date'   => '2016-12-22',
        'orderby'   => 'quant',
        'order'     => 'DESC',
        'paged'     => 1,
        'showposts' => get_option('posts_per_page'),
    );
    $args = wp_parse_args($args, $defaults);

    extract($args);

    if (empty($from_date)) {
        $from_date = '1970-1-1';
    }

    if (empty($to_date)) {
        $to_date = date('Y-m-d', time());
    }

    $pgstrt = absint(($paged - 1) * $showposts) . ', ';

    $field = $wpdb->posts . '.post_date';
    $time  = marketengine_get_quantity_report($field, $quant);

    $select  = "SELECT SQL_CALC_FOUND_ROWS {$time} ,
                count({$wpdb->posts}.ID) as count,
                count(A.meta_value) as contact_type ,
                count(B.meta_value) as purchase_type
            ";

    $from = " FROM {$wpdb->posts}";

    $join = " LEFT JOIN  $wpdb->postmeta as A ON  A .post_id = {$wpdb->posts}.ID AND A.meta_value = 'contact' ";
    $join .= " LEFT JOIN  $wpdb->postmeta as B ON  B.post_id = {$wpdb->posts}.ID AND B.meta_value = 'purchasion' ";

    $where   = " WHERE post_type = 'listing'  AND post_date BETWEEN '{$from_date}' AND '{$to_date}'";
    $groupby = " GROUP BY `quant` ,`year`";
    $orderby = " ORDER BY {$orderby} ";
    $order   = " ORDER {$order} ";
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

function marketengine_members_report($args) {
    global $wpdb;
    $defaults = array(
        'quant'     => 'day',
        'from_date' => '2016-04-22',
        'to_date'   => '2016-12-22',
        'orderby'   => 'quant',
        'order'     => 'DESC',
        'paged'     => 1,
        'showposts' => get_option('posts_per_page'),
    );
    $args = wp_parse_args($args, $defaults);

    extract($args);

    if (empty($from_date)) {
        $from_date = '1970-1-1';
    }

    if (empty($to_date)) {
        $to_date = date('Y-m-d', time());
    }

    $pgstrt = absint(($paged - 1) * $showposts) . ', ';

    $field = $wpdb->users . '.user_registered';
    $time  = marketengine_get_quantity_report($field, $quant);

    $select  = "SELECT SQL_CALC_FOUND_ROWS {$time} , count({$wpdb->users}.ID) as count FROM {$wpdb->users}";
    $where   = " WHERE user_registered BETWEEN '{$from_date}' AND '{$to_date}' ";
    $groupby = " GROUP BY `quant` ,`year` ";
    $orderby = " ORDER BY {$orderby} ";
    $order   = " ORDER {$order} ";
    $limits  = ' LIMIT ' . $pgstrt . $showposts;

    $sql = $select . $where . $groupby . $orderby . $limits;

    $result = $wpdb->get_results($sql);

    $found_rows     = $wpdb->get_var('SELECT FOUND_ROWS() as row');
    $max_numb_pages = ceil($found_rows / $showposts);
    return array(
        'found_posts'    => $found_rows,
        'max_numb_pages' => $max_numb_pages,
        'posts'          => $result,
    );
}

function marketengine_orders_report($args) {
    global $wpdb;
    $defaults = array(
        'quant'     => 'day',
        'from_date' => '2016-04-22',
        'to_date'   => '2016-12-22',
        'orderby'   => 'quant',
        'order'     => 'DESC',
        'paged'     => 1,
        'showposts' => get_option('posts_per_page'),
    );
    $args = wp_parse_args($args, $defaults);

    extract($args);

    if (empty($from_date)) {
        $from_date = '1970-1-1';
    }

    if (empty($to_date)) {
        $to_date = date('Y-m-d', time());
    }

    $pgstrt = absint(($paged - 1) * $showposts) . ', ';

    $field = $wpdb->posts . '.post_date';
    $time  = marketengine_get_quantity_report($field, $quant);

    $select  = "SELECT SQL_CALC_FOUND_ROWS {$time} ,
                count({$wpdb->posts}.ID) as count,
                sum({$wpdb->postmeta}.meta_value) as total
            ";

    $from = " FROM {$wpdb->posts}";

    $join = " INNER JOIN  $wpdb->postmeta ON  {$wpdb->postmeta}.post_id = {$wpdb->posts}.ID ";

    $where   = " WHERE post_type = 'me_order'  AND post_date BETWEEN '{$from_date}' AND '{$to_date}'";
    $groupby = " GROUP BY `quant` ,`year` ";
    $orderby = " ORDER BY {$orderby} ";
    $order   = " ORDER {$order} ";
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

function marketengine_inquiries_report($args) {
    global $wpdb;
    $defaults = array(
        'quant'     => 'day',
        'from_date' => '',
        'to_date'   => '',
        'orderby'   => 'quant',
        'order'     => 'DESC',
        'paged'     => 1,
        'showposts' => get_option('posts_per_page'),
    );
    $args = wp_parse_args($args, $defaults);
    extract($args);

    if (empty($from_date)) {
        $from_date = '1970-1-1';
    }

    if (empty($to_date)) {
        $to_date = date('Y-m-d', time());
    }

    $pgstrt = absint(($paged - 1) * $showposts) . ', ';

    $field = $wpdb->marketengine_message_item . '.post_date';
    $time  = marketengine_get_quantity_report($field, $quant);

    $select  = "SELECT SQL_CALC_FOUND_ROWS {$time}, count({$wpdb->marketengine_message_item}.ID) as count FROM {$wpdb->marketengine_message_item}";
    $where   = " WHERE post_type = 'inquiry'  AND post_date BETWEEN '{$from_date}' AND '{$to_date}'";
    $groupby = " GROUP BY `quant` ,`year` ";
    $orderby = " ORDER BY {$orderby} ";
    $order   = " ORDER {$order} ";
    $limits  = ' LIMIT ' . $pgstrt . $showposts;

    $sql = $select . $where . $groupby . $orderby . $limits;

    $result = $wpdb->get_results($sql);

    $found_rows     = $wpdb->get_var('SELECT FOUND_ROWS() as row');
    $max_numb_pages = ceil($found_rows / $showposts);
    return array(
        'found_posts'    => $found_rows,
        'max_numb_pages' => $max_numb_pages,
        'posts'          => $result,
    );
}

// tinh toan start date va end date