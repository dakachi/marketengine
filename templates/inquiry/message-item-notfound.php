<?php
/**
 * The templates for displaying notice when no messages be found.
 * This template can be overridden by copying it to yourtheme/marketengine/inquiry/message-item-notfound.php.
 *
 * @package     MarketEngine/Templates
 * @since 		1.0.0
 * @version     1.0.0
 */
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
$user_data = get_userdata($author);
?>
<li>
	<div class="me-avatar-user">
		<?php echo me_get_avatar( $author ); ?>
		<b><?php echo $user_data->display_name; ?></b>
		<p><?php _e("Send your first message to start the conversation.", "enginethemes"); ?></p>
	</div>
</li>