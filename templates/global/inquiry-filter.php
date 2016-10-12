<?php
/**
 *	The Template for displaying inquiry filter section
 * 	This template can be overridden by copying it to yourtheme/marketengine/account/inquiry-filter.php.
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 * @version     1.0.0
 */
?>

<div class="me-order-inquiries-filter">
	<form id="me-transaction-inquiries-filter-form" action="">
		<div class="me-row">
			<div class="me-col-md-3">
				<div class="me-inquiries-pick-date-filter">
					<label><?php _e('Latest', 'enginethemes'); ?></label>
					<div class="me-inquiries-pick-date">
						<input id="me-inquiries-pick-date-1" name="from_date" type="text" placeholder="<?php _e('From date', 'enginethemes'); ?>">
						<input id="me-inquiries-pick-date-2" name="to_date" type="text" placeholder="<?php _e('To date', 'enginethemes'); ?>">
					</div>
				</div>
			</div>
			<div class="me-col-md-9">
				<div class="me-inquiries-filter">
					<label><?php _e('Keyword', 'enginethemes'); ?></label>
					<input class="me-inquiries-keyword" type="text" name="keyword" placeholder="<?php _e('Listing name, seller name...', 'enginethemes'); ?>">
					<input class="me-inquiries-filter-btn" type="submit" value="<?php _e('FILTER', 'enginethemes'); ?>">
				</div>
			</div>
		</div>
		<input name="tab" type="hidden" value="inquiry">
	</form>
</div>