<?php
/**
 * The Template for displaying listing list.
 *
 * This template can be overridden by copying it to yourtheme/marketengine/listing-list.php.
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 *
 * @since 		1.0.0
 *
 * @version     1.0.0
 *
 */
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
$users_1         = new WP_User_Query(array(
                'search'         => "tien",
                'search_columns' => array(
                    'display_name'
                )
            ));

            $users_found = $users_1->get_results();
            echo "<pre>";
            print_r($users_found);
            echo "</pre>";
?>
<div class="marketengine-listing-post">
	<?php if(have_posts()) : ?>
		<ul class="me-listing-post me-row">
			<?php
			while (have_posts()) : the_post();
				me_get_template( 'loop/content-listing' );
			endwhile;
			?>
		</ul>

	<?php else :
		me_get_template( 'loop/content-listing-none' );
	endif; ?>
</div>
<?php me_get_template('listing-pagination'); ?>