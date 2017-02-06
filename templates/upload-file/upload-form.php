<div id="<?php echo esc_attr($id); ?>" class="me-upload-wrapper <?php if(!$multi) { echo 'me-single-image';} ?>">
    <div class="upload_preview_container">
        <ul class="marketengine-gallery-img">
            <?php
            if($source) {
                if(!$multi) {
                    marketengine_get_template('upload-file/single-file-form', array(
                        'image_id' => $source,
                        'filename' => $name,
                        'close' => $close
                    ));
                } else {
                    echo $source;
                }
            }
            ?>

        </ul>
    </div>
    <div class="upload-container">
        <span id="<?php echo esc_attr($button); ?>" class="<?php echo esc_attr($button); ?> me-gallery-add-img">
            <?php _e("Choose image", "enginethemes"); ?>
        </span>
    </div>
</div>