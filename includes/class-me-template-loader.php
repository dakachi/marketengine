<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * ME Template Loader
 *
 * @version     1.0
 * @package     MarketEngine/Includes
 * @author      Dakachi
 * @category    Class
 */
class ME_Template_Loader {

    public static function init_hooks() {
        add_filter('template_include', array(__CLASS__, 'template_include'));
    }

    public static function template_include($template) {
        $find = array();
        $file = '';

        if (is_embed()) {
            return $template;
        }

        if (is_single() && get_post_type() == 'listing') {

            $file = 'single-listing.php';
            $find[] = $file;
            $find[] = ME()->template_path() . $file;

        } elseif (is_tax(get_object_taxonomies('listing_category'))) {

            $term = get_queried_object();

            if (is_tax('listing_cat') || is_tax('listing_tag')) {
                $file = 'taxonomy-' . $term->taxonomy . '.php';
            } else {
                $file = 'archive-listing.php';
            }

            $find[] = 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
            $find[] = ME()->template_path() . 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
            $find[] = 'taxonomy-' . $term->taxonomy . '.php';
            $find[] = ME()->template_path() . 'taxonomy-' . $term->taxonomy . '.php';
            $find[] = $file;
            $find[] = ME()->template_path() . $file;

        } elseif (is_post_type_archive('listing')) {

            $file = 'archive-listing.php';
            $find[] = $file;
            $find[] = ME()->template_path() . $file;

        }

        if ($file) {
            $template = locate_template(array_unique($find));
            if (!$template) {
                $template = ME()->plugin_path() . '/templates/' . $file;
            }
        }
        return $template;
    }

    public static function comments_template_loader($template) {
        if (get_post_type() !== 'product') {
            return $template;
        }

        $check_dirs = array(
            trailingslashit(get_stylesheet_directory()) . ME()->template_path(),
            trailingslashit(get_template_directory()) . ME()->template_path(),
            trailingslashit(get_stylesheet_directory()),
            trailingslashit(get_template_directory()),
            trailingslashit(ME()->plugin_path()) . 'templates/',
        );

        if (ME_TEMPLATE_DEBUG_MODE) {
            $check_dirs = array(array_pop($check_dirs));
        }

        foreach ($check_dirs as $dir) {
            if (file_exists(trailingslashit($dir) . 'single-product-reviews.php')) {
                return trailingslashit($dir) . 'single-product-reviews.php';
            }
        }
    }
}
ME_Template_Loader::init_hooks();