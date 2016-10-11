<?php if($inquiry) :  ?>

<?php 
	$user_id = get_current_user_id();
	$listing = me_get_listing($inquiry->post_parent);
	$messages = me_get_messages(array('post_type' => 'message', 'post_parent' => $inquiry->ID)); 
	// TODO: kiem tra da co inquiry chua, neu có thi tao message form, chua thi tao inquiry form
	// inquiry se nam giu thong tin listing va lien ket cac message lai voi nhau

	// danh sach inquiry chi co the sap xep theo tra loi moi nhat
	// new message sent and read ??
	$messages = array_reverse ($messages);
?>
	<div class="marketengine">
		<?php me_print_notices(); ?>
		<div class="me-contact-listing-wrap">

			<?php me_get_template('inquiry/listing-info', array('listing' => $listing, 'showposts' => -1)); ?>

			<div class="me-contact-listing">
				<div class="me-row">
					<div class="me-col-md-9 me-col-sm-8">
						<div class="me-contact-messages-wrap">
							<div class="me-contact-message-user">
								<h2><?php echo get_the_author_meta( 'display_name', $listing->get_author() ); ?></h2>
							</div>
							<div class="me-contact-messages" style="max-height: 500px;">
								<ul id="messages-container" class="me-contact-messages-list" style="overflow: hidden;overflow-y: scroll; max-height: 500px;">

									<?php foreach ($messages  as $key => $message) : ?>
										<?php me_get_template('inquiry/message-item', array('message' => $message)); ?>
									<?php endforeach; ?>

								</ul>
							</div>
							<div class="me-message-typing">
							<form method="post">
								<textarea required name="content"></textarea>
								<span class="me-message-send-btn"><i class="icon-me-attach"></i></span>

								<?php wp_nonce_field( 'me-inquiry-message' ); ?>
								<input type="hidden" name="inquiry_listing" value="<?php echo $listing->get_id(); ?>" />
								<input type="hidden" name="inquiry_id" value="<?php echo $inquiry->ID; ?>" />
								<input type="submit" value="<?php _e("Send", "enginethemes"); ?>" />

							</form>
							</div>
						</div>
					</div>
					<div class="me-col-md-3 me-col-sm-4 ">
					<?php if($listing->post_author == $user_id) : ?>

						<?php me_get_template('inquiry/contact-list', array('listing' => $listing)); ?>

					<?php else : ?>

						<?php me_get_template('seller-info', array('author_id' => $listing->post_author)); ?>

					<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var objDiv = document.getElementById("messages-container");
		objDiv.scrollTop = objDiv.scrollHeight;
	</script>
<?php endif; ?>