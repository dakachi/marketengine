<?php
$parent_cat = $_REQUEST['parent-cat'];

$child_categories = get_terms( array('taxonomy' => 'listing_category', 'hide_empty' => false, 'parent' => $parent_cat) );
if(!$parent_cat || empty($child_categories)) : ?>
	<div class="marketengine-select-field">
	    <label class="text"><?php _e("Sub-category", "enginethemes"); ?></label>
	    <select class="sub-category" name="sub_cat">
	    	<option value=""><?php _e("Select sub category", "enginethemes"); ?></option>
	    </select>
	</div>
<?php else: ?>
	<div class="marketengine-select-field">
	    <label class="text"><?php _e("Sub-category", "enginethemes"); ?></label>
	    <select class="sub-category" name="sub_cat">
	    	<option value=""><?php _e("Select sub category", "enginethemes"); ?></option>
	    	<?php foreach ($child_categories as $key => $child_cat) : ?>
	    	<option value="<?php echo $child_cat->term_id; ?>"><?php echo $child_cat->name; ?></option>
	    	<?php endforeach; ?>
	    </select>
	</div>
<?php endif; ?>