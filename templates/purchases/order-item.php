<?php
$shipping_fee = $transaction->shipping_fee ? '$' . $transaction->shipping_fee : $transaction->shipping_fee;
$total = $transaction->total ? '$' . $transaction->total : $transaction->total;
?>
<div class="me-order-detail-block">
	<div class="me-orderitem-info">
		<h5><?php echo __('Order item', 'enginethemes'); ?></h5>
		<div class="me-table me-cart-table">
			<div class="me-table-rhead">
				<div class="me-table-col me-cart-name"><?php echo __('Listing', 'enginethemes'); ?></div>
				<div class="me-table-col me-cart-price"><?php echo __('Price', 'enginethemes'); ?></div>
				<div class="me-table-col me-cart-units"><?php echo __('Units', 'enginethemes'); ?></div>
				<div class="me-table-col me-cart-units-total"><?php echo __('Total', 'enginethemes'); ?></div>
			</div>
			<div class="me-table-row me-cart-item">
				<div class="me-table-col me-cart-name">
					<div class="me-cart-listing">
						<a href="#">
							<img src="../assets/img/2.jpg" alt="">
							<span>Lorem Ipsum is simply dummy text Lorem Ipsum is simply</span>
						</a>
					</div>
				</div>
				<div class="me-table-col me-cart-price"><span>Price</span>$20</div>
				<div class="me-table-col me-cart-units"><span>Units</span><input type="number" value="20"></div>
				<div class="me-table-col me-cart-units-total">$400</div>
			</div>
			<div class="me-table-row me-cart-item">
				<div class="me-table-col me-cart-name">
					<div class="me-cart-listing">
						<a href="#">
							<img src="../assets/img/2.jpg" alt="">
							<span>Lorem Ipsum is simply dummy text Lorem Ipsum is simply</span>
						</a>
					</div>
				</div>
				<div class="me-table-col me-cart-price"><span>Price</span>$12</div>
				<div class="me-table-col me-cart-units"><span>Units</span><input type="number" value="60"></div>
				<div class="me-table-col me-cart-units-total">$720</div>
			</div>
			<div class="me-table-row me-cart-rshippingfee">
				<div class="me-table-col me-table-empty"></div>
				<div class="me-table-col me-table-empty"></div>
				<div class="me-table-col me-cart-shippingfee"><?php echo __('Shipping fee:', 'enginethemes'); ?></div>
				<div class="me-table-col me-cart-shippingfee-price"><?php echo $shipping_fee; ?></div>
			</div>
			<div class="me-table-row me-cart-rtotals">
				<div class="me-table-col me-table-empty"></div>
				<div class="me-table-col me-table-empty"></div>
				<div class="me-table-col me-cart-amount"><?php echo __('Total amount:', 'enginethemes'); ?></div>
				<div class="me-table-col me-cart-totals"><?php echo $total; ?></div>
			</div>
		</div>
		<div class="me-order-submit">
			<input class="me-order-submit-btn" type="submit" value="<?php echo __('MARK COMPLETED', 'enginethemes'); ?>">
		</div>
	</div>
</div>