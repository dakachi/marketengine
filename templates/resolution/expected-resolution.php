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

	<div id="dispute-get-refund-yes" <?php echo  !isset($_POST['me-receive-item']) || (isset($_POST['me-receive-item']) && $_POST['me-receive-item'] == 'true') ? 'class="active"' : ''; ?>>
		<?php
			$resolutions = me_rc_expected_resolutions(true);
			me_get_template('resolution/resolution-item', array('resolutions' => $resolutions));
		?>
	</div>

	<div id="dispute-get-refund-no" <?php echo isset($_POST['me-receive-item']) && $_POST['me-receive-item'] == 'false' ? 'class="active"' : ''; ?>>
		<?php
			$resolutions = me_rc_expected_resolutions();
			me_get_template('resolution/resolution-item', array('resolutions' => $resolutions));
		?>
	</div>

</div>