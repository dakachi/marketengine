<?php if($listing) : ?>

<?php
$messages = new ME_Message_Query(array('post_parent' => $listing->ID, 'post_type' => 'inquiry', 'showposts' => 12, 'orderby' => 'modified'));
?>

<div class="me-sidebar-contact">
	<span class="me-contact-user-count"><?php printf(__("%d people contact listing", "enginethemes"), $messages->found_posts) ?></span>
	<!-- <div class="me-contact-user-search">
		<input type="text" placeholder="<?php echo __('Search buyer'); ?>">
		<span class="me-user-search-btn"><i class="icon-me-search"></i></span>
	</div> -->
	<div class="me-contact-user-wrap"  >
		<ul id="contact-list" class="me-contact-user-list" data-id="<?php echo $listing->ID; ?>" style="max-height: 620px;overflow: hidden;overflow-y: scroll;" >
			<?php while($messages->have_posts()): $messages->the_post(); ?>
				<?php me_get_template('inquiry/contact-item', array('inquiry' => $_GET['inquiry_id'])); ?>
			<?php endwhile; ?>
		</ul>
		<?php if($messages->max_num_pages > 1) { ?>

		<?php } ?>
	</div>
</div>
<?php endif;?>