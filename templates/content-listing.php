<li class="item-post me-col-md-3">
	<div class="item-post-wrap">
		<a href="#" class="item-post-img">
			<?php the_post_thumbnail(); ?>
		</a>
		<div class="item-post-content">
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<div class="item-post-price">
				<div class="me-rating pull-left"><i class="icon-font star-on-png"></i><i class="icon-font star-on-png"></i><i class="icon-font star-on-png"></i><i class="icon-font star-half-png"></i><i class="icon-font star-off-png"></i></div>
				<span class="post-price pull-right">Contact</span>
				<div class="clearfix"></div>
			</div>
			<div class="item-by-author">
				<?php printf(__("by %s", "enginethemes"), get_the_author_posts_link()); ?>
			</div>
		</div>
	</div>
</li>