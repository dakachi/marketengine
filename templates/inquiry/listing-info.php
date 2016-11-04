<div class="me-orderlisting-info">
<?php if($listing) : ?>
	<a class="me-orderlisting-thumbs" href="<?php echo $listing->get_permalink(); ?>">
		<?php echo $listing->get_listing_thumbnail(); ?>
	</a>
	<div class="me-listing-info">
		<h2>
			<a href="<?php echo $listing->get_permalink(); ?>">
				<?php echo esc_html( $listing->get_title() ); ?>
			</a>
		</h2>

		<?php echo $listing->get_short_description(); ?>

	</div>
<?php else: ?>
	<p><?php _e('Deleted listing'); ?></p>
<?php endif; ?>
</div>