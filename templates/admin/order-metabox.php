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

<h2><?php printf(__( "Order #%d details" , "enginethemes" ), $order->ID); ?></h2>
<div class="order-details">
	<p>
		<label><?php _e("Order date:", "enginethemes"); ?></label><?php echo get_the_date(); ?>
	</p>
	<p>
		<label><?php _e("Order status", "enginethemes"); ?></label>
		<?php echo me_get_order_status_label($order->post_status); ?>
	</p>
	<p>
		<label><?php _e("Buyer:", "enginethemes"); ?></label>
		<?php echo get_the_author_meta( 'display_name', $order->post_author ); ?>
	</p>
	<div class="me-orderbill-info">
		<h5><?php echo __( 'Billed to:', 'enginethemes' ); ?></h5>
		<p><?php me_print_buyer_information( $billing_address ); ?></p>
	</div>
	<?php if($note) : ?>

	<div class="me-ordernotes-info">
		<h5><?php echo __( 'Order Notes:', 'enginethemes' ); ?></h5>
		<p class=""><?php echo nl2br(esc_attr($note)); ?></p>
	</div>

	<?php endif;?>
</div>

<div class="me-order-items">
	<h5><?php _e("Order Item", "enginethemes"); ?></h5>
	<div class="me-table me-cart-table">
		<div class="me-table-rhead">
			<div class="me-table-col me-cart-name"><?php _e("Listing", "enginethemes"); ?></div>
			<div class="me-table-col me-cart-price"><?php _e("Price", "enginethemes"); ?></div>
			<div class="me-table-col me-cart-units"><?php _e("Units", "enginethemes"); ?></div>
			<div class="me-table-col me-cart-units-total"><?php _e("Total price", "enginethemes"); ?></div>
		</div>

		<?php do_action( 'marketengine_before_cart_item_list' ); ?>

		<?php
			$listing = $listing_item['ID'];
			$unit = ($listing_item['qty']) ? $listing_item['qty'][0] : 1;
		?>

		<div class="me-table-row me-cart-item">
			<div class="me-table-col me-cart-name">
				<div class="me-cart-listing">
					<a href="<?php echo get_permalink( $listing_obj->ID ); ?>">
						<?php echo get_the_post_thumbnail($listing_obj->ID); ?>
						<span><?php echo esc_html(get_the_title($listing_obj->ID)); ?></span>
					</a>
				</div>
			</div>
			<div class="me-table-col me-cart-price">
				<?php echo me_price_html( $listing_item['price'] ); ?>
			</div>
			<div class="me-table-col me-cart-units">
				<?php echo $unit ?>
			</div>
			<div class="me-table-col me-cart-units-total">
				<?php echo me_price_html($listing_item['price'] * $unit); ?>
			</div>
		</div>

		<div class="me-table-row me-cart-rtotals">
			<div class="me-table-col me-table-empty"></div>
			<div class="me-table-col me-table-empty"></div>
			<div class="me-table-col me-cart-amount"><?php _e("Total amount:", "enginethemes"); ?></div>
			<div class="me-table-col me-cart-totals"><?php echo me_price_html($listing_item['price'] * $unit); ?></div>
		</div>
	</div>
</div>

<div class="me-receiver-item">
	<?php if(!empty($receiver_item)) : ?>
	<div class="me-seller-item">
	<?php
		$receiver_name = $receiver_item->order_item_name;
		$receiver = get_user_by( 'login', $receiver_name );
		echo '<p>';
		_e("Name: ", "enginethemes");
		echo get_the_author_meta( 'display_name', $receiver->ID );
		echo '</p>';
		echo '<p>';
		_e("Paypal email: ", "enginethemes");
		echo me_get_order_item_meta($receiver_item->order_item_id, '_receive_email', true);
		echo '</p>';
		echo '<p>';
		_e("Amount: ", "enginethemes");
		echo me_get_order_item_meta($receiver_item->order_item_id, '_amount', true);
		echo '</p>';
	?>
	</div>
	<?php endif; ?>
	<div class="me-commision-item">
	<?php
		_e("Commision", "enginethemes");
		echo '<p>';
		_e("Paypal email: ", "enginethemes");
		echo me_get_order_item_meta($commission_item->order_item_id, '_receive_email', true);
		echo '</p>';
		echo '<p>';
		_e("Amount: ", "enginethemes");
		echo me_get_order_item_meta($commission_item->order_item_id, '_amount', true);
		echo '</p>';
	?>
	</div>
</div>
