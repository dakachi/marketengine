<?php if($query['max_numb_pages'] > 1) : ?>

<?php $posts_per_page = get_option('posts_per_page'); ?>

<div class="me-pagination-wrap">
	<span class="me-pagination-result">
	<?php 
	if(empty($_REQUEST['page_num'])) {
		$current = 0;
	}else {
		$current = (($_REQUEST['page_num'] - 1) * $posts_per_page);
	}

	$final = $posts_per_page + $current;
	if($final > $query['found_posts']) {
		$final = $query['found_posts'];
	}

	if($query['found_posts'] > 1) {
		printf(__("%d - %d of %d results", "enginethemes"), $current + 1, $final , $query['found_posts']);
	}else {
		printf(__("%d - %d of %d result", "enginethemes"), $current + 1, $final , $query['found_posts']);
	}
	?>
	</span>
	<span class="me-paginations">
		<?php 
		$big = 999999999;
		$current_page = empty($_REQUEST['page_num']) ? 1 : $_REQUEST['page_num'];
		echo paginate_links( array(
			//'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?page_num=%#%',
			'current' => max( 1, $current_page ),
			'total' => $query['max_numb_pages']
		) );
		?>
	</span>
</div>
<?php endif; ?>