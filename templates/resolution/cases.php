<?php
/**
 * The template for displaying the resolution center page.
 * This template can be overridden by copying it to yourtheme/marketengine/resolution/cases.php.
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 * @version     1.0.0
 * @since 		1.0.1
 */

$query = me_rc_dispute_case_query($_GET);
?>

<div class="me-resolution">

	<?php me_get_template('resolution/cases-filter'); ?>

	<?php me_get_template('resolution/dispute-case-list', array('query' => $query)); ?>

	<?php me_get_template('resolution/cases-pagination', array('query' => $query)); ?>

</div>