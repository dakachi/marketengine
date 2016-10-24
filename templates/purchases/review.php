<div class="marketengine-content">
<form method="post" >
	<div class="me-review-listing">
		<h3><?php echo esc_html( get_the_title( $listing_id ) ); ?></h3>
		<div class="me-rating">
			<!-- <i class="icon-me-star-o"></i>
			<i class="icon-me-star-o"></i>
			<i class="icon-me-star-o"></i>
			<i class="icon-me-star-o"></i>
			<i class="icon-me-star-o"></i> -->
			<div class="do-rating" data-score="4"></div>
		</div>
		<p><?php _e("Share your review about this listing", "enginethemes"); ?></p>
		<textarea name="content"></textarea>
		<div class="me-review-submit">
			<input class="me-review-btn" type="submit" value="<?php _e("SUBMIT", "enginethemes"); ?>">
		</div>
		
		<a href="<?php echo remove_query_arg( 'action' ); ?>" class="me-backlink">&lt; <?php _e("Back to transaction detail", "enginethemes"); ?></a>
	</div>

	<input type="hidden" name="listing_id" value="<?php echo $listing_id; ?>">

	<?php wp_nonce_field( 'me-review' ); ?>

</form>
</div>