<?php do_action('marketengine_before_post_listing_picture_form');?>
<div class="marketengine-group-field">

	<?php do_action('marketengine_before_post_listing_image_form');?>

	<div class="marketengine-upload-field">
		<label class="text"><?php _e("Your listing image", "enginethemes");?>&nbsp;<small><?php _e("(optional)", "enginethemes");?></small></label>
		<input type="file" name='listing_image' accept="image/*" />
	</div>

	<?php do_action('marketengine_after_post_listing_image_form');?>

</div>
<div class="marketengine-group-field">

	<?php do_action('marketengine_before_post_listing_gallery_form');?>

	<div class="marketengine-upload-field">
		<label class="text"><?php _e("Gallery", "enginethemes");?>&nbsp;<small><?php _e("(optional)", "enginethemes");?></small></label>
		<input type="file" name='listing_gallery[]' multiple accept="image/*" />
	</div>

	<?php do_action('marketengine_after_post_listing_gallery_form');?>

</div>
<?php do_action('marketengine_after_post_listing_picture_form');?>
<style type="text/css">
	li.uploading {
    border: 1px dashed #ccc;
    width: 130px;
    height: 80px;
    display: inline-block;
    position: relative;
}

li .uploading-progress {
    height: 100%;
    background: #eee;
    width: 0;

    -webkit-transition: width 0.6s ease 0s;
    -moz-transition: width 0.6s ease 0s;
    -o-transition: width 0.6s ease 0s;
    -ms-transition: width 0.6s ease 0s;
}
</style>
<div class="marketengine-group-field">
    <div class="marketengine-upload-field">
        <label class="text" for="upload_company_gallery"><?php _e('Your listing image', 'enginethemes'); ?></label>
        <?php
        me_get_template('upload-file/upload-form', array(
            'id' => 'upload_listing_image',
            'name' => 'listing_image',
            'source' => $listing_image,
            'button' => 'btn-listing-image',
            'multi' => false,
            'maxsize' => esc_html( '2mb' ),
            'maxcount' => 1
        ));
        ?>
    </div>
</div>
<div class="marketengine-group-field">
    <div class="marketengine-upload-field">
        <label class="text" for="upload_company_gallery"><?php _e('Gallery', 'enginethemes'); ?></label>
        <?php

        ob_start();
        if($listing_gallery) {
            foreach($listing_gallery as $gallery) {
                me_get_template('upload-file/multi-file-form', array(
                    'image_id' => $gallery,
                    'filename' => 'listing_gallery',
                    'close' => true
                ));
            }
        }
        $listing_gallery = ob_get_clean();

        me_get_template('upload-file/upload-form', array(
            'id' => 'upload_listing_gallery',
            'name' => 'listing_gallery',
            'source' => $listing_gallery,
            'button' => 'me-btn-upload',
            'multi' => true,
            'maxsize' => esc_html( '2mb' ),
            'maxcount' => 5
        ));
        ?>
    </div>
</div>