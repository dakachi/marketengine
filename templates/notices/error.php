<?php
$me_notices = me_get_notices('error');
foreach ($me_notices as $key => $notice):
    ?>
		<div class="alert alert-error" role="alert">
			<?php echo $notice ?>
		</div>
	<?php
endforeach;