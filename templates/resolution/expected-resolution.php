<?php
/**
 * The template for displaying resolutions expected.
 * This template can be overridden by copying it to yourtheme/marketengine/resolution/expected-resolution.php.
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 * @version     1.0.0
 * @since 		1.0.1
 */
?>
<div class="me-dispute-refund">
	<h3><?php _e('You want to:', 'enginethemes'); ?></h3>
	<div id="dispute-get-refund-yes" class="active">
	<?php
		$resolutions = me_rc_expected_resolutions(true);
		foreach ($resolutions as $key => $resolution) :
	?>
		<div class="dispute-get-refund">
			<label for="<?php echo $key; ?>">
				<input id="<?php echo $key; ?>" type="radio" name="dispute-get-refund" value="<?php echo $key; ?>"><?php echo $resolution['label']; ?>
			</label>
			<span><?php echo $resolution['description']; ?></span>
		</div>
	<?php endforeach; ?>
	</div>

	<div id="dispute-get-refund-no">
	<?php
		$resolutions = me_rc_expected_resolutions();
		foreach ($resolutions as $key => $resolution) :
	?>
		<div class="dispute-get-refund">
			<label for="<?php echo $key; ?>">
				<input id="<?php echo $key; ?>" type="radio" name="dispute-get-refund" value="<?php echo $key; ?>"><?php echo $resolution['label']; ?>
			</label>
			<span><?php echo $resolution['description']; ?></span>
		</div>
	<?php endforeach; ?>
	</div>
</div>