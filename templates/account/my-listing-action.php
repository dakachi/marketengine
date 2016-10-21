<?php
	switch ($listing_status->name) {
		case 'publish':
?>
	<span data-status="me-paused" class="icon-me-pause"></span>
	<a href=""><span class="icon-me-edit"></span></a>
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
	<a href=""><span class="icon-me-edit"></span></a>
	<span data-status="me-archived" class="icon-me-delete"></span>
<?php
			break;
		case 'me-paused':
?>
	<span data-status="publish" class="icon-me-step-forward"></span>
	<a href=""><span class="icon-me-edit"></span></a>
	<span data-status="me-archived" class="icon-me-delete"></span>
<?php
			break;
		default:
?>
	<span data-status="publish" class="icon-me-play"></span>
	<a href=""><span class="icon-me-edit"></span></a>
	<span data-status="me-archived" class="icon-me-delete"></span>
<?php
			break;
	}
?>