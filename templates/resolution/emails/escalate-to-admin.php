<?php
/**
 * This is an email template send to buyer when seller escalate dispute
 *
 * You can modify the email by copy it to {your theme}/templates/resolution/email
 * @since 1.1
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

?>
<p><?php printf(__("Hi %s,", "enginethemes"), $display_name);?></p>
<p><?php printf(__("%s has escalated the dispute for the transaction: <a href='%s' >%d</a>. ", "enginethemes"), $sender_name, $order_link, $order_id); ?>
<?php _e("Please review it here and arbitrate the dispute based on the detailed information and materials involved in this transaction which are provided by both parties.", "enginethemes"); ?>
<br/><a href='<?php echo $dispute_link; ?>' ><?php echo $dispute_link; ?></a>
</p>
<p><?php printf(__("Regards, <br/> %s", "enginethemes"), $blogname);?></p>