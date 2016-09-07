<?php
$order_id = get_query_var( 'order' );
$order = new ME_Order(416);
$paypal = ME_Paypal_Simple::instance();
$paypal->complete_payment($_REQUEST);

?>
<div class="marketengine">
	<div class="me-payment-complete">
		<h3><?php _e("Thank for your payment", "enginethemes"); ?></h3>
		<p>Your payment of $<?php echo $order->get_total(); ?> has been received for your Lorem Ipsum is simply dummy text for printing on Tue, Jun, 28, 2016.</p>
		<p>Your transaction number is <span id="me-orderid">#<?php echo $order->get_order_number(); ?></span></p>
		<p><?php _e("A detailed summary of your transaction is sent to your mail.", "enginethemes"); ?></p>

		<div class="me-row">
			<div class="me-col-md-4 me-pc-redirect-1">
				<div class="">
					<h4><?php _e("Manage Transaction", "enginethemes"); ?></h4>
					<p>To view further information of this transaction, or make reviews &amp; ratings for listings, open <a href="">Transaction Detail</a>.</p>
				</div>
			</div>
			<div class="me-col-md-4 me-pc-redirect-2">
				<div class="">
					<h4><?php _e("Manage All Transaction", "enginethemes"); ?></h4>
					<p>To view all of transactions and manage them, open <a href="">Manage Transactions</a>.</p>
				</div>
				
			</div>
			<div class="me-col-md-4 me-pc-redirect-3">
				<div class="">
					<h4><?php _e("Keep Shopping", "enginethemes"); ?></h4>
					<p>There are many cool products waiting for you to explore. Click <a href="">here</a> to continue shopping.</p>
				</div>
			</div>
		</div>

	</div>
</div>
<?php
/*
Array
(
	[mc_gross] => 4000.00
	[protection_eligibility] => Eligible
	[address_status] => confirmed
	[item_number1] => 132
	[payer_id] => UADMHTRMVRHTQ
	[tax] => 0.00
	[address_street] => 1 Main St
	[payment_date] => 21:37:11 Aug 29, 2016 PDT
	[payment_status] => Completed
	[charset] => utf-8
	[address_zip] => 95131
	[mc_shipping] => 0.00
	[mc_handling] => 0.00
	[first_name] => ledd
	[mc_fee] => 116.30
	[address_country_code] => US
	[address_name] => ledd dakac
	[notify_version] => 3.8
	[custom] => {\"order_id\":404}
	[payer_status] => verified
	[business] => dinhle1987-biz@yahoo.com
	[address_country] => United States
	[num_cart_items] => 1
	[mc_handling1] => 0.00
	[address_city] => San Jose
	[payer_email] => dinhle1987-pers2@yahoo.com
	[verify_sign] => AWfYvpOYY9QGK6LMTcBhquaTPxFyALShAu0huejjZ8Qh9IUoK6mfw26.
	[mc_shipping1] => 0.00
	[tax1] => 0.00
	[txn_id] => 6B91747228835915A
	[payment_type] => instant
	[last_name] => dakac
	[item_name1] => Selling Listing 1
	[address_state] => CA
	[receiver_email] => dinhle1987-biz@yahoo.com
	[payment_fee] => 116.30
	[quantity1] => 2
	[receiver_id] => PTRV3WCVA7PP2
	[txn_type] => cart
	[mc_gross_1] => 4000.00
	[mc_currency] => USD
	[residence_country] => US
	[test_ipn] => 1
	[transaction_subject] =>
	[payment_gross] => 4000.00
	[auth] => AO8EvUSOmjOHrgZrpV9DYI2drRBTM.ak4dwt9yFB1ppVM7rWgCqxhv0M6i0Q4ih6K8LgkMrmpFRCtiAArGftI1A
)
 */