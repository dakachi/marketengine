<?php
/**
 *	The Template for displaying orders and inquiries of seller.
 * 	This template can be overridden by copying it to yourtheme/marketengine/account/my-orders.php.
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 * @version     1.0.0
 */
?>
<div class="me-orderlist">
	<div class="marketengine-tabs">
		<ul class="me-tabs">
			<li <?php if(empty($_GET['tab']) || $_GET['tab'] == 'order') { echo 'class="active"'; } ?> >
				<a href="<?php echo add_query_arg('tab', 'order'); ?>"><span><?php _e('Orders', 'enginethemes'); ?></span></a>
			</li>
			<li <?php if(!empty($_GET['tab']) && $_GET['tab'] == 'inquiry') { echo 'class="active"'; } ?>>
				<a href="<?php echo add_query_arg('tab', 'inquiry'); ?>"><span><?php _e('Inquiries', 'enginethemes'); ?></span></a>
			</li>
		</ul>
		<div class="me-tabs-container">
			<div class="me-tabs-section">
			<?php
				if(empty($_GET['tab']) || $_GET['tab'] == 'order') :
					me_get_template('account/order-list');
				else :
					me_get_template('account/seller-inquiry-list');
				endif;
				?>
			</div>

		</div>
	</div>
</div>