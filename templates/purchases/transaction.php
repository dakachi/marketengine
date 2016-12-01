<?php
/**
 * The Template for displaying details of a transaction.
 *
 * This template can be overridden by copying it to yourtheme/marketengine/purchases/transaction.php.
 *
 * @package     MarketEngine/Templates
 * @version       1.0
 */

$transaction->update_listings();

$listing_items = $transaction->get_listing_items();
$listing = array_pop($listing_items);

$listing_obj = me_get_listing($listing['ID']);

// $listing_cat = get_the_terms($listing_obj->ID, 'listing_category');

$author_id = $listing_obj ? $listing_obj->post_author : '';
?>
<div class="marketengine-content">
	<?php me_print_notices(); ?>
	<div class="me-order-detail">
		<?php
			me_get_template( 'purchases/order-detail', array('transaction' => $transaction) );
		?>
	</div>
	<div class="me-row">
		<div class="me-col-md-9">

			<?php
			me_get_template( 'purchases/order-listing', array('listing_obj' => $listing_obj, 'transaction' => $transaction, 'cart_listing' => $listing) );
			me_get_template( 'user-info', array('class' => 'me-authors-xs me-visible-sm me-visible-xs', 'author_id' => $author_id ) );
			me_get_template( 'purchases/order-action', array('order' => $transaction) );
			?>

		</div>
		<div class="me-col-md-3 me-hidden-sm me-hidden-xs">
			<?php
				me_get_template( 'user-info', array('author_id' => $author_id)  );
			?>
		</div>
	</div>
	<?php
		me_get_template( 'purchases/listing-slider', array('curr_listing' => $listing['ID']) );
	?>
</div>
<!--// marketengine-content -->