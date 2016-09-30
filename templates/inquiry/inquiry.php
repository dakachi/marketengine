<?php if($listing) : ?>

<?php $messages = new ME_Message_Query(array('post_type' => 'inquiry')); ?>
<div class="marketengine">
	<?php me_print_notices(); ?>
	<div class="me-contact-listing-wrap">
		
		<?php me_get_template('inquiry/listing-info', array('listing' => $listing)); ?>

		<div class="me-contact-listing">
			<div class="me-row">
				<div class="me-col-md-9 me-col-sm-8">
					<div class="me-contact-messages-wrap">
						<div class="me-contact-message-user">
							<h2><?php echo get_the_author_meta( 'display_name', $listing->get_author() ); ?></h2>
						</div>
						<div class="me-contact-messages" style="max-height: 500px;">
							<ul class="me-contact-messages-list" style="overflow: hidden;overflow-y: scroll; max-height: 500px;">
								
								<?php while($messages->have_posts()) : ?>
									
									<?php $messages->the_post(); ?> 
									<?php me_get_template('inquiry/message-item'); ?>

								<?php endwhile; ?>

							</ul>
						</div>
						<div class="me-message-typing">
						<form method="post">
							<textarea required name="content"></textarea>
							<span class="me-message-send-btn"><i class="icon-me-attach"></i></span>
							
							<?php wp_nonce_field( 'me-post-inquiry' ); ?>
							<input type="hidden" name="inquiry_listing" value="<?php echo $listing->get_id(); ?>" />

							<input type="submit" value="<?php _e("Send", "enginethemes"); ?>" />
							
						</form>
						</div>
					</div>
				</div>
				<div class="me-col-md-3 me-col-sm-4 ">
					<?php me_get_template('inquiry/contact-list', array('listing' => $listing)); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php endif; ?>