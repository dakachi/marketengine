<?php
$filename_only = wp_get_attachment_url( $image_id );// basename( get_attached_file( $image_id ) );
?>
<li class="me-item-img">
	<span class="me-gallery-img">
	    <input type="hidden" name="<?php echo esc_attr($filename); ?>" value="<?php echo esc_attr($image_id) ?>">
	    <img src="<?php echo $filename_only; ?>" alt="">
		<a class="me-delete-img remove"></a>
	</span>
</li>