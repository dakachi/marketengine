<style type="text/css">
	.ac_results {
	    display: none;
	    margin: -1px 0 0;
	    padding: 0;
	    list-style: none;
	    position: absolute;
	    z-index: 10000;
	    border: 1px solid #5b9dd9;
	    background-color: #fff;
	}
</style>
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