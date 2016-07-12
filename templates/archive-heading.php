<div class="me-bar-shop">
	<div class="me-title-shop pull-left">
		<?php
			the_archive_title( '<h2>', '</h2>' );
			the_archive_description( '<div class="taxonomy-description">', '</div>' );
		?>
		<span><?php printf(_n( 'One item in total', "%d items in totals", $wp_query->found_posts, "enginethemes" ), $wp_query->found_posts) ?></span>
	</div>
	<div class="me-sort-listing pull-right">
		<select name="" id="">
			<option value="">Default Sort</option>
			<option value="">Sort by price: low to high</option>
			<option value="">Sort by price: high to low</option>
			<option value="">Sort by average rating</option>
			<option value="">Sort by newness</option>
		</select>
	</div>
</div>