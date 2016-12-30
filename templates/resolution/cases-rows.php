<?php
/**
 * The template for displaying dispute cases.
 * This template can be overridden by copying it to yourtheme/marketengine/resolution/cases-rows.php.
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 * @version     1.0.0
 * @since 		1.0.1
 */

$transaction = me_get_order($case->post_parent);
?>
<div class="me-table-row">
	<div class="me-table-col me-rslt-case"><?php printf("#%s", $case->ID); ?></div>
	<div class="me-table-col me-rslt-status"><?php echo me_rc_status_label($case->post_status); ?></div>
	<div class="me-table-col me-rslt-problem">The item does not match description</div>
	<div class="me-table-col me-rslt-date"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $case->post_date ) ); ?></div>
	<div class="me-table-col me-rslt-related">Jacqueline Anne Hathaway</div>
	<div class="me-table-col me-rslt-amount"><?php echo me_price_format($transaction->get_total()); ?></div>
</div>