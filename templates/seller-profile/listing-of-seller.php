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
	'post_author' => $user_id,
	'post_type'   => 'listing',
	'paged'		  => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
);

$args = apply_filters( 'filter_listing_query', $args );

query_posts( $args );

?>

<ul class="me-listing-seller">

<?php
	if( have_posts() ) :
		while( have_posts() ) : the_post();
			me_get_template('seller-profile/listing-item');
		endwhile;
?>
	<div class="marketengine-paginations">
		<?php me_paginate_link(); ?>
	</div>
<?php
		wp_reset_query();
	else:
		_e('..', 'enginethemes');
	endif;
?>

</ul>