<div class="marketengine-group-field">
	<div class="marketengine-input-field">
	    <!-- <label class="text"><?php _e("Tags", "enginethemes");?>&nbsp;<small><?php _e("(optional)", "enginethemes");?></small></label>
	    <input type="text" name="listing_tag">
	    <div class="marketengine-tags">
	    	<span class="me-label-tags">Jambo<i class="icon-cancel"></i></span>
	    	<span class="me-label-tags">Movies<i class="icon-cancel"></i></span>
	    </div> -->
	    <?php
	    	$listing_tag = !empty($_POST['listing_tag']) ? $_POST['listing_tag'] : '';
	    	me_post_tags_meta_box($listing_tag, 'listing_tag'); 
	    ?>
	</div>
</div>