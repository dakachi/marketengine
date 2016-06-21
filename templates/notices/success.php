<?php
$me_notices = me_get_notices('success');
foreach ($me_notices as $key => $notice):
    ?>
		<div class="alert alert-success" role="alert">
			<?php echo $notice ?>
		</div>
	<?php
endforeach;