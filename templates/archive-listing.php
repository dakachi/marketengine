<?php 
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

global $wp_query;
?>

<?php  get_header(); ?>

<?php do_action('marketengine_before_main_content'); ?>

<div id="marketengine-page">
	<div class="me-container marketengine">
		<div class="marketengine-content-wrap">
			<div class="marketengine-page-title">
				<p><?php _e("SHOP", "enginethemes"); ?></p>
			</div>
			<!-- marketengine-content -->
			<div class="marketengine-content"> 
				<div class="me-row">
					<div class="me-col-md-9 marketengine-snap-column">
						<div class="me-content-shop">

							<?php me_get_template_part('archive', 'heading') ?>

							<div class="marketengine-listing-post">
							
								<?php if(have_posts()) : ?>

									<ul class="me-listing-post me-row">
										<?php 
										while (have_posts()) : the_post();
											me_get_template_part('content','listing');
										endwhile;
										?>
									</ul>

								<?php else :
									me_get_template_part( 'listing', 'none' );
								endif; ?>
							</div>
							<div class="marketengine-paginations">
								<?php me_paginate_link (); ?>
							</div>

						</div>
					</div>
					
					<?php do_action('marketengine_sidebar'); ?>
					
				</div>
			</div>
		</div>
		<!--// marketengine-content -->
	</div>
</div>

<?php do_action('marketengine_after_main_content'); ?>

<?php get_footer(); ?>