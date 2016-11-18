<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

// item list
// buyer: name, paypal, account, status
// receiver list: name, paypal account, status
global $post;
$order = me_get_order($post);
$billing_address = $order->get_address( 'billing' );

$note = esc_html( $order->post_excerpt );

$listing_items = $order->get_listing_items();
$listing_item = array_pop($listing_items);
$listing_obj = me_get_listing($listing_item['ID']);

$receiver_items = me_get_order_items($post->ID, 'receiver_item');
$receiver_item = array_pop($receiver_items);

$commission_items = me_get_order_items($post->ID, 'commission_item');
$commission_item = array_pop($commission_items);
?>
<style type="text/css">
	.hndle  {
		display: none;
	}
	#poststuff h2 {
		font-size: 20px;
	}
	.order-details, .me-orderbill-info, .me-ordernotes-info, .me-order-items, .me-receiver-item {
		padding-left: 12px;
	}
	.order-details label {
	    cursor: pointer;
	    font-weight: bold;
	    min-width: 100px;
	    display: inline-block;
	}
	.pull-left {
		float: left;
	}
	.clearfix {
		clear : both;
	}
	.me-order-items th, .me-receiver-item th {
		text-align: left;
		width: 30%;
		line-height: 28px;
	}
	.me-receiver-item th {
	 	width: 25%;
	}
	.me-order-items img {
		width: 50px;
		height: 50px;
	}
	.me-order-items a {
		width: 200px;
	}
	.page-title-action {
		display: none;
	}
</style>
<div class="order-details">
	<p>
		<label><?php _e("ID:", "enginethemes"); ?></label>
		<?php printf(__( "#%d" , "enginethemes" ), $order->ID) ?>
	</p>
	<p>
		<label><?php _e("Order date:", "enginethemes"); ?></label>
		<?php echo get_the_date(); ?>
	</p>
	<p>
		<label><?php _e("Order status", "enginethemes"); ?></label>
		<?php echo me_get_order_status_label($order->post_status); ?>
	</p>
	<p>
		<label><?php _e("Buyer:", "enginethemes"); ?></label>
		<?php echo get_the_author_meta( 'display_name', $order->post_author ); ?>
	</p>
</div>

<h2><?php _e( 'Billed to:', 'enginethemes' ); ?></h2>
<div class="me-orderbill-info">
	
	<p><?php me_print_buyer_information( $billing_address ); ?></p>
</div>

<?php if($note) : ?>
<h2><?php echo __( 'Order Notes:', 'enginethemes' ); ?></h2>
<div class="me-ordernotes-info">
	
	<p class=""><?php echo nl2br(esc_attr($note)); ?></p>
</div>

<?php endif;?>

<h2><?php _e("Order Item", "enginethemes"); ?></h2>
<div class="me-order-items">
	
	<table>
		<tr>
			<th><?php _e("Listing", "enginethemes"); ?></th>
			<th><?php _e("Price", "enginethemes"); ?></th>
			<th><?php _e("Units", "enginethemes"); ?></th>
			<th><?php _e("Total price", "enginethemes"); ?></th>
		</tr>
		<?php
			$listing = $listing_item['ID'];
			$unit = ($listing_item['qty']) ? $listing_item['qty'][0] : 1;
		?>
		<tr>
			<td>
				<a href="<?php echo get_permalink( $listing_obj->ID ); ?>">
					<?php echo get_the_post_thumbnail($listing_obj->ID); ?>
					<div><?php echo esc_html(get_the_title($listing_obj->ID)); ?></div>
				</a>
			</td>
			<td><?php echo me_price_html( $listing_item['price'] ); ?></td>
			<td><?php echo $unit ?></td>
			<td><?php echo me_price_html($listing_item['price'] * $unit); ?></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td><?php _e("Total amount:", "enginethemes"); ?></td>
			<td><?php echo me_price_html($listing_item['price'] * $unit); ?></td>
		</tr>
	</table>
</div>

<h2><?php _e("Payment Info", "enginethemes"); ?></h2>
<div class="me-receiver-item">
	<table>
		<tr>
			<th><?php _e("Receiver Name", "enginethemes"); ?></th>
			<th><?php _e("Paypal Email", "enginethemes"); ?></th>
			<th><?php _e("Amount", "enginethemes"); ?></th>
		</tr>
	  	<?php if(!empty($receiver_item)) : ?>
		  	<?php
				$receiver_name = $receiver_item->order_item_name;
				$receiver = get_user_by( 'login', $receiver_name );
			?>
		<tr>
			<td><?php echo get_the_author_meta( 'display_name', $receiver->ID ); ?></td>
			<td><?php echo me_get_order_item_meta($receiver_item->order_item_id, '_receive_email', true); ?></td>
			<td><?php echo me_price_html(me_get_order_item_meta($receiver_item->order_item_id, '_amount', true)); ?></td>
		</tr>
	  	<?php endif; ?>

	  	<?php if(!empty($commission_item)) : ?>
	  	<tr>
		    <td><?php _e("Commision", "enginethemes"); ?></td>
		    <td><?php echo me_get_order_item_meta($commission_item->order_item_id, '_receive_email', true); ?></td>
		    <td><?php echo me_price_html(me_get_order_item_meta($commission_item->order_item_id, '_amount', true)); ?></td>
	  	</tr>
	  	<?php endif; ?>

	</table>

</div>
