<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>

<?php do_action('marketengine_before_main_content'); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<?php do_action('marketengine_before_single_listing_content'); ?>

	<?php me_get_template( 'content-single-listing' ); ?>

	<?php do_action('marketengine_after_single_listing_content'); ?>

<?php endwhile; // end of the loop. ?>

<?php do_action('marketengine_after_main_content'); ?>

<?php get_footer();