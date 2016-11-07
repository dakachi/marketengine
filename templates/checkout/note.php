<div class="me-order-note">
	<h3><?php _e("Order Notes", "enginethemes"); ?> <small><?php _e("(optional)", "enginethemes"); ?></small></h3>
	<textarea name="customer_note"><?php if(!empty($_POST['note'])) echo $_POST['note']; ?></textarea>
</div>