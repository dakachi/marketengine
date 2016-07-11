<?php 
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

global $wp_query;
?>

<?php  get_header(); ?>

<div id="marketengine-page">
	<div class="me-container marketengine">
		<div class="marketengine-content-wrap">
			<div class="marketengine-page-title">
				<p><?php _e("SHOP", "enginethemes"); ?></p>
			</div>
			<!-- marketengine-content -->
			<div class="marketengine-content">
				<div class="me-row">
					<div class="me-col-md-3">
						<?php do_action('marketengine_sidebar'); ?>
					</div>
					<div class="me-col-md-9 marketengine-snap-column">
						<div class="me-content-shop">
							<div class="me-bar-shop">
								<div class="me-title-shop pull-left">
									<?php
										the_archive_title( '<h2 class="page-title">', '</h2>' );
										the_archive_description( '<div class="taxonomy-description">', '</div>' );
									?>
									<span><?php printf(_n( 'One item in total', "%d items in totals", $wp_query->found_posts, "enginethemes" ), $wp_query->found_posts) ?></span>
								</div>
								<div class="me-sort-listing pull-right">
									<select name="" id="">
										<option value="">Sort items</option>
										<option value="">Low price</option>
										<option value="">Height price</option>
										<option value="">Alphabe name</option>
									</select>
								</div>
							</div>
							<div class="clearfix"></div>
							
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
							<div class="marketengine-paginations">
								<?php me_paginate_link (); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--// marketengine-content -->
	</div>
</div>

<?php get_footer(); ?>