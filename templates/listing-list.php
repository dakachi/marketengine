<?php
/**
 * 	The Template for displaying listing list.
 * 	This template can be overridden by copying it to yourtheme/marketengine/listing-list.php.
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 * @version     1.0.0
 */
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