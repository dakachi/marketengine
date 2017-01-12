<div class="me-escalate-form">
	<form id="me-escalate-form" action="">
		<div class="me-escalate-box">
			<h3><?php _e("You tell us so far:", "enginethemes"); ?></h3>
			<ol class="">
				<li>You already got the item</li>
				<li>The item does not match description</li>
				<li>You want to get full refund</li>
			</ol>
		</div>
		<div class="me-escalate-box">
			<h3><?php _e("Please tell more about your problem", "enginethemes"); ?></h3>
			<textarea name="content" id="escalate-content" cols="30" rows="10"></textarea>
		</div>
		<div class="me-escalate-box">
			<h3><?php _e('Attachments (optional)', 'enginethemes'); ?></h3>
			<?php

		        ob_start();
		        if($dispute_files) {
		            foreach($dispute_files as $gallery) {
		                me_get_template('upload-file/multi-file-form', array(
		                    'image_id' => $gallery,
		                    'filename' => 'dispute_file',
		                    'close' => true
		                ));
		            }
		        }
		        $dispute_files = ob_get_clean();

		        me_get_template('upload-file/upload-form', array(
		            'id' => 'dispute-file',
		            'name' => 'dispute_file',
		            'source' => $dispute_files,
		            'button' => 'me-dipute-upload',
		            'multi' => true,
		            'maxsize' => esc_html( '2mb' ),
		            'maxcount' => 5,
		            'close' => true
		        ));
		    ?>
		</div>
		
		<?php wp_nonce_field('me-escalate_case'); ?>
		<?php wp_nonce_field('marketengine', 'me-dispute-file'); ?>

		<div class="me-escalate-submit">
			<input type="submit" class="me-escalate-submit-btn">
		</div>
		<a href="<?php echo remove_query_arg( 'action' ); ?>" class="me-backlink">
			&lt; <?php _e("Discard escalate", "enginethemes"); ?>
		</a>
	</form>
</div>