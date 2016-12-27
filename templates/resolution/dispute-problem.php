<?php
/**
 * The template for displaying dispute problems.
 * This template can be overridden by copying it to yourtheme/marketengine/resolution/dispute-problem.php.
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 * @version     1.0.0
 * @since 		1.0.1
 */
$problems = me_rc_dispute_problems();
?>

<div class="me-dispute-problem">
	<h3><?php _e('What is your problem?', 'enginethemes'); ?></h3>
	<select name="" id="">
	<?php foreach ($problems as $key => $problem) : ?>
		<option value=""><?php _e('Problem 001', 'enginethemes'); ?></option>
		<option value=""><?php _e('Problem 002', 'enginethemes'); ?></option>
		<option value=""><?php _e('Problem 003', 'enginethemes'); ?></option>
		<option value=""><?php _e('Problem 004', 'enginethemes'); ?></option>
	<?php endforeach; ?>
	</select>
</div>