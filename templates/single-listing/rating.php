<?php 
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

global $post;
$listing = new ME_Listing($post);
$review_count = $listing->get_review_count();
?>

<?php do_action('marketengine_before_single_listing_rating'); ?>

<div class="me-comments">
	<div class="marketengine-comments">
		<h3 class="me-title-comment"><?php printf(_n("Review (%d)", "Reviews (%d)", $review_count,"enginethemes"),$review_count ); ?></h3>
		<?php if ( have_comments() ) : ?>
		<div class="me-row">
			<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating"  class="me-col-md-3">
				<div class="me-count-rating">
					<meta itemprop="worstRating" content = "1">
					<meta itemprop="bestRating" content = "10">
					<span itemprop="ratingValue" class="me-count">8,6</span>
					<div class="me-rating"><i class="icon-font star-on-png"></i><i class="icon-font star-on-png"></i><i class="icon-font star-on-png"></i><i class="icon-font star-half-png"></i><i class="icon-font star-off-png"></i></div>
					<span class="me-base-review">
						Based on <?php printf(_n('<b itemprop="reviewCount">%d<b> review', '<b itemprop="reviewCount">%d<b> reviews', $review_count,"enginethemes"),$review_count ); ?>
					</span>
				</div>
			</div>
			<div class="me-col-md-9">
				<div class="me-count-author">
					<div class="me-rating-author">
						
					</div>
					<div class="me-rating-author"></div>
					<div class="me-rating-author"></div>
					<div class="me-rating-author"></div>
					<div class="me-rating-author"></div>
				</div>
			</div>
		</div>
		
		<ul class="me-comment-list">
		<?php for ($i=0; $i < 3; $i++) : ?>
			<li itemprop="review" itemscope itemtype="http://schema.org/Review" class="me-media">	
				<div class="">
					<a href="" class="avatar-comment pull-left">
						<img src="http://0.gravatar.com/avatar/c655f931959fd28e3594563edd348833?s=60&amp;d=mm&amp;r=G" alt="">
					</a>
					<div class="me-media-body">
						<h4 itemprop="author" class="me-media-heading">Author</h4>
						
						<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="me-rating">
							<i class="icon-font star-on-png"></i>
							<i class="icon-font star-on-png"></i>
							<i  class="icon-font star-on-png"></i>
							<i class="icon-font star-half-png"></i>
							<i class="icon-font star-off-png"></i>
							<div style="display:none" >
								<meta itemprop="worstRating" content = "1">
						      	<span itemprop="ratingValue">4</span>/
						      	<span itemprop="bestRating">10</span>stars
						    </div>
						</div> 
						<span itemprop="datePublished" content="2011-03-25" class="pull-right">May 23, 2016</span>
						
						<div itemprop="description" class="me-comment-text">
							<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in </p>
						</div>
					</div>
				</div>
				<ul class="me-comment-children">
					<li class="me-media">
						<div class="">
							<a href="" class="avatar-comment pull-left">
								<img src="http://0.gravatar.com/avatar/c655f931959fd28e3594563edd348833?s=60&amp;d=mm&amp;r=G" alt="">
							</a>
							<div class="me-media-body">
								<h4 class="me-media-heading">Author <div class="me-rating"><i class="icon-font star-on-png"></i><i class="icon-font star-on-png"></i><i class="icon-font star-on-png"></i><i class="icon-font star-half-png"></i><i class="icon-font star-off-png"></i></div> <span class="pull-right">May 23, 2016</span></h4>
								<div class="me-comment-text">
									<p>When an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in </p>
								</div>
							</div>
						</div>
					</li>
					<li class="me-media">
						<div class="">
							<a href="" class="avatar-comment pull-left">
								<img src="http://0.gravatar.com/avatar/c655f931959fd28e3594563edd348833?s=60&amp;d=mm&amp;r=G" alt="">
							</a>
							<div class="me-media-body">
								<h4 class="me-media-heading">Author <div class="me-rating"><i class="icon-font star-on-png"></i><i class="icon-font star-on-png"></i><i class="icon-font star-on-png"></i><i class="icon-font star-half-png"></i><i class="icon-font star-off-png"></i></div> <span class="pull-right">May 23, 2016</span></h4>
								<div class="me-comment-text">
									<p>When an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in </p>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</li>
			<?php endfor; ?>
		</ul>
			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="me-pagination">';
				paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
					'prev_text' => '&larr;',
					'next_text' => '&rarr;',
					'type'      => 'list',
				) ) );
				echo '</nav>';
			endif; ?>
		<?php else : ?>

			<p class="me-noreviews"><?php _e( 'There are no reviews yet.', 'enginethemes' ); ?></p>

		<?php endif; ?>
	</div>
	
</div>

<?php do_action('marketengine_after_single_listing_rating'); ?>