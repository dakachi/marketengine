<?php
$me_notices = me_get_notices('success');
foreach ($me_notices as $key => $notice):
    ?>
		<div class="alert alert-<?php echo $notice_type; ?>" role="alert">
			<?php echo $notice ?>
		</div>
	<?php
endforeach;