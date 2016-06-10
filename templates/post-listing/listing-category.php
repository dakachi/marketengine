<?php 
$parent_categories = get_terms( array('taxonomy' => 'listing_category', 'hide_empty' => false, 'parent' => 0) );
?>
<script type="data/json"><?php echo json_encode($parent_categories) ?></script>
<div class="marketengine-post-step active select-category">
	<div class="marketengine-group-field" id="me-parent-cat-container">
		<div class="marketengine-select-field">
		    <label class="text"><?php _e("Category", "enginethemes"); ?></label>
		    <select class="select-category  parent-category" name="parent_cat">
		    	<option value=""><?php _e("Select your category", "enginethemes"); ?></option>
		    	<?php foreach ($parent_categories as $key => $parent_cat) : ?>
		    	<option value="<?php echo $parent_cat->term_id; ?>"><?php echo $parent_cat->name; ?></option>
		    	<?php endforeach; ?>
		    </select>
		</div>
	</div>
	<div class="marketengine-group-field" id="me-sub-cat-container">
		<div class="marketengine-select-field">
		    <label class="text"><?php _e("Sub-category", "enginethemes"); ?></label>
		    <select class="select-category sub-category" name="sub_cat">
		    	<option value=""><?php _e("Select sub category", "enginethemes"); ?></option>
		    </select>
		</div>
	</div>
</div>
<?php
