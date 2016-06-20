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
<?php do_action('marketengine_before_post_listing_tags_form'); ?>
<div class="marketengine-group-field">

	<?php do_action('marketengine_post_listing_tags_form_start'); ?>

	<div class="marketengine-input-field">
	    <?php
	    	$listing_tag = !empty($_POST['listing_tag']) ? $_POST['listing_tag'] : '';
	    	me_post_tags_meta_box($listing_tag, 'listing_tag'); 
	    ?>
	</div>

	<?php do_action('marketengine_post_listing_tags_form_end'); ?>
	
</div>
<?php do_action('marketengine_after_post_listing_tags_form'); ?>