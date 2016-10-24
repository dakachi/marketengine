<?php
/**
 *	The Template for displaying order filter section
 * 	This template can be overridden by copying it to yourtheme/marketengine/account/order-filter.php.
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 * @version     1.0.0
 */

$type = isset($type) ? $type : 'transaction';
?>

<div class="me-orderlist-filter">
	<form id="me-transaction-filter-form" action="#">
		<div class="me-row">
			<div class="me-col-md-2">
				<div class="me-order-status-filter">
					<label><?php _e('Status', 'enginethemes'); ?></label>
					<?php do_action( 'me_status_list', $type ); ?>
				</div>
			</div>
			<div class="me-col-md-3">
				<div class="me-order-pick-date-filter">
					<label><?php _e('Date of Order', 'enginethemes'); ?></label>
					<div class="me-order-pick-date">
						<input id="me-order-pick-date-1" name="from_date" type="text" placeholder="<?php _e('From date', 'enginethemes'); ?>">
						<input id="me-order-pick-date-2" name="to_date" type="text" placeholder="<?php _e('To date', 'enginethemes'); ?>">
					</div>
				</div>
			</div>
			<div class="me-col-md-7">
				<div class="me-order-keyword-filter">
					<label><?php _e('Keyword', 'enginethemes'); ?></label>
					<input type="text" name="keyword" placeholder="<?php _e('Order ID, listing name...', 'enginethemes'); ?>">
					<input class="me-order-filter-btn" type="submit" value="<?php _e('FILTER', 'enginethemes'); ?>">
				</div>
			</div>
		</div>
		<input name="tab" type="hidden" value="<?php echo isset($type) ? $type : 'transaction'; ?>">
	</form>
</div>
<a href="#" class="me-order-export"><i class="icon-me-download"></i><?php _e('Export report', 'enginethemes'); ?></a>