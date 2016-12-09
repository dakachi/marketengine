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
		case 'date' :
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
	<!-- <div class="me-row">
		<div class="me-col-sm-3">
			<div class="me-cf-title">
				<p>Custom field text</p>
				<span>Description: lorem ipsum dolor sit amet, consectetuer adpiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</span>
			</div>
		</div>
		<div class="me-col-sm-9">
			<div class="me-cf-content">
				<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut</p>
			</div>
		</div>
	</div>

	<div class="me-row">
		<div class="me-col-sm-3">
			<div class="me-cf-title">
				<p>Custom field date</p>
			</div>
		</div>
		<div class="me-col-sm-9">
			<div class="me-cf-content">
				<p>1/1/2017</p>
			</div>
		</div>
	</div>

	<div class="me-row">
		<div class="me-col-sm-3">
			<div class="me-cf-title">
				<p>Custom field number</p>
			</div>
		</div>
		<div class="me-col-sm-9">
			<div class="me-cf-content">
				<p>1001</p>
			</div>
		</div>
	</div>

	

	<div class="me-row">
		<div class="me-col-sm-3">
			<div class="me-cf-title">
				<p>Custom field checkbox</p>
				<span>Description: lorem ipsum dolor sit amet, consectetuer adpiscing elit.</span>
			</div>
		</div>
		<div class="me-col-sm-9">
			<div class="me-cf-content">
				<ul>
					<li>- Lorem ipsum dolor sit amet</li>
					<li>- Lorem ipsum</li>
					<li>- Lorem ipsum dolor sit</li>
				</ul>
			</div>
		</div>
	</div> -->

</div>