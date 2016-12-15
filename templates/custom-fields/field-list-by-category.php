<?php
	$customfields = me_cf_get_fields_by_category($_REQUEST['category-id']);

	if(!empty($customfields)) :
		foreach($customfields as $key => $field) :
			extract($field);
			$affected_cats_name = me_cf_get_affected_categories_html($field_id);
?>

	<li class="me-cf-item">
		<div class="me-cf-row">
			<div class="me-cf-row-wrap">
				<div class="me-cf-col-title"><?php echo esc_attr($field_name); ?></div>
				<div class="me-cf-col-number">
					<?php echo $count; ?>
					<div class="me-cf-action">
						<a class="me-cf-show" href="" title="<?php _e('Show\Hide custom field', 'enginethemes'); ?>"><i class="icon-me-eye"></i><i class="icon-me-eye-slash"></i></a>
						<a class="me-cf-edit" href="<?php echo add_query_arg(array('view' => 'edit', 'custom-field-id' => $field_id), remove_query_arg('category-id')); ?>" title="<?php _e('Edit custom field', 'enginethemes'); ?>"><i class="icon-me-edit-pad"></i></a>
						<a data-count="<?php echo $count; ?>" class="me-cf-remove" href="<?php echo add_query_arg(array('action' => 'remove-from-category', '_wp_nonce' => wp_create_nonce('remove-from-category'), 'custom-field-id' => $field_id)); ?>" title="<?php _e('Remove from this category', 'enginethemes'); ?>"><i class="icon-me-trash"></i></a>
					</div>
				</div>
			</div>
		</div>
		<div class="me-cf-row-content">
			<p><span><?php _e('Field title:', 'enginethemes'); ?></span><?php echo $field_title; ?></p>
			<p><span><?php _e('Field type:', 'enginethemes'); ?></span><?php echo $field_type; ?></p>
			<p><span><?php _e('Default value:', 'enginethemes'); ?></span><?php echo isset($field_default_value) && !empty($field_default_value) ? $field_default_value : 'N/A'; ?></p>
			<?php /*<p><span><?php _e('Options:', 'enginethemes'); ?></span></p>*/ ?>
			<?php do_action('me_load_inputs_for_view', $field); ?>

			<p><span><?php _e('Required:', 'enginethemes'); ?></span><?php echo $field_constraint ? __('Yes', 'enginethemes') : __('No', 'enginethemes') ; ?></p>
			<p><span><?php _e('Available in:', 'enginethemes'); ?></span><?php echo $affected_cats_name; ?></p>
			<p><span><?php _e('Help text:', 'enginethemes'); ?></span><?php echo $field_help_text ? $field_help_text : 'N/A'; ?></p>
			<p><span><?php _e('Description:', 'enginethemes'); ?></span><?php echo $field_description ? $field_description : 'N/A'; ?></p>
		</div>
	</li>

	<?php endforeach; ?>
	<?php endif; ?>