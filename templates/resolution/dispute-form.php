<?php
/**
 * The template for displaying the dispute form.
 * This template can be overridden by copying it to yourtheme/marketengine/resolution/dispute-form.php.
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 * @version     1.0.0
 * @since 		1.0.1
 */
?>

<?php do_action('marketengine_before_dispute_form'); ?>

<div class="me-dispute-form">

	<?php do_action('marketengine_start_dispute_form'); ?>

	<form id="me-dispute-form" method="post" action="">

		<?php me_get_template('resolution/disputed-product-info', array('transaction' => $transaction)); ?>

		<div class="me-receive-item">
			<h3><?php _e('Did you receive your item?', 'enginethemes'); ?></h3>
			<label for="me-receive-item-yes"><input class="me-receive-item-field" id="me-receive-item-yes" type="radio" data-get-refund-block="dispute-get-refund-yes" name="me-receive-item" checked><?php _e('Yes', 'enginethemes'); ?></label>
			<label for="me-receive-item-no"><input class="me-receive-item-field" id="me-receive-item-no" type="radio" data-get-refund-block="dispute-get-refund-no" name="me-receive-item"><?php _e('No', 'enginethemes'); ?></label>
		</div>

		<?php me_get_template('resolution/dispute-problem'); ?>

		<div class="me-dispute-description">
			<h3><?php _e('Please tell more about your problem', 'enginethemes'); ?></h3>
			<textarea name="dispute-description"></textarea>
		</div>

		<div class="me-dispute-image">
			<h3><?php _e('Attachments (video or images)', 'enginethemes'); ?></h3>
			<!--
			<ul class="marketengine-gallery-img">
				<li class="me-item-img">
					<span class="me-gallery-img">
						<img src="assets/img/1.jpg" alt="">
						<a class="me-delete-img"></a>
					</span>
					<div class="me-gallery-radio">
						<input type="radio" name="featured_image" id="radio-img-1">
						<label for="radio-img-1"></label>
					</div>
				</li>
				<li class="me-item-img">
					<span class="me-gallery-img">
						<img src="assets/img/1.jpg" alt="">
						<a class="me-delete-img"></a>
					</span>
					<div class="me-gallery-radio">
						<input type="radio" name="featured_image" id="radio-img-2">
						<label for="radio-img-2"></label>
					</div>
				</li>
				<li class="me-item-img">
					<span class="me-gallery-img me-gallery-add-img">
						<a class="me-add-img">
							<i class="icon-me-add"></i>
							<input type="file" value="">
						</a>
					</span>
				</li>
			</ul>
			-->
			<ul class="marketengine-gallery-img">
				<li class="me-item-img">
					<span class="me-gallery-img me-gallery-add-img">
						<a class="me-add-img">
							<i class="icon-me-add"></i>
							<input type="file" name="dispute-media" value="">
						</a>
					</span>
				</li>
			</ul>
		</div>

		<?php me_get_template('resolution/expected-resolution'); ?>

		<div class="me-dispute-submit">
			<input type="submit" class="me-dispute-submit-btn" value="<?php _e('SUBMIT', 'enginethemes'); ?>">
		</div>
		<a href="<?php echo remove_query_arg('action'); ?>" class="me-backlink"><?php _e('&lt; Back to transaction details', 'enginethemes'); ?></a>
	</form>

	<?php do_action('marketengine_end_dispute_form'); ?>

</div>

<?php do_action('marketengine_after_dispute_form'); ?>