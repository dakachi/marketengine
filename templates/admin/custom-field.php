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
?>

<div class="me-custom-field">
	<h2>List of Custom Field</h2>
	<div class="me-cf-by-category">
		<label>
			<span>Group by</span>
			<select name="" id="" onchange="window.location.href=this.value;">
				<option value="#">All category</option>
				<option value="#">Category111</option>
				<option value="#">Category22</option>
				<option value="#">Category3455</option>
			</select>
		</label>
	</div>
	<a class="me-add-custom-field-btn" href="">Add New Custom Field</a>

	<div class="me-custom-field-list">
		<ul class="me-cf-list">
			<li class="">
				<div class="me-cf-row-header">
					<div class="me-cf-row-wrap">
						<div class="me-cf-col-title">Field Title</div>
						<div class="me-cf-col-number">Number of<br/>Affected Categories</div>
					</div>
				</div>
			</li>

			<li class="me-cf-item">
				<div class="me-cf-row">
					<div class="me-cf-row-wrap">
						<div class="me-cf-col-title">Custom field 1</div>
						<div class="me-cf-col-number">
							12
							<div class="me-cf-action">
								<a class="me-cf-show" href="" title="Show\Hide custom field"><i class="icon-me-eye"></i><i class="icon-me-eye-slash"></i></a>
								<a class="me-cf-edit" href="" title="Edit custom field"><i class="icon-me-edit-pad"></i></a>
								<a class="me-cf-remove" href="" title="Remove from this category"><i class="icon-me-trash"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="me-cf-row-content">
					<p><span>Field title:</span>Custom field 4</p>
					<p><span>Field type:</span>Checkbox</p>
					<p><span>Default value:</span>1</p>
					<p><span>Options:</span>Option1, Option 2</p>
					<p><span>Required:</span>No</p>
					<p><span>Available in:</span>Category 1, Category 2, Category 3</p>
					<p><span>Help text:</span>N/A</p>
					<p><span>Description:</span>N/A</p>
				</div>
			</li>
			<li class="me-cf-item">
				<div class="me-cf-row">
					<div class="me-cf-row-wrap">
						<div class="me-cf-col-title">Custom field 1</div>
						<div class="me-cf-col-number">
							12
							<div class="me-cf-action">
								<a class="me-cf-show" href="" title="Show\Hide custom field"><i class="icon-me-eye"></i><i class="icon-me-eye-slash"></i></a>
								<a class="me-cf-edit" href="" title="Edit custom field"><i class="icon-me-edit-pad"></i></a>
								<a class="me-cf-remove" href="" title="Remove from this category"><i class="icon-me-trash"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="me-cf-row-content">
					<p><span>Field title:</span>Custom field 4</p>
					<p><span>Field type:</span>Checkbox</p>
					<p><span>Default value:</span>1</p>
					<p><span>Options:</span>Option1, Option 2</p>
					<p><span>Required:</span>No</p>
					<p><span>Available in:</span>Category 1, Category 2, Category 3, Category 4</p>
					<p><span>Help text:</span>N/A</p>
					<p><span>Description:</span>N/A</p>
				</div>
			</li>
			<li class="me-cf-item">
				<div class="me-cf-row">
					<div class="me-cf-row-wrap">
						<div class="me-cf-col-title">Custom field 1</div>
						<div class="me-cf-col-number">
							12
							<div class="me-cf-action">
								<a class="me-cf-show" href="" title="Show\Hide custom field"><i class="icon-me-eye"></i><i class="icon-me-eye-slash"></i></a>
								<a class="me-cf-edit" href="" title="Edit custom field"><i class="icon-me-edit-pad"></i></a>
								<a class="me-cf-remove" href="" title="Remove from this category"><i class="icon-me-trash"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="me-cf-row-content">
					<p><span>Field title:</span>Custom field 4</p>
					<p><span>Field type:</span>Checkbox</p>
					<p><span>Default value:</span>1</p>
					<p><span>Options:</span>Option1, Option 2</p>
					<p><span>Required:</span>No</p>
					<p><span>Available in:</span>Category 1, Category 2, Category 3, Category 4</p>
					<p><span>Help text:</span>N/A</p>
					<p><span>Description:</span>N/A</p>
				</div>
			</li>
		</ul>
	</div>
	</div>