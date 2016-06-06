<?php 
$parent_categories = get_terms( array('taxonomy' => 'listing_category', 'hide_empty' => false, 'parent' => 0) );
?>
<script type="data/json"><?php echo json_encode($parent_categories) ?></script>
<div id="marketengine-post-step-1" class="marketengine-post-step active select-category">
	<div class="marketengine-group-field" id="me_parent_cat_container">
		<div class="marketengine-select-field">
		    <label class="text"><?php _e("Category", "enginethemes"); ?></label>
		    <select class="parent-category" name="parent_cat">
		    	<option value=""><?php _e("Select your category", "enginethemes"); ?></option>
		    	<?php foreach ($parent_categories as $key => $parent_cat) : ?>
		    	<option value="<?php echo $parent_cat->term_id; ?>"><?php echo $parent_cat->name; ?></option>
		    	<?php endforeach; ?>
		    </select>
		</div>
	</div>
	<div class="marketengine-group-field" id="me_child_cat_containcer">
		<div class="marketengine-select-field">
		    <label class="text"><?php _e("Sub-category", "enginethemes"); ?></label>
		    <select class="sub-category" name="sub_cat">
		    	<option value=""><?php _e("Select sub category", "enginethemes"); ?></option>
		    </select>
		</div>
	</div>
</div>
<?php
