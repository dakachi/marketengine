<?php
/**
 * 	The Template for displaying actions of seller.
 * 	This template can be overridden by copying it to yourtheme/marketengine/account/my-listing-action.php.
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 * @version     1.0.0
 */
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

$edit_url = me_get_endpoint_url( 'listing_id', $listing_id ,me_get_page_permalink('edit_listing'));

	switch ($listing_status->name) {
		case 'publish':
?>
	<?php /*<span data-status="me-paused" class="icon-me-pause"></span> */ ?>
	<a href="<?php echo $edit_url; ?>"><span class="me-icon-edit"><i class="icon-me-edit"></i><?php _e('Edit', 'enginethemes'); ?></span></a>
	<span data-status="me-archived" class="me-icon-delete"><i class="icon-me-delete"></i><?php _e('Archive', 'enginethemes'); ?></span>
<?php
			break;
		case 'me-archived':
?>
	<a href="<?php echo $edit_url; ?>"><span class="me-icon-resume"><i class="icon-me-resume"></i><?php _e('Restore', 'enginethemes'); ?></span></a>
<?php
			break;
		case 'me-pending':
?>
	<a href="<?php echo $edit_url; ?>"><span class="me-icon-edit"><i class="icon-me-edit"></i><?php _e('Edit', 'enginethemes'); ?></span></a>
	<span data-status="me-archived" class="me-icon-delete"><i class="icon-me-delete"></i><?php _e('Archive', 'enginethemes'); ?></span>
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
	<a href="<?php echo $edit_url; ?>"><span class="me-icon-edit"><i class="icon-me-edit"></i><?php _e('Edit', 'enginethemes'); ?></span></a>
	<span data-status="me-archived" class="me-icon-delete"><i class="icon-me-delete"></i><?php _e('Archive', 'enginethemes'); ?></span>
<?php
		break;
	}
?>