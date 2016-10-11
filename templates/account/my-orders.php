<div class="marketengine">
	<div class="me-container">
		<div class="marketengine-content-wrap">
			<div class="marketengine-page-title">
				<p><?php _e("MY ORDER", "enginethemes"); ?></p>
			</div>
			<div class="marketengine-content">
				<div class="me-orderlist">
					<div class="marketengine-tabs">
						<ul class="me-tabs">
							<li <?php if(empty($_GET['tab']) || $_GET['tab'] == 'order') { echo 'class="active"'; } ?> >
								<a href="<?php echo add_query_arg('tab', 'order'); ?>"><span>Orders</span></a>
							</li>
							<li <?php if(!empty($_GET['tab']) && $_GET['tab'] == 'inquiry') { echo 'class="active"'; } ?>>
								<a href="<?php echo add_query_arg('tab', 'inquiry'); ?>"><span>Inquiries</span></a>
							</li>
						</ul>
						<div class="me-tabs-container">
							<div class="me-tabs-section">
							<?php
								if(empty($_GET['tab']) || $_GET['tab'] == 'order') :
									me_get_template('account/order-list');
								else :
									me_get_template('account/inquiry-list');
								endif;
								?>
							</div>

						</div>
					</div>
				</div>
			</div>
			<!--// marketengine-content -->
		</div>
	</div>
</div>