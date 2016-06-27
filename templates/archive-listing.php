<?php 
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
get_header();

while (have_posts()) : the_post();
?>
<div itemscope itemtype="http://schema.org/Product">
	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title( '<h3 itemprop="name">', '<h3>'); ?></a>
</div>
<?php
endwhile;

get_footer();