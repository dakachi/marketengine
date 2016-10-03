<?php

/**
 * Prints shop categories.
 *
 * Adds an action to print shop categories select input.
 *
 * @return string
 */
$listing_categories = me_get_categories('listing_category');
if( $listing_categories ) :
?>
    <ul class="me-shopcategories">
        <li>
            <span class="marketengine-bar-title"><i class="icon-me-list"></i><?php echo __('SHOP CATEGORIES', 'enginethemes'); ?></span>
            <nav class="me-nav-category">
                <div class="me-container">
                    <span class="me-triangle-top"></span>
                    <ul class="me-menu-category">
                        <?php foreach( $listing_categories as $category ) : ?>
                            <li><a href="<?php echo get_term_link($category->term_id) ?>"><?php echo esc_html($category->name); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </nav>
        </li>
    </ul>
<?php
endif;