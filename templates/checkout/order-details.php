<?php
// get cart item tu session
?>
<div class="me-shopping-cart">
	<h3><?php _e("Your order", "enginethemes"); ?></h3>
	<div class="me-table me-cart-table">
		<div class="me-table-row me-cart-item">
			<div class="me-table-col me-cart-name">
				<span><?php _e("Item", "enginethemes"); ?></span>
				<span>
					<div class="me-cart-listing">
						<a href="">
							<img src="assets/img/2.jpg" alt="">
							<span>Lorem Ipsum is simply dummy text Lorem Ipsum is simply</span>
						</a>
					</div>
				</span>
			</div>
			<div class="me-table-col me-cart-price">
				<span>Price</span>
				<span>$20</span>
			</div>
			<div class="me-table-col me-cart-units-total">
				<div class="me-cart-units">
					<span>Units</span>
					<span><input type="number" value="20"></span>
				</div>
				<div class="me-cart-total">
					<span>Total price</span>
					<span>$180</span>
				</div>
			</div>
		</div>
		<div class="me-table-row">
			<div class="me-table-col me-table-empty"></div>
			<div class="me-table-col me-table-empty"></div>
			<div class="me-table-col me-cart-shippingfee"><span>Shipping fee:</span><span>$10</span></div>
		</div>
		<div class="me-table-row">
			<div class="me-table-col me-table-empty"></div>
			<div class="me-table-col me-table-empty"></div>
			<div class="me-table-col me-cart-totals"><span>Total amount:</span><span>$1010</span></div>
		</div>
	</div>

	<div class="me-checkout-submit">
		<input class="me-checkout-submit-btn" type="submit" value="<?php _e("MAKE PAYMENT", "enginethemes"); ?>">
	</div>
</div>