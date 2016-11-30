<?php
/**
 * The template for displaying the disabled form of conversation page.
 *
 * This template can be override by copying it to
 * yourtheme/marketengine/inquiry/send-message-disabled.php.
 *
 * @author EngineThemes
 * @package MarketEngine/Templates
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="me-mc-container" id="me-mc-container"></div>
<textarea disabled="disabled" id="me-message-content" class="required me-message-content" required name="content" placeholder="<?php _e("Type your message here", "enginethemes"); ?>"></textarea>
<div class="upload-container">
	<span id="me-message-send-btn-disabled" class="me-message-send-btn"><i class="icon-me-attach"></i></span>
</div>
