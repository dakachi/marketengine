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
            'source' => '', //$company_gallery,
            'button' => 'btn-listing-image',
            'multi' => false,
            'maxsize' => esc_html( '2mb' ),
            'maxcount' => 5
        ));
        ?>
    </div>
</div>
<div class="marketengine-group-field">
    <div class="marketengine-upload-field">
        <label class="text" for="upload_company_gallery"><?php _e('Gallery', 'enginethemes'); ?></label>
        <?php
        // $company_gallery = get_children(
        //     array(
        //         'order'				=> 'ASC',
        //         'orderby'			=>'menu_order',
        //         'post_parent' 		=> get_the_ID(),
        //         'post_type' 		=> 'attachment',
        //         'post_mime_type' 	=>'image'
        //     )
        // );

        // ob_start();
        // if($company_gallery) {
        //     foreach($company_gallery as $gallery) {
        //         jeg_get_template_part('additional/multi-image-form', array(
        //             'image_id' => $gallery->ID,
        //             'filename' => 'company_gallery',
        //             'close' => apply_filters('jeg_enable_close', true)
        //         ));
        //     }
        // }
        // $company_gallery = ob_get_clean();

        me_get_template('upload-file/upload-form', array(
            'id' => 'upload_listing_gallery',
            'name' => 'listing_gallery',
            'source' => '', //$company_gallery,
            'button' => 'me-btn-upload',
            'multi' => true,
            'maxsize' => esc_html( '2mb' ),
            'maxcount' => 5
        ));
        ?>
    </div>
</div>