<div class="me-post-listing-none">
	<img src="<?php echo ME_PLUGIN_URL . 'assets/img/' ?>post-listing-none.png" alt="">
	<h3><?php _e("Sorry Buddy!", "enginethemes"); ?></h3>
	<h4><?php _e("You don't have permission to post listing.", "enginethemes"); ?></h4>
	<p><?php _e("This happens because you are not really logged in or your account is still inactive.", "enginethemes"); ?></p>
	<p>
	<?php 
		printf(__("You should <a href='%s'>register</a>,","enginethemes"), me_get_auth_url('register') ); 
		printf(__(" <a href='%s'>login</a> or active your account before post a listing","enginethemes"), me_get_page_permalink('user_account') ); 
	?> 
	</p>
</div>