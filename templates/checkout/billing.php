<?php 
$address_fields = array(
	'first_name' => __("First name", "enginethemes"),
	'last_name' => __("Last name", "enginethemes"),
	'email' => __("Email address", "enginethemes"),
	'phone' => __("Phone", "enginethemes"),
	'country' => __("Country", "enginethemes"),
	'town' => __("Town/City", "enginethemes"),
	'address' => __("Street address", "enginethemes"),
	'postcode' => __("Post code", "enginethemes")
);
$billing_fields = apply_filters('marketengine_billing_fields', $address_fields);
$shipping_fields = apply_filters('marketengine_shipping_fields', $address_fields);
?>
<div class="me-billing-shipping">
	<h3 class="me-title-bill-ship"><?php _e("Billing &amp; Shipping Details", "enginethemes"); ?></h3>
	<div class="me-switch-billing">
		<input id="me-billing-address-input" type="radio" name="me-billing" checked="">
		<label class="me-switch-bill-label" for="me-billing-address-input">
			<?php _e("I have billing &amp; shipping addresses", "enginethemes"); ?>
		</label>
		<!-- billing info -->
		<div class="me-billing-address">
			<h4><?php _e("My billing address", "enginethemes"); ?></h4>
			<div class="me-row">
				<div class="me-col-md-6">
					<div class="marketengine-input-field">
						<label class="text"><?php _e("First name", "enginethemes"); ?></label>
						<input type="text" name="billing_info[first_name]" value="<?php if(!empty($_POST['billing_info']['first_name'])) echo $_POST['billing_info']['first_name']; ?>">
					</div>
				</div>
				<div class="me-col-md-6">
					<div class="marketengine-input-field">
						<label class="text"><?php _e("Last name", "enginethemes"); ?></label>
						<input type="text" name="billing_info[last_name]" value="<?php if(!empty($_POST['billing_info']['last_name'])) echo $_POST['billing_info']['last_name']; ?>">
					</div>
				</div>
			</div>
			<div class="me-row">
				<div class="me-col-md-6">
					<div class="marketengine-input-field">
						<label class="text"><?php _e("Email address", "enginethemes"); ?></label>
						<input type="text" name="billing_info[email]" value="<?php if(!empty($_POST['billing_info']['email'])) echo $_POST['billing_info']['email']; ?>">
					</div>
				</div>
				<div class="me-col-md-6">
					<div class="marketengine-input-field">
						<label class="text"><?php _e("Phone", "enginethemes"); ?></label>
						<input type="text" name="billing_info[phone]" value="<?php if(!empty($_POST['billing_info']['phone'])) echo $_POST['billing_info']['phone']; ?>">
					</div>
				</div>
			</div>
			<div class="me-row">
				<div class="me-col-md-6">
					<div class="marketengine-input-field">
						<label class="text"><?php _e("Country", "enginethemes"); ?></label>
						<input type="text" name="billing_info[country]" value="<?php if(!empty($_POST['billing_info']['country'])) echo $_POST['billing_info']['country']; ?>">
					</div>
				</div>
				<div class="me-col-md-6">
					<div class="marketengine-input-field">
						<label class="text"><?php _e("Town/City", "enginethemes"); ?></label>
						<input type="text" name="billing_info[city]" value="<?php if(!empty($_POST['billing_info']['city'])) echo $_POST['billing_info']['city']; ?>">
					</div>
				</div>
			</div>
			<div class="me-row">
				<div class="me-col-md-6">
					<div class="marketengine-input-field">
						<label class="text"><?php _e("Street address", "enginethemes"); ?></label>
						<input type="text" name="billing_info[address]" value="<?php if(!empty($_POST['billing_info']['address'])) echo $_POST['billing_info']['address']; ?>">
					</div>
				</div>
				<div class="me-col-md-6">
					<div class="marketengine-input-field">
						<label class="text"><?php _e("Post code", "enginethemes"); ?></label>
						<input type="text" name="billing_info[postcode]" value="<?php if(!empty($_POST['billing_info']['postcode'])) echo $_POST['billing_info']['postcode']; ?>">
					</div>
				</div>
			</div>
			
			<input id="me-shipping-address-input" type="checkbox" name="me-billing" checked="">
			<label class="me-use-ship-label" for="me-shipping-address-input">
				<?php _e("Use the same address as the billing address", "enginethemes"); ?>
			</label>

			<!-- shipping info -->
			<div class="me-shipping-address">
				<h4><?php _e("My shiping address", "enginethemes"); ?></h4>
				<div class="me-row">
					<div class="me-col-md-6">
						<div class="marketengine-input-field">
							<label class="text"><?php _e("First name", "enginethemes"); ?></label>
							<input type="text" name="shipping[first_name]" value="<?php if(!empty($_POST['shipping']['first_name'])) echo $_POST['shipping']['first_name']; ?>">
						</div>
					</div>
					<div class="me-col-md-6">
						<div class="marketengine-input-field">
							<label class="text"><?php _e("Last name", "enginethemes"); ?></label>
							<input type="text" name="shipping[last_name]" value="<?php if(!empty($_POST['shipping']['last_name'])) echo $_POST['shipping']['last_name']; ?>">
						</div>
					</div>
				</div>
				<div class="me-row">
					<div class="me-col-md-6">
						<div class="marketengine-input-field">
							<label class="text"><?php _e("Email address", "enginethemes"); ?></label>
							<input type="text" name="shipping[email]" value="<?php if(!empty($_POST['shipping']['email'])) echo $_POST['shipping']['email']; ?>">
						</div>
					</div>
					<div class="me-col-md-6">
						<div class="marketengine-input-field">
							<label class="text"><?php _e("Phone", "enginethemes"); ?></label>
							<input type="text" name="shipping[phone]" value="<?php if(!empty($_POST['shipping']['phone'])) echo $_POST['shipping']['phone']; ?>">
						</div>
					</div>
				</div>
				<div class="me-row">
					<div class="me-col-md-6">
						<div class="marketengine-input-field">
							<label class="text"><?php _e("Country", "enginethemes"); ?></label>
							<input type="text" name="shipping[country]" value="<?php if(!empty($_POST['shipping']['country'])) echo $_POST['shipping']['country']; ?>">
						</div>
					</div>
					<div class="me-col-md-6">
						<div class="marketengine-input-field">
							<label class="text"><?php _e("Town/City", "enginethemes"); ?></label>
							<input type="text" name="shipping[city]" value="<?php if(!empty($_POST['shipping']['city'])) echo $_POST['shipping']['city']; ?>">
						</div>
					</div>
				</div>
				<div class="me-row">
					<div class="me-col-md-6">
						<div class="marketengine-input-field">
							<label class="text"><?php _e("Street address", "enginethemes"); ?></label>
							<input type="text" name="shipping[address]" value="<?php if(!empty($_POST['shipping']['address'])) echo $_POST['shipping']['address']; ?>">
						</div>
					</div>
					<div class="me-col-md-6">
						<div class="marketengine-input-field">
							<label class="text"><?php _e("Post code", "enginethemes"); ?></label>
							<input type="text" name="shipping[postcode]" value="<?php if(!empty($_POST['shipping']['postcode'])) echo $_POST['shipping']['postcode']; ?>">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>