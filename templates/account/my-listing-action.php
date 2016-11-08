<?php
	switch ($listing_status->name) {
		case 'publish':
?>
	<?php /*<span data-status="me-paused" class="icon-me-pause"></span> */ ?>
	<a href="<?php echo me_get_auth_url('listing-id', $listing_id); ?>"><span class="me-icon-edit"><i class="icon-me-edit"></i>Edit</span></a>
	<span data-status="me-archived" class="me-icon-delete"><i class="icon-me-delete"></i>Archive</span>
<?php
			break;
		case 'me-archived':
?>
	<a href="<?php echo me_get_auth_url('listing-id', $listing_id); ?>"><span class="me-icon-resume"><i class="icon-me-resume"></i>Restore</span></a>
<?php
			break;
		case 'me-pending':
?>
	<a href="<?php echo me_get_auth_url('listing-id', $listing_id); ?>"><span class="me-icon-edit"><i class="icon-me-edit"></i>Edit</span></a>
	<span data-status="me-archived" class="me-icon-delete"><i class="icon-me-delete"></i>Archive</span>
<?php
		break;
		/* case 'me-paused':
?>
	<span data-status="publish" class="icon-me-step-forward"></span>
	<a href="<?php echo me_get_auth_url('listing-id', $listing_id); ?>"><span class="icon-me-edit"></span></a>
	<span data-status="me-archived" class="icon-me-delete"></span>
<?php
			break; */
		default:
?>
	<span data-status="publish" class="icon-me-play"></span>
	<a href="<?php echo me_get_auth_url('listing-id', $listing_id); ?>"><span class="me-icon-edit"><i class="icon-me-edit"></i>Edit</span></a>
	<span data-status="me-archived" class="me-icon-delete"><i class="icon-me-delete"></i>Archive</span>
<?php
		break;
	}
?>