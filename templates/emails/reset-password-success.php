<?php
/**
 * 	The Email template for sending to user when they reset password successfully.
 * 	This template can be overridden by copying it to yourtheme/marketengine/emails/reset-password-success.php.
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 *
 * @since 		1.0.0
 * @version     1.0.0
 */
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

?>
<p>Hello [display_name],</p><p>You have successfully changed your password. Click this link  [site_url] to login to your [blogname] account.</p>
<p>Sincerely, <br/>
[blogname]</p>