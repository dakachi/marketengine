<?php
	$action_array = array();
	switch ($post_status) {
		case 'publish':
?>
	<span data-status="me-paused" class="icon-me-pause"></span>
	<span class="icon-me-edit"></span>
	<span data-status="me-archived" class="icon-me-delete"></span>
<?php
			break;
		case 'me-archived':
?>
	<span data-status="publish" class="icon-me-resume"></span>
<?php
			break;
		case 'me-pending':
?>
	<span class="icon-me-edit"></span>
	<span data-status="me-archived" class="icon-me-delete"></span>
<?php
			break;
		case 'me-pause':
?>
	<span data-status="publish" class="icon-me-step-forward"></span>
	<span class="icon-me-edit"></span>
	<span data-status="me-archived" class="icon-me-delete"></span>
<?php
			break;
		default:
?>
	<span data-status="publish" class="icon-me-play"></span>
	<span class="icon-me-edit"></span>
	<span data-status="me-archived" class="icon-me-delete"></span>
<?php
			break;
	}
?>