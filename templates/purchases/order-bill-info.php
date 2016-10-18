<?php
$bill_address = $transaction->get_address();
$shipping_address = $transaction->get_address( 'shipping' );
$note = $transaction->post_excerpt;
?>

<div class="me-order-detail-block">
	<div class="me-row">
		<div class="me-col-md-7">
			<div class="me-row">
				<div class="me-col-md-6 me-col-sm-6">
					<div class="me-orderbill-info">
						<h5><?php echo __( 'Billed to:', 'enginethemes' ); ?></h5>
						<p><?php $bill_address ? me_print_buyer_information( $bill_address ) : ''; ?></p>
					</div>
				</div>
				<div class="me-col-md-6 me-col-sm-6">
					<div class="me-ordership-info">
						<h5><?php echo __( 'Shipped to:', 'enginethemes' ); ?></h5>
						<p><?php $shipping_address ? me_print_buyer_information( $shipping_address ) : ''; ?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="me-col-md-5">
			<div class="me-ordernotes-info">
				<h5><?php echo __( 'Order Notes:', 'enginethemes' ); ?></h5>
				<p class=""><?php echo esc_attr($note) ?></p>
			</div>
		</div>
	</div>
</div>