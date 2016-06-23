<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

global $post;
$listing = new ME_Listing_Purchase($post);
$galleries = $listing->get_galleries();
?>
<div class="me-images">
	<div class="me-image-large">
		<a class="me-large-fancybox">
			<img src="<?php echo wp_get_attachment_image_url( $galleries[0], 'large' ); ?>" alt="<?php the_title(); ?>">
		</a>
	</div>
	<div class="me-image-thumbs">
		<div class="me-thumbs-slider">
			<ul class="me-list-thumbs">
			<?php foreach ($galleries as $key => $value) : ?>
				<li>
					<a href="<?php echo wp_get_attachment_image_url( $value, 'large' ); ?>" medium-img="<?php echo wp_get_attachment_image_url( $value, 'large' ); ?>" rel="gallery" class="me-fancybox">
						<img src="<?php echo wp_get_attachment_image_url( $value, 'thumbnail' ); ?>" alt="<?php the_title('', '-'. $key); ?>">
					</a>
				</li>
			<?php endforeach; ?>
			<a class="me-next"></a><a class="me-prev me-deactive"></a>
		</div>
	</div>
</div>