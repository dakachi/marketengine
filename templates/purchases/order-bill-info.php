<?php
$bill_address = $transaction->get_address();
$shipping_address = $transaction->get_address( 'shipping' );
?>

<div class="me-order-detail-block">
	<div class="me-row">
		<div class="me-col-md-7">
			<div class="me-row">
				<div class="me-col-md-6 me-col-sm-6">
					<div class="me-orderbill-info">
						<h5><?php echo __( 'Billed to:', 'enginethemes' ); ?></h5>
						<p><?php me_print_address( $bill_address ); ?></p>
					</div>
				</div>
				<div class="me-col-md-6 me-col-sm-6">
					<div class="me-ordership-info">
						<h5><?php echo __( 'Shipped to:', 'enginethemes' ); ?></h5>
						<p><?php me_print_address( $shipping_address ); ?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="me-col-md-5">
			<div class="me-ordernotes-info">
				<h5><?php echo __( 'Order Notes:', 'enginethemes' ); ?></h5>
				<p class="">Curabitur Curabitur dictum laoreet lectus vel tempus. Ut ultricies lorem augue, ac gravida di Curabitur dictum laoreet lectus vel tempus. Ut ultricies lorem augue, ac gravida diam bibendum et. Proin ligula urna, feugiat u Curabitur dictum laoreet lectus vel tempus. Ut ultricies lorem augue, ac gravida diam bibendum et. Proin ligula urna, feugiat u am bibendum et. Proin ligula urna, feugiat u dictum laoreet lectus vel tempus. Ut ultricies lorem augue, ac gravida diam bibendum et. Proin ligula urna, feugiat ut risus ac,  Duis maximus quam ut justo accumsan, in luctus lacus semper. Suspendisse facilisis hendrerit ante, a congue lacus cursus vitae. Nunc iaculis lacinia dolor, sed congue nibh.</p>
			</div>
		</div>
	</div>
</div>