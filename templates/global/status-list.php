<?php
	$status_list = me_get_order_status_list();
	if( !empty($status_list) ) :
?>
	<select name="order_status" id="">
		<option value="any"><?php _e("Filter order's status", 'enginethemes'); ?></option>
	<?php
		foreach ($status_list as $key => $status) :
	?>
		<option value="<?php echo $key; ?>"><?php echo $status; ?></option>
	<?php
		endforeach;
	?>
	</select>
<?php
	endif;
?>