<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

return array(
    'post_author'      => array(
        'user_login'   => 'henrywilson',
        'first_name'   => 'Henry',
        'last_name'    => 'Wilson',
        'user_email'   => 'henrywilson@mailinator.com',
        'location'     => 'UK',
        'user_pass'    => '123',
        'avatar'       => 'avatar-1.jpg',
        'paypal_email' => 'dinhle1987-buyer@yahoo.com',
    ),
    'meta_input'       => array
    (
        'listing_price'    => 538,
        'pricing_unit'     => 'per_unit',
        '_me_listing_type' => 'purchasion',
    ),

    'post_name'        => 'marketengine-sample-listing-2',
    'post_title'       => 'Samsung Galaxy TabPro S 12" SM-W700NZKAXAR Tablet (Black)',
    'post_content'     =>
    "<p>Intel Core m3 Processor Windows 10 Home</p>
        <p><p>Be productive with the included full-size, detachable keyboard with integrated touchpad</p>
        <p>Rich colors and crisp details on the vibrant 12 Super AMOLED display</p>
        <p>With fast charging, get up to 10.5 hours (1) on a single charge</p>
        <p><p>Thin and light, the 2-in-1 Galaxy TabPro S won't weigh you down</p>
        <p>4GB RAM, 128GB Solid State Drive</p>",

    'listing_gallery'  => array
    (
        '0' => 'listing-2.jpg',
        '1' => 'listing-1.jpg',
    ),

    'listing_category' => array(
        'Computers & Tablets', 'Tablets',
    ),

    'listing_tag'      => 'selling tag',
    'post_type'        => 'listing',

    'post_status'      => 'publish',

    'order'            => array(
        array(
            'user_login'   => 'karlabertha',
            'first_name'   => 'Karla',
            'last_name'    => 'Bertha',
            'user_email'   => 'karlabertha@mailinator.com',
            'location'     => 'German',
            'user_pass'    => '123',
            'avatar'       => 'avatar-2.jpg',
            'paypal_email' => 'dinhle1987-per@yahoo.com',
            'review'       => array(
                'content' => 'Great machine but bright and loud.',
                'rate'    => 4,
            ),
        ),
        array(
            'user_login'   => 'malenesara',
            'first_name'   => 'Malene',
            'last_name'    => 'Sara',
            'user_email'   => 'malenesara@mailinator.com',
            'location'     => 'Danish',
            'user_pass'    => '123',
            'avatar'       => 'avatar-2.jpg',
            'paypal_email' => 'dinhle1987-per@yahoo.com',
            'review'       => array(
                'content' => 'I really enjoy this laptop and everything about it is very good quality, especially for gaming, except for the fact of the very small crack in the case this computer is awesome.',
                'rate'    => 5,
            ),
        ),
        array(
            'user_login'   => 'shindaiki',
            'first_name'   => 'Shin',
            'last_name'    => 'Daiki',
            'user_email'   => 'shindaiki@mailinator.com',
            'location'     => 'Japan',
            'user_pass'    => '123',
            'avatar'       => 'avatar-2.jpg',
            'paypal_email' => 'dinhle1987-per@yahoo.com',
            'review'       => array(
                'content' => 'It is a great laptop but the back light bleed kills it. It is only a small portion in the upper left-hand panel but that is unacceptable for a laptop that costs $2000. I am thinking of returning it for this reason',
                'rate'    => 5,
            ),
        ),
        array(
            'user_login'   => 'alanroger',
            'first_name'   => 'Alan',
            'last_name'    => 'Roger',
            'user_email'   => 'alanroger@mailinator.com',
            'location'     => 'France',
            'user_pass'    => '123',
            'avatar'       => 'avatar-2.jpg',
            'paypal_email' => 'dinhle1987-per@yahoo.com',
            'review'       => array(
                'content' => 'This case fit great but cracked after one month.',
                'rate'    => 2,
            ),
        ),

        array(
            'user_login'   => 'alanroger',
            'first_name'   => 'Alan',
            'last_name'    => 'Roger',
            'user_email'   => 'alanroger@mailinator.com',
            'location'     => 'France',
            'user_pass'    => '123',
            'avatar'       => 'avatar-2.jpg',
            'paypal_email' => 'dinhle1987-per@yahoo.com',
            'review'       => array(
                'content' => 'Received the wrong color.',
                'rate'    => 3,
            ),
        ),
        array(
            'user_login'   => 'katelinharper',
            'first_name'   => 'Katelin',
            'last_name'    => 'Harper',
            'user_email'   => 'katelinharper@mailinator.com',
            'location'     => 'UK',
            'user_pass'    => '123',
            'avatar'       => 'avatar-2.jpg',
            'paypal_email' => 'dinhle1987-per@yahoo.com',
            'review'       => array(
                'content' => 'Cracked already and leaves so many hand prints on it. The whole frosting on the case is disappearing slowly. Poor product.',
                'rate'    => 1,
            ),
        ),
    ),
);
