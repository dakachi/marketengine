<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// xac dinh chinh xac 1 thuc the listing
class ME_Listing {
    /**
     * @var int $id
     */
    public $id;
    /**
     * @var object $post
     */
    public $post;
    /**
     * @var string $listing_type
     * listing type such as contact, purchase, rental
     */
    public $listing_type;

    public function __construct($post, $args = array()) {
        if (is_numeric($post)) {
            $post = get_post($post);
        }
        $this->post = $post;
        $this->id   = $post->ID;
    }
    public function get_id() {
        return $this->id;
    }
    public function get_title() {
        return get_the_title($this->id);
    }

    public function get_description() {
        return $this->post->post_content;
    }

    public function get_listing_type() {
        return get_post_meta($this->id, '_me_listing_type', true);
    }
    /**
     * Retrieve the number of product's reviews
     * 
     * @since 1.0
     * @return int
     */
    public function get_review_count() {
        return absint(get_post_meta($this->id, '_me_review_count', true));
    }

    /**
     * Retrieve the number of product's orders
     *
     * @since 1.0
     * @return int
     */
    public function get_order_count() {
        return absint(get_post_meta($this->id, '_me_order_count', true));
    }

    /**
     * Retrieve listing galleries
     *
     * @since 1.0
     * @return array
     */
    public function get_galleries() {
        $gallery      = get_post_meta($this->id, '_me_listing_gallery', true);
        $thumbnail_id = get_post_meta($this->id, '_thumbnail_id', true);
        if ($thumbnail_id) {
            array_unshift($gallery, $thumbnail_id);
        }
        return (array) $gallery;
    }

    /**
     * Make sure the listing is available for sale
     *
     * @since 1.0
     * @return bool
     */
    public function is_available() {
        return 'listing' === $this->post->post_type;
    }
}