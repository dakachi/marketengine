<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

?>
<div class="me-custom-field">
<?php
foreach ($fields as $field) :
	switch ($field['field_type']) {
		case 'text':
		case 'textarea':
		case 'number' :
		
		$value = me_field($field['field_name']);
		if(!$value) break;
		?>
		<div class="me-row">
			<div class="me-col-sm-3">
				<div class="me-cf-title">
					<p><?php echo $field['field_title'] ?></p>
					<span><?php echo $field['field_description'] ?></span>
				</div>
			</div>
			<div class="me-col-sm-9">
				<div class="me-cf-content">
					<p><?php me_the_field($field['field_name']); ?></p>
				</div>
			</div>
		</div>
		<?php
			break;
		case 'date' : 
		$value = me_field($field['field_name']);
		if(!$value) break;

		$date = date_i18n( get_option('date_format'), strtotime($value) );

		?>
		<div class="me-row">
			<div class="me-col-sm-3">
				<div class="me-cf-title">
					<p><?php echo $field['field_title'] ?></p>
					<span><?php echo $field['field_description'] ?></span>
				</div>
			</div>
			<div class="me-col-sm-9">
				<div class="me-cf-content">
					<p><?php echo $date; ?></p>
				</div>
			</div>
		</div>
		<?php
		case 'radio':
		case 'checkbox':
		case 'select': 
		case 'multiselect': 
		?>
		<div class="me-row">
			<div class="me-col-sm-3">
				<div class="me-cf-title">
					<p>Custom field dropdown</p>
					<span>Description: lorem ipsum dolor sit amet.</span>
				</div>
			</div>
			<div class="me-col-sm-9">
				<div class="me-cf-content">
					<ul>
						<li>Lorem ipsum dolor sit amet</li>
						<li>Lorem ipsum</li>
						<li>Lorem ipsum dolor sit</li>
					</ul>
				</div>
			</div>
		</div>

		<?php 
		default:
			break;
	}
endforeach;
?>
</div>