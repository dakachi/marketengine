<?php
	$inquiry_object = me_my_inquiries();
	$inquiries = $inquiry_object['posts'];
	// var_dump($inquiry_object);
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
		<div class="me-table-rhead">
			<div class="me-table-col me-order-listing"><?php echo __('LISTING', 'enginethemes'); ?></div>
			<div class="me-table-col me-order-status"><?php echo __('STATUS', 'enginethemes'); ?></div>
			<div class="me-table-col me-order-buyer"><?php echo __('SELLER', 'enginethemes'); ?></div>
			<div class="me-table-col me-order-date-contact"><?php echo __('DATE OF CONTACT', 'enginethemes'); ?></div>
		</div>
		<?php
		if(!empty($inquiries)) :
			foreach( $inquiries as $key => $inquiry ) :

		?>

		<div class="me-table-row">
			<div class="me-table-col me-order-listing">
				<div class="me-order-listing-info">
					<p><?php echo $inquiry->post_title; ?></p>
				</div>
			</div>
			<div class="me-table-col me-order-status me-read">read</div>
			<div class="me-table-col me-order-buyer"><?php echo get_the_author_meta( 'display_name', $inquiry->post_author ); ?></div>
			<div class="me-table-col me-order-date-contact"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $inquiry->message_date ) ); ?></div>
		</div>

		<?php
			endforeach;
		endif;
		?>
	</div>

	<div class="marketengine-paginations">
		<a class="prev page-numbers" href="#">&lt;</a>
		<a class="page-numbers" href="#">1</a>
		<span class="page-numbers current">2</span>
		<a class="page-numbers" href="#">3</a>
		<a class="next page-numbers" href="">&gt;</a>
	</div>
	<div class="marketengine-loadmore">
		<a href="" class="me-loadmore me-loadmore-order-inquiries"><?php echo __('Load more', 'enginethemes'); ?></a>
	</div>
</div>