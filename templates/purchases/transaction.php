<?php
/**
 * The Template for displaying details of a transaction.
 *
 * This template can be overridden by copying it to yourtheme/marketengine/purchases/transaction.php.
 *
 * @package     MarketEngine/Templates
 * @version       1.0
 */

$transaction->update_listings();
?>
<div class="marketengine-content">

	<?php me_print_notices(); ?>

	<?php me_get_template( 'purchases/order-detail', array('transaction' => $transaction) ); ?>
	

	<?php me_get_template( 'purchases/order-extra', array('transaction' => $transaction ) ); ?>

	<?php

	if(get_current_user_id() == $transaction->post_author) :
		me_get_template( 'purchases/listing-slider', array('transaction' => $transaction) );
	endif;

	?>

</div>