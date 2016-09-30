<div class="me-orderlisting-info">
	<a class="me-orderlisting-thumbs" href="<?php echo $listing->get_permalink(); ?>">
		<?php echo $listing->get_listing_thumbnail(); ?>
	</a>
	<div class="me-listing-info">
		<h2>
			<a href="<?php echo $listing->get_permalink(); ?>">
				<?php echo esc_html( $listing->get_title() ); ?>
			</a>
		</h2>
		<p>
			<?php echo $listing->get_short_description(); ?>
		</p>
	</div>
</div>