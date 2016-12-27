<select name="status">
	<option value=""><?php _e('All', 'enginethemes'); ?></option>
<?php
	$statuses = me_rc_status_list();
	foreach ($statuses as $key => $status) :
?>
	<option <?php selected($_GET['status'], $key); ?> value="<?php echo $key; ?>"><?php echo $status; ?></option>
<?php endforeach; ?>
</select>