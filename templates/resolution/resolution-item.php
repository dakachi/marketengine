<?php foreach ($resolutions as $key => $resolution) : ?>

<div class="dispute-get-refund">
	<label for="<?php echo $key; ?>">
		<input id="<?php echo $key; ?>" type="radio" name="dispute-get-refund" value="<?php echo $key; ?>"><?php echo $resolution['label']; ?>
	</label>
	<span><?php echo $resolution['description']; ?></span>
</div>

<?php endforeach; ?>