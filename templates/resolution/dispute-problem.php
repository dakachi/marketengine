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
	<select name="me-dispute-problem" id="">
	<?php foreach ($problems as $key => $problem) : ?>
		<option <?php selected(isset($_POST['me-dispute-problem']) && $_POST['me-dispute-problem'] == $key); ?> value="<?php echo $key; ?>"><?php echo $problem; ?></option>
	<?php endforeach; ?>
	</select>
</div>