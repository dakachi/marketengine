<?php
/**
 * The template for displaying the list of dispute cases.
 * This template can be overridden by copying it to yourtheme/marketengine/resolution/dispute-case-list.php.
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 * @version     1.0.0
 * @since 		1.0.1
 */
?>

<div class="me-table me-table-resolution">

	<?php me_get_template('resolution/cases/cases-table-header'); ?>

	<?php if($query->found_posts) : ?>

		<?php foreach ($query->posts as $case) : ?>

		<?php me_get_template('resolution/cases/cases-rows', array('case' => $case)); ?>

		<?php endforeach; ?>

	<?php else: ?>

		<?php me_get_template('resolution/cases/no-cases'); ?>

	<?php endif; ?>

</div>