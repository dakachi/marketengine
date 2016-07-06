<?php 
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
?>
<?php  get_header(); ?>

<div class="marketengine">

<?php if(have_posts()) : ?>

<ul class="me-listing-post me-row">

<?php 
while (have_posts()) : the_post();
	me_get_template_part('content','listing');
endwhile;
?>

</ul>

<?php
else :
	me_get_template_part( 'listing', 'none' );
endif;
?>

</div>
<?php get_footer(); ?>