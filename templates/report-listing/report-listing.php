<?php
/**
 * 	The Template for displaying report listing page.
 * 	This template can be overridden by copying it to yourtheme/marketengine/report-listing/report-listing.php.
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 * @version     1.0.0
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="marekengine-report-wrap">
	<form id="me-report-form" action="" method="post">
		<h3><?php _e('REPORT LISTING', 'enginethemes'); ?></h3>
		<div class="marketengine-group-field">
			<div class="marketengine-input-field">
			    <label class="text"><?php _e('Please help us understand your situation', 'enginethemes'); ?></label>
			    <?php //TODO: tam thoi de vay. ?>
			    <select class="me-situation" name="" id="">
			    	<option value="">Select option 01</option>
			    	<option value="">Select option 02</option>
			    	<option value="">Select option 03</option>
			    	<option value="">Select option 04</option>
			    </select>
			</div>
		</div>
		<div class="marketengine-group-field">
			<div class="marketengine-textarea-field">
				<label class="text"><?php _e('Description', 'enginethemes'); ?></label>
				<textarea name="description" id=""></textarea>
			</div>
		</div>

		<div class="marketengine-group-field">
			<input type="file">
		</div>
		<div class="marketengine-group-field">
			<div class="marketengine-input-field">
			    <label class="text"><?php _e('What do you expect us to do?', 'enginethemes'); ?></label>
			    <?php //TODO: tam thoi de vay. ?>
			    <select class="me-expect" name="" id="">
			    	<option value="">Select option 01</option>
			    	<option value="">Select option 02</option>
			    	<option value="">Select option 03</option>
			    	<option value="">Select option 04</option>
			    </select>
			</div>
		</div>
		<div class="marketengine-group-field me-text-center">
			<input type="submit" class="marketengine-report-btn" value="SUBMIT">
		</div>
		<a href="#" class="back-home-sigin me-backlink"><?php _e('Discard', 'enginethemes'); ?></a>
	</form>
</div>