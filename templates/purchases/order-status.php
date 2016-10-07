<div class="me-order-detail-block">
	<div class="me-orderstatus-info">
		<h5><?php echo __('Order status:', 'enginethemes'); ?></h5>
		<div class="me-orderstatus">
			<?php
				me_print_order_status( $order_status );
				if( 'me-disputed' === $order_status ) :
			?>
			<p class=""><i class="icon-me-status-info"></i>This order has been disputed by buyer. Resolve it as soon as possible.</p>
			<?php
				endif;
			?>
		</div>
		<?php
			$process_index = me_get_order_status_info( $order_status );
		?>
		<div class="me-line-process-order">
			<div class="me-line-step-order <?php echo $process_index >= 1 ? 'active' : '' ?>">
				<span>Check payment</span>
			</div>
			<div class="me-line-step-order <?php echo $process_index >= 2 ? 'active' : '' ?>">
				<span>Active order</span>
			</div>
			<div class="me-line-step-order <?php echo $process_index >= 3 ? 'active' : '' ?>">
				<span>Mark completed</span>
			</div>
			<div class="me-line-step-order <?php echo $process_index >= 4 ? 'active' : '' ?>">
				<span>Closed order</span>
			</div>
		</div>
	</div>
</div>