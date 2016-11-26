<?php
/**
 * The email template for sending to user when they create an account.
 *
 * This template can be overridden by copying it to yourtheme/marketengine/emails/registration-success.php.
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 *
 * @since 		1.0.0
 *
 * @version     1.0.0
 *
 */
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

?>

<p>Hello [display_name],</p>
<p>You have successfully registered an account with [blogname].Here is your account information:</p>
<ol>
<li>Username: [user_login]</li>
<li>Email: [user_email]</li>
</ol>
<p>Thank you and welcome to [blogname].</p>