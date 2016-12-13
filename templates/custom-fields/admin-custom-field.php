<?php
/**
 * The templates for displaying custom field manage page
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 *
 * @since 		1.0.1
 */
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

$categories = me_get_listing_categories();

?>

<div class="me-custom-field">
	<h2><?php _e('List of Custom Field', 'enginethemes'); ?></h2>
	<?php me_print_notices(); ?>
	<div class="me-cf-by-category">
		<label>
			<span><?php _e('Group by', 'enginethemes'); ?></span>
			<?php $link = remove_query_arg('paged'); ?>
			<select name="" id="" onchange="window.location.href=this.value;">
				<option value="<?php echo me_custom_field_page_url(); ?>"><?php _e('All category', 'enginethemes'); ?></option>

			<?php foreach($categories as $key => $category) : ?>
				<option <?php selected(isset($_REQUEST['category-id']) && $key==$_REQUEST['category-id']); ?> value="<?php echo add_query_arg(array('view' => 'group-by-category', 'category-id' => $key), $link); ?>"><?php echo $category; ?></option>
			<?php endforeach; ?>
			</select>
		</label>
	</div>
	<a class="me-add-custom-field-btn" href="<?php echo add_query_arg('view', 'add'); ?>"><?php _e('Add New Custom Field', 'enginethemes'); ?></a>

	<div class="me-custom-field-list">
		<ul class="me-cf-list">
			<li class="">
				<div class="me-cf-row-header">
					<div class="me-cf-row-wrap">
						<div class="me-cf-col-title"><?php _e('Field Name', 'enginethemes'); ?></div>
						<div class="me-cf-col-number"><?php _e('Number of<br/>Affected Categories', 'enginethemes'); ?></div>
					</div>
				</div>
			</li>

		<?php
			$customfields = me_cf_fields_query($_REQUEST);
			if($customfields['found_posts']) :
				foreach($customfields['fields'] as $key => $field) :
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
								<a class="me-cf-edit" href="<?php echo add_query_arg(array('view' => 'edit', 'custom-field-id' => $field_id)); ?>" title="<?php _e('Edit custom field', 'enginethemes'); ?>"><i class="icon-me-edit-pad"></i></a>
								<a class="me-cf-remove" href="<?php echo add_query_arg(array('action' => 'delete-custom-field', '_wp_nonce' => wp_create_nonce('delete-custom-field'), 'custom-field-id' => $field_id)); ?>" title="<?php _e('Remove from this category', 'enginethemes'); ?>"><i class="icon-me-trash"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="me-cf-row-content">
					<p><span><?php _e('Field title:', 'enginethemes'); ?></span><?php echo $field_title; ?></p>
					<p><span><?php _e('Field type:', 'enginethemes'); ?></span><?php echo $field_type; ?></p>
					<?php if($field_type != 'text' && $field_type != 'textarea') : ?>
					<p><span><?php _e('Default value:', 'enginethemes'); ?></span><?php echo isset($field_default_value) && !empty($field_default_value) ? $field_default_value : 'N/A'; ?></p>
					<?php endif; ?>
					<?php /*<p><span><?php _e('Options:', 'enginethemes'); ?></span></p>*/ ?>
					<?php do_action('me_load_inputs_for_view', $field); ?>

					<p><span><?php _e('Required:', 'enginethemes'); ?></span><?php echo (strpos($field_constraint, 'equired')) ? __('Yes', 'enginethemes') : __('No', 'enginethemes') ; ?></p>
					<p><span><?php _e('Available in:', 'enginethemes'); ?></span><?php echo $affected_cats_name; ?></p>
					<p><span><?php _e('Help text:', 'enginethemes'); ?></span><?php echo $field_help_text ? $field_help_text : 'N/A'; ?></p>
					<p><span><?php _e('Description:', 'enginethemes'); ?></span><?php echo $field_description ? $field_description : 'N/A'; ?></p>
				</div>
			</li>

			<?php endforeach; ?>
			<?php endif; ?>
		</ul>
	</div>

	<div class="me-pagination-wrap">
		<span class="me-paginations">
		<?php marketengine_cf_pagination( $customfields ); ?>
		</span>
	</div>
</div>