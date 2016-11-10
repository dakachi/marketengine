<?php
/**
 * 	The Template for displaying listings of seller.
 * 	This template can be overridden by copying it to yourtheme/marketengine/seller-profile/listing-of-seller.php.
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 * @version     1.0.0
 */

$args = array(
	'author' => $user_id,
	'post_type' => 'listing',
	'paged'		=> get_query_var('paged') ? get_query_var('paged') : 1,
);
$args = apply_filters( 'filter_listing_query', $args );

$query = new WP_Query( $args );
// print_var($query);

?>

<ul class="me-listing-seller">

<?php
	if( $query->have_posts() ) :
		while( $query->have_posts() ) : $query->the_post();
			me_get_template('seller-profile/listing-item');
		endwhile;
?>
	<div class="marketengine-paginations">
		<?php me_paginate_link($query); ?>
	</div>
<?php
		wp_reset_postdata();
	else:
		_e('No listings to display', 'enginethemes');
	endif;
?>

</ul>