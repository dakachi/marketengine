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
$dispute_files = !empty($_POST['dispute_file']) ? $_POST['dispute_file'] : array();
?>

<?php do_action('marketengine_before_dispute_form'); ?>

<div class="me-dispute-form">

	<?php me_print_notices(); ?>

	<?php do_action('marketengine_start_dispute_form'); ?>

	<form id="me-dispute-form" method="post" action="" enctype="multipart/form-data">

		<?php me_get_template('resolution/disputed-product-info', array('transaction' => $transaction)); ?>

		<?php me_get_template('resolution/dispute-received-item'); ?>

		<?php me_get_template('resolution/dispute-problem'); ?>

		<div class="me-dispute-description">
			<h3><?php _e('Please tell more about your problem', 'enginethemes'); ?></h3>
			<textarea name="me-dispute-problem-description"><?php echo isset($_POST['me-dispute-problem-description']) ? esc_js($_POST['me-dispute-problem-description']) : ''; ?></textarea>
		</div>

		<div class="me-dispute-image">
			<h3><?php _e('Attachments (video or images)', 'enginethemes'); ?></h3>
			<?php

	        ob_start();
	        if($dispute_files) {
	            foreach($dispute_files as $gallery) {
	                me_get_template('upload-file/multi-file-form', array(
	                    'image_id' => $gallery,
	                    'filename' => 'dispute_file',
	                    'close' => true
	                ));
	            }
	        }
	        $dispute_files = ob_get_clean();

	        me_get_template('upload-file/upload-form', array(
	            'id' => 'dispute-file',
	            'name' => 'dispute_file',
	            'source' => $dispute_files,
	            'button' => 'me-dipute-upload',
	            'multi' => true,
	            'maxsize' => esc_html( '2mb' ),
	            'maxcount' => 5,
	            'close' => true
	        ));
	        ?>
		</div>

		<?php me_get_template('resolution/expected-resolution'); ?>

		<?php wp_nonce_field('me-open_dispute_case'); ?>
		<?php wp_nonce_field('marketengine', 'me-dispute-file'); ?>

		<div class="me-dispute-submit">
			<input type="submit" class="me-dispute-submit-btn" name="me-open-dispute-case" value="<?php _e('SUBMIT', 'enginethemes'); ?>">
		</div>
		<a href="<?php echo remove_query_arg('action'); ?>" class="me-backlink"><?php _e('&lt; Back to transaction details', 'enginethemes'); ?></a>

		<input type="hidden" name="transaction-id" value="<?php echo $transaction->id; ?>">
		<input type="hidden" name="redirect" value="<?php echo get_the_permalink($transaction->id); ?>">

	</form>

	<?php do_action('marketengine_end_dispute_form'); ?>

</div>

<?php do_action('marketengine_after_dispute_form'); ?>