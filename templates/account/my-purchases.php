<div class="me-orderlist">
	<div class="marketengine-tabs">
		<ul class="me-tabs">
			<li <?php if(empty($_GET['tab']) || $_GET['tab'] == 'transaction') { echo 'class="active"'; } ?>>
				<a href="<?php echo add_query_arg('tab', 'transaction'); ?>">
					<span><?php echo __('Transactions', 'enginethemes'); ?></span>
				</a>
			</li>
			<li <?php if(!empty($_GET['tab']) && $_GET['tab'] == 'inquiry') { echo 'class="active"'; } ?>>
				<a href="<?php echo add_query_arg('tab', 'inquiry'); ?>">
					<span><?php echo __('Inquiries', 'enginethemes'); ?></span>
				</a>
			</li>
		</ul>
		<div class="me-tabs-container">
			<!-- Tabs Orders -->
			<div class="me-tabs-section">

				<?php
					if(empty($_GET['tab']) || $_GET['tab'] == 'transaction') :
						me_get_template('account/transaction-list');
					else :
						me_get_template('account/buyer-inquiry-list');
					endif;
				?>

			</div>
		</div>
	</div>
</div>