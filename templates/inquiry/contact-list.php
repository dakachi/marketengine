<?php if($listing) : ?>

<?php 
$messages = new ME_Message_Query(array('post_parent' => $listing->ID, 'post_type' => 'inquiry'));
?>

<div class="me-sidebar-contact">
	<span class="me-contact-user-count"><?php printf(__("%d people contact listing", "enginethemes"), $messages->found_posts) ?></span>
	<div class="me-contact-user-search">
		<input type="text" placeholder="<?php echo __('Search buyer'); ?>">
		<span class="me-user-search-btn"><i class="icon-me-search"></i></span>
	</div>
	<div class="me-contact-user-wrap" >
		<ul class="me-contact-user-list">
			<?php while($messages->have_posts()): $messages->the_post(); ?>
				<?php $message = me_get_message(); ?>
				<li <?php if($message->ID == $_GET['inquiry_id']) {echo 'class="active"';} ?>>
					<a href="<?php echo add_query_arg('inquiry_id', $message->ID); ?>">
						<span class="me-user-avatar">
							<?php echo get_avatar( $message->sender, 36); ?>
						</span>
						<span class="me-contact-author">
							<span><?php echo get_the_author_meta( 'display_name', $message->sender ); ?></span>
						</span>
					</a>
				</li>
			<?php endwhile; ?>
		</ul>
	</div>
</div>
<?php endif;?>