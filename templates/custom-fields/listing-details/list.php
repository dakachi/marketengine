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