<div class="marketengine-group-field">
	<div class="marketengine-input-field">
	    <label class="text"><?php _e("Listing title", "enginethemes");?></label>
	    <input type="text" name="post_title" value="" class="required">
	</div>
</div>
<div class="marketengine-group-field">
	<div class="marketengine-textarea-field">
		<label class="text"><?php _e("Description", "enginethemes");?></label>
		<?php wp_editor(
			    '',
			    'post_content',
			    array(
			        'quicktags' => false,
			        'media_buttons' => false,
			        'wpautop' => false,
			        'teeny' => true,
			    )
			);
		?>
	</div>
</div>