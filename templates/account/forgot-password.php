
<form id="forgot-password-form" action="" method="post">
	<h3>Forgot Password</h3>
	<div class="marketengine-group-field">
		<div class="marketengine-input-field">
		    <span class="text">Enter your email</span>
		    <input type="email" name="email">
		    <!-- <label class="message" for="">This is field required.</label> -->
		</div>
	</div>
	<div class="marketengine-group-field submit-forgot">
		<input type="submit" class="marketengine-btn" value="Submit">
	</div>
	<a href="<?php echo me_get_page_permalink('login'); ?>" class="back-home-sigin">&lt; Back to login</a>
</form>
