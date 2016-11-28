<?php
/**
 * The email template for sending to user when they reset password successfull.
 *
 * This template can be overridden by copying it to yourtheme/marketengine/emails/reset-password-success.php.
 *
 * @author         EngineThemes
 * @package     MarketEngine/Templates
 *
 * @since         1.0.0
 *
 * @version     1.0.0
 *
 */
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
?>
<p><?php printf(__("Hello %s,", "enginethemes"), $display_name);?></p>
<p><?php printf(__("You have successfully changed your password. Click this link  %s to login to your %s account.", "enginethemes"), $site_url, $blogname)?></p>
<p><?php _e("Sincerely", "enginethemes");?>, <br/>
<?php echo $blogname; ?></p>