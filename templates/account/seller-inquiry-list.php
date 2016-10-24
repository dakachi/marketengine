<?php
/**
 *	The Template for displaying list of inquiries that seller received.
 * 	This template can be overridden by copying it to yourtheme/marketengine/account/seller-inquiry-list.php.
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 * @version     1.0.0
 */

$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$args = array(
	'post_type'		=> 'inquiry',
	'paged'			=> $paged,
	'receiver'		=> get_current_user_id(),
);

$query = new ME_Message_Query($args);
?>
<!-- Tabs Inquiries -->
<div class="me-tabs-section">
	<!--Mobile-->
	<div class="me-inquiries-filter-tabs">
		<span><?php echo __('Filter', 'enginethemes'); ?></span>
		<span><?php echo __('Filter list', 'enginethemes'); ?></span>
	</div>
	<!--/Mobile-->
	<?php me_get_template('global/inquiry-filter'); ?>

	<div class="me-table me-order-inquiries-table">
		
		<?php
		if( $query->have_posts() ) : ?>
			<div class="me-table-rhead">
				<div class="me-table-col me-order-buyer"><?php echo __('BUYER', 'enginethemes'); ?></div>
				<div class="me-table-col me-order-status"><?php echo __('STATUS', 'enginethemes'); ?></div>
				<div class="me-table-col me-order-listing"><?php echo __('LISTING', 'enginethemes'); ?></div>
				<div class="me-table-col me-order-date-contact"><?php echo __('DATE OF CONTACT', 'enginethemes'); ?></div>
			</div>
		<?php
			foreach( $query->posts as $inquiry ) :
				$listing = me_get_listing($inquiry->post_parent);
		?>

		<div class="me-table-row">
			<div class="me-table-col me-order-buyer">
				<div class="me-order-listing-info">
					<p><a href="<?php echo me_inquiry_permalink($inquiry->ID); ?>"><?php echo get_the_author_meta( 'display_name', $inquiry->sender ); ?></a></p>
				</div>
			</div>
			<div class="me-table-col me-order-status me-read">read</div>
			<div class="me-table-col me-order-listing"><?php echo esc_html($listing->get_title()); ?></div>
			<div class="me-table-col me-order-date-contact"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $inquiry->post_date ) ); ?></div>
		</div>

		<?php
			endforeach;
		?>
	</div>

	<div class="marketengine-paginations">
		<?php me_paginate_link($query); ?>
	</div>
	<div class="marketengine-loadmore">
		<a href="" class="me-loadmore me-loadmore-order-inquiries"><?php echo __('Load more', 'enginethemes'); ?></a>
	</div>
	<?php
	else:
	?>
		<div class="me-table-rhead me-table-rhead-empty">
			<div class="me-table-col me-order-buyer"><?php echo __('BUYER', 'enginethemes'); ?></div>
			<div class="me-table-col me-order-status"><?php echo __('STATUS', 'enginethemes'); ?></div>
			<div class="me-table-col me-order-listing"><?php echo __('LISTING', 'enginethemes'); ?></div>
			<div class="me-table-col me-order-date-contact"><?php echo __('DATE OF CONTACT', 'enginethemes'); ?></div>
		</div>
		<div class="me-table-row-empty">
			<div>
				<span><?php _e('There are no conversations yet.', 'enginethemes'); ?></span>
			</div>
		</div>
	<?php
	endif;
	?>
</div>