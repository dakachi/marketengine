<?php if($inquiry) :  ?>

<?php
	$user_id = get_current_user_id();
	$listing = me_get_listing($inquiry->post_parent);
	$message_query = new ME_Message_Query(array('post_type' => 'message', 'post_parent' => $inquiry->ID, 'showposts' => 10));
	$messages = array_reverse ($message_query->posts);
?>
	<div class="marketengine">
		<?php me_print_notices(); ?>
		<div class="me-contact-listing-wrap">

			<?php me_get_template('inquiry/listing-info', array('listing' => $listing, 'showposts' => -1)); ?>

			<div class="me-contact-listing">
				<div class="me-row">
					<div class="me-col-md-9 me-col-sm-8" id="upload_message_file">
						<div class="me-contact-messages-wrap inquiry-message-wrapper">
							<div class="me-contact-message-user">
								<h2><?php echo get_the_author_meta( 'display_name', $listing->get_author() ); ?></h2>
							</div>
							<div id="messages-container"  class="me-contact-messages" style="overflow: hidden;overflow-y: scroll; max-height: 500px;">
								<?php if($message_query->max_num_pages > 1) { me_get_template('inquiry/load-message-button'); } ?>
								<ul class="me-contact-messages-list" >
									<?php foreach ($messages  as $key => $message) : ?>
										<?php me_get_template('inquiry/message-item', array('message' => $message)); ?>
									<?php endforeach; ?>

								</ul>
							</div>
							<div class="me-message-typing">
								<form method="post" id="send-message">
									<textarea class="required" required name="content"></textarea>
									<span id="me-message-send-btn" class="me-message-send-btn"><i class="icon-me-attach"></i></span>

									<?php wp_nonce_field( 'me-inquiry-message', '_msg_wpnonce' ); ?>
									<input type="hidden" name="inquiry_listing" value="<?php echo $listing->get_id(); ?>" />
									<input type="hidden" name="inquiry_id" value="<?php echo $inquiry->ID; ?>" />
								</form>
							</div>
						</div>
					</div>
					<div class="me-col-md-3 me-col-sm-4 ">
					<?php if($listing->post_author == $user_id) : ?>

						<?php me_get_template('inquiry/contact-list', array('listing' => $listing)); ?>

					<?php else : ?>

						<?php me_get_template('user-info', array('author_id' => $listing->post_author)); ?>

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
	<script>
	    (function ($) {
	        $(document).ready(function(){
	            $('#upload_message_file').messageUploader({	                
	                multi: false,
	                removable : false,
	                name: 'message_file',
	                listing_id : "<?php echo $listing->get_id(); ?>",
	                inquiry_id : "<?php echo $inquiry->ID; ?>",
	                extension: 'jpg,jpeg,gif,png,pdf,doc,zip,docx',
	                upload_url: '<?php echo admin_url('admin-ajax.php') . '?nonce=' . wp_create_nonce('marketengine') ?>'
	            });
	        });
	    })(jQuery);
	</script>
<?php endif; ?>