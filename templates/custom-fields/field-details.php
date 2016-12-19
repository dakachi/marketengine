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
					<p><?php echo $value; ?></p>
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
			break;
			
		case 'single-select': 
		$value = me_field($field['field_name'], null, array('fields' => 'names'));
		if(empty($value)) break;
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
					<?php echo $value[0]; ?>
				</div>
			</div>
		</div>

		<?php 
		break;
		case 'checkbox':
		case 'multi-select': 
		$value = me_field($field['field_name'], null, array('fields' => 'names'));
		if(empty($value)) break;
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
					<ul>
						<li>
						<?php echo join('</li><li>', $value); ?>
						</li>
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