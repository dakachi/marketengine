<?php

/**
 * Prints shop categories.
 *
 * Adds an action to print shop categories select input.
 *
 * @return string
 */
$listing_categories = me_get_categories('listing_category');
?>
<?php if ( has_nav_menu( 'category-menu' ) ) : ?>
    <ul class="me-shopcategories <?php if( $listing_categories ) echo 'me-has-category'; ?>">
        <li>
            <span class="marketengine-bar-title"><i class="icon-me-list"></i><span><?php echo __('SHOP CATEGORIES', 'enginethemes'); ?></span></span>
                <nav class="me-nav-category">
                    <div class="me-container">
                        <span class="me-triangle-top"></span>
                        <?php
                            wp_nav_menu( array(
                                'theme_location' => 'category-menu',
                                'menu_class'     => 'me-menu-category',
                            ));
                        ?>
                    </div>
                </nav>
        </li>
    </ul>
<?php endif; ?>
