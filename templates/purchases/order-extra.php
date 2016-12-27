<?php
$listing_items = $transaction->get_listing_items();
$cart_item = array_pop($listing_items);

$listing = me_get_listing($cart_item['ID']);

// $listing_cat = get_the_terms($listing->ID, 'listing_category');
if($transaction->post_author == get_current_user_id()) {
	$author_id = $listing ? $listing->post_author : '';	
}else {
	$author_id = $transaction->post_author;
}
?>
<div class="me-row">
	<div class="me-col-md-9">

		<?php
		me_get_template( 'purchases/order-listing', 
			array(
				'listing' => $listing, 
				'transaction' => $transaction, 
				'cart_listing' => $cart_item,
				'seller' => $transaction->post_author != get_current_user_id()
			) 
		);
		me_get_template( 'user-info', 
			array(
				'class' => 'me-authors-xs me-visible-sm me-visible-xs', 
				'author_id' => $author_id 
				) 
			);
		me_get_template( 'purchases/order-action', array('order' => $transaction) );
		?>

	</div>
	<div class="me-col-md-3 me-hidden-sm me-hidden-xs">
		<?php
			me_get_template( 'user-info', array('author_id' => $author_id)  );
		?>
	</div>
</div>