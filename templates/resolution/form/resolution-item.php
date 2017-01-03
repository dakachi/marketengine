<?php foreach ($resolutions as $key => $resolution) : ?>

<div class="dispute-get-refund">
	<label for="<?php echo $key; ?>">
		<input class="me-solution-item" id="<?php echo $key; ?>" type="radio" name="expect_solution" value="<?php echo $key; ?>" <?php checked(isset($_POST['expect_solution']) && $_POST['expect_solution'] == $key); ?>><?php echo $resolution['label']; ?>
	</label>
	<span><?php echo $resolution['description']; ?></span>
</div>

<?php endforeach; ?>