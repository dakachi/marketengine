<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

return array(
    'post_author'      =>
array(
            'user_login'   => 'karlabertha',
            'first_name'   => 'Karla',
            'last_name'    => 'Bertha',
            'user_email'   => 'karlabertha@mailinator.com',
            'location'     => 'German',
            'user_pass'    => '123',
            'avatar'       => 'avatar-2.jpg',
            'paypal_email' => 'dinhle1987-per@yahoo.com',
        ),
    'meta_input'       => array
    (
        'listing_price'    => 380,
        'pricing_unit'     => 'per_unit',
        '_me_listing_type' => 'purchasion',
    ),

    'post_name'        => 'marketengine-sample-listing-8',
    'post_title'       => 'Sharp LC-55N7000U 55-Inch 4K Ultra HD Smart LED TV',
    'post_content'     =>
        "
<p>
    Refresh Rate: 120Hz (Native)
</p>
<p>
    Backlight: LED
</p>
<p>
    Smart Functionality: Yes
</p>
<p>
    Dimensions (W x H x D): TV with stand: 49.0 x 30.4 x 9.2
</p>
<p>
    Inputs: 1 built-in tuner, 4 HDMI ports, 3 USB ports, 1 digital audio output, 1 earphone audio output, 1 RCA component input, 1 RCA composite input
</p>
"
,

    'listing_gallery'  => array
    (
        '0' => 'listing-2.jpg',
        '1' => 'listing-1.jpg',
    ),

    'listing_category' => array(
        'Televisions & Video', 'Televisions',
    ),

    'listing_tag'      => 'selling tag',
    'post_type'        => 'listing',

    'post_status'      => 'publish'
);
