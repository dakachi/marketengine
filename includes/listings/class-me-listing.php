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

    public function __construct($post, $args) {
        $this->post = $post;
        $this->id   = $post->ID;
    }

    public function get_listing_type() {
        return get_post_meta($this->id, 'listing_type', true);
    }

}

function me_get_listing_types() {
    $listing_types = array(
        'contact'    => __("Offering", "enginethemes"),
        'purchasion' => __("Selling", "enginethemes"),
    );
    return apply_filters('me_get_listing_types', $listing_types);
}