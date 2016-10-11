<div class="me-orderlist-filter">
	<form id="me-transaction-filter-form" action="#">
		<div class="me-row">
			<div class="me-col-md-2">
				<div class="me-order-status-filter">
					<label>Status</label>
					<?php do_action( 'me_status_list' ); ?>
				</div>
			</div>
			<div class="me-col-md-3">
				<div class="me-order-pick-date-filter">
					<label>Date of Order</label>
					<div class="me-order-pick-date">
						<input id="me-order-pick-date-1" name="from_date" type="text" placeholder="From date">
						<input id="me-order-pick-date-2" name="to_date" type="text" placeholder="To date">
					</div>
				</div>
			</div>
			<div class="me-col-md-7">
				<div class="me-order-keyword-filter">
					<label>Keyword</label>
					<input type="text" name="keyword" placeholder="Order ID, listing name...">
					<input class="me-order-filter-btn" type="submit" value="FILTER">
				</div>
			</div>
		</div>
		<input name="tab" type="hidden" value="<?php echo isset($type) ? $type : 'transaction'; ?>">
	</form>
</div>
<a href="#" class="me-order-export"><i class="icon-me-download"></i>Export report</a>