<?php
$order->update_listings();

$listing_items = $order->get_listing_items();
$listing = array_pop($listing_items);

$listing_obj = marketengine_get_listing($listing['ID']);

$author_id = $order->post_author;
?>
<div class="marketengine-content">
	<div class="me-order-detail">
		<?php
			marketengine_get_template( 'purchases/order-detail', array('transaction' => $order) );
		?>
	</div>
	<div class="me-row">
		<div class="me-col-md-9">

			<?php
				marketengine_get_template( 'purchases/order-listing', 
					array(
						'listing_obj' => $listing_obj, 
						'seller' => true, 
						'transaction' => $order, 
						'cart_listing' => $listing
					) 
				);

				marketengine_get_template( 'user-info', 
					array('class' => 'me-authors-xs me-visible-sm me-visible-xs', 
						'author_id' => $author_id 
					) 
				);
				marketengine_get_template( 'purchases/order-action', array('order' => $order) );
			?>

		</div>
		<div class="me-col-md-3 me-hidden-sm me-hidden-xs">
			<?php
				marketengine_get_template( 'user-info', array('author_id' => $author_id)  );
			?>
		</div>
	</div>
</div>
<!--// marketengine-content -->