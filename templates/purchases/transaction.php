<?php

$listing_item = $transaction->get_listing();
$listing_obj = me_get_listing($listing_item['_listing_id'][0]);

$listing_cat = get_the_terms($listing_obj->ID, 'listing_category');

$author_id = $listing_obj->post_author;
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
				me_get_template( 'purchases/order-listing', array('listing_obj' => $listing_obj, 'transaction' => $transaction) );
			?>
			<?php
				me_get_template( 'user-info', array('class' => 'me-authors-xs me-visible-sm me-visible-xs', 'author_id' => $author_id ) );
			?>

			<div class="me-transaction-dispute">
				<p><?php echo __('In the case you find out something unexpected. Please tell us your problems.', 'enginethemes'); ?></p>
				<a href="<?php echo me_get_page_id('dispute'); ?>" class=""><?php _e('DISPUTE', 'enginethemes'); ?></a>
			</div>

		</div>
		<div class="me-col-md-3 me-hidden-sm me-hidden-xs">
			<?php
				me_get_template( 'user-info', array('author_id' => $author_id)  );
			?>
		</div>
	</div>
	<?php
		me_get_template( 'purchases/listing-slider', array('listing_cat' => $listing_cat, 'curr_listing' => $listing_item) );
	?>
</div>
<!--// marketengine-content -->