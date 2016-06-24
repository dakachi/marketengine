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
        $this->post = $post;
        $this->id = $post->ID;
    }

    public function get_listing_type() {
        return get_post_meta($this->id, '_me_listing_type', true);
    }

    public function get_review_count() {
        return get_post_meta($this->id, '_me_review_count', true);
    }

    public function get_order_count() {
        return get_post_meta($this->id, '_me_order_count', true);   
    }

    public function get_galleries() {
        $gallery = get_post_meta($this->id, '_me_listing_gallery', true);
        $thumbnail_id = get_post_meta( $this->id, '_thumbnail_id', true );
        if($thumbnail_id) {
            array_unshift($gallery, $thumbnail_id);    
        }        
        return (array)$gallery;
    }
}