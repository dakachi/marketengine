<?php if($inquiry) :  ?>

<?php

	do_action('marketengine_before_inquiry_form', $inquiry);

	$user_id = get_current_user_id();
	$listing = me_get_listing($inquiry->post_parent);
	$message_query = new ME_Message_Query(array('post_type' => 'message', 'post_parent' => $inquiry->ID, 'showposts' => 12));
	$messages = array_reverse ($message_query->posts);
?>
	<div class="marketengine marketengine-contact">
		<?php me_print_notices(); ?>
		<div class="me-contact-listing-wrap">

			<?php me_get_template('inquiry/listing-info', array('listing' => $listing, 'showposts' => -1)); ?>

			<div class="me-contact-listing">
				<div class="me-row">
					<div class="me-col-md-3 me-col-md-pull-9 me-col-sm-4 me-col-sm-pull-8">
						<?php if($inquiry->receiver == $user_id) : ?>

							<?php me_get_template('inquiry/contact-list', array('listing' => $listing)); ?>

						<?php else : ?>

							<?php me_get_template('user-info', array('author_id' => $inquiry->receiver)); ?>

						<?php endif; ?>
					</div>
					<div class="me-col-md-9 me-col-md-push-3 me-col-sm-8 me-col-sm-push-4" id="upload_message_file">
						<div class="me-contact-messages-wrap">

							<div class="me-contact-message-user">
								<p><?php echo get_the_author_meta( 'display_name', $inquiry->receiver ); ?></p>
							</div>

							<div class="me-contact-header">
								<ul class="me-contact-tabs">
									<li class="me-contact-listing-tabs"><span><?php _e("Listing info", "enginethemes"); ?></span></li>
									<li class="me-contact-user-tabs"><span><?php _e("Seller info", "enginethemes"); ?></span></li>
								</ul>
							</div>

							<div class="inquiry-message-wrapper">
								<div id="messages-container" class="me-contact-messages" style="overflow: hidden;overflow-y: scroll; max-height: 500px;">

									<?php if($message_query->max_num_pages > 1) { me_get_template('inquiry/load-message-button'); } ?>

									<ul class="me-contact-messages-list" >

									<?php if( $messages ) : ?>
										<?php foreach ($messages  as $key => $message) : ?>
										<?php me_get_template('inquiry/message-item', array('message' => $message)); ?>
										<?php endforeach; ?>
									<?php elseif($listing) : ?>
										<?php me_get_template('inquiry/message-item-notfound', array('author' => $listing->get_author()) ); ?>
									<?php endif; ?>
									<?php /*
									<?php if( $listing ) : ?>
										<?php if( !$listing->is_available() ) : ?>
										<li class="me-inquires-listing-archived"><i class="icon-me-minus-circle"></i><span><?php _e('This listing has been archived', 'enginethemes'); ?></span></li>
										<?php endif; ?>
									<?php else : ?>
										<li class="me-inquires-listing-archived"><i class="icon-me-minus-circle"></i><span><?php _e('This listing has been deleted', 'enginethemes'); ?></span></li>
									<?php endif; ?>
									*/ ?>
									</ul>

								</div>

								<div class="me-message-typing">

								<?php if($listing && $listing->is_available()) : ?>

									<?php me_get_template('inquiry/send-message-form', array('listing' => $listing, 'inquiry' => $inquiry)); ?>

								<?php else: ?>

									<?php me_get_template('inquiry/send-message-disabled'); ?>

								<?php endif; ?>
								</div>
							</div>
						</div>
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
	    // (function ($) {
	    //     $(document).ready(function(){
	    //         $('#upload_message_file').messageUploader({
	    //             multi: false,
	    //             removable : false,
	    //             name: 'message_file',
	    //             maxsize : "2mb",
	    //             listing_id : "<?php echo $listing ? $listing->get_id() : ''; ?>",
	    //             inquiry_id : "<?php echo $inquiry->ID; ?>",
	    //             extension: 'jpg,jpeg,gif,png,pdf,doc,docx,xls,xlsx,txt',
	    //             upload_url: '<?php echo admin_url('admin-ajax.php') . '?nonce=' . wp_create_nonce('marketengine') ?>'
	    //         });
	    //     });
	    // })(jQuery);
	</script>

<?php
do_action('marketengine_after_inquiry_form', $inquiry);
 ?>

<?php endif; ?>