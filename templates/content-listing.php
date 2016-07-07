<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
global $post;
$listing = new ME_Listing($post);
$listing_type = $listing->get_listing_type();

?>
<li class="item-post me-col-md-3">
	<div class="item-post-wrap">
		<a href="#" class="item-post-img">
			<?php the_post_thumbnail(); ?>
		</a>
		<div class="item-post-content">
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<div class="item-post-price">
				
				<?php if('contact' === $listing_type) : ?>
					<span class="post-price pull-right">Contact</span>
				<?php else : ?>
					<div class="me-rating pull-left">
						<i class="icon-font star-on-png"></i>
						<i class="icon-font star-on-png"></i>
						<i class="icon-font star-on-png"></i>
						<i class="icon-font star-half-png"></i>
						<i class="icon-font star-off-png"></i>
					</div>
					<span class="post-price pull-right">$105<span>/Unit</span></span>
				<?php endif; ?>
				
				<div class="clearfix"></div>
			</div>
			<div class="item-by-author">
				<?php printf(__("by %s", "enginethemes"), get_the_author_posts_link()); ?>
			</div>
		</div>
	</div>
</li>