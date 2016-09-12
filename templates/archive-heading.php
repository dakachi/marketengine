<?php 
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
$selected = !empty($_GET['orderby']) ? $_GET['orderby'] : ''; 
global $wp_query;
?>
<div class="me-bar-shop">
	<div class="me-title-shop pull-left">
		<?php
			the_archive_title( '<h2>', '</h2>' );
			the_archive_description( '<div class="taxonomy-description">', '</div>' );
		?>
		<span><?php printf(_n( 'One item in total', "%d items in totals", $wp_query->found_posts, "enginethemes" ), $wp_query->found_posts) ?></span>
	</div>
	<div class="me-sort-listing pull-right">
		<form method="get">
			<select name="orderby" id="listing-orderby">
				<option <?php selected( $selected, '') ?> value=""><?php _e("Default Sort", "enginethemes"); ?></option>
				<option <?php selected( $selected, 'rating') ?> value="rating"><?php _e("Sort by average rating", "enginethemes"); ?></option>
				<option <?php selected( $selected, 'date') ?> value="date"><?php _e("Sort by newness", "enginethemes"); ?></option>
				<option <?php selected( $selected, 'price') ?> value="price"><?php _e("Sort by price: low to high", "enginethemes"); ?></option>
				<option <?php selected( $selected, 'price-desc') ?> value="price-desc"><?php _e("Sort by price: high to low", "enginethemes"); ?></option>
			</select>
			<?php  if(!empty($_GET['price-min'])) : ?>
				<input type="hidden" name="price-min" value="<?php echo $_GET['price-min'];  ?>" ?>
			<?php endif; ?>
			<?php if(!empty($_GET['price-max'])) : ?>
				<input type="hidden" name="price-max" value="<?php echo $_GET['price-max'];  ?>" ?>
			<?php  endif; ?>
		</form>
	</div>
</div>