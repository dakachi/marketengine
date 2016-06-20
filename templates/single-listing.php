<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<?php me_get_template_part( 'content', 'single-listing' ); ?>

<?php endwhile; // end of the loop. ?>

<?php get_footer();