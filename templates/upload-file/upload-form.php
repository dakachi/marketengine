<div id="<?php echo esc_attr($id); ?>" class="me-upload-wrapper <?php if(!$multi) { echo 'me-single-image';} ?>">
    <div class="upload_preview_container">
        <ul class="marketengine-gallery-img">
            <?php
            if($source) {
                if(!$multi) {
                    me_get_template('upload-file/single-file-form', array(
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
<script>
    (function ($) {
        $(document).ready(function(){
            $('#<?php echo esc_js($id); ?>').jUploader({
                browse_button: '<?php echo esc_js($button); ?>',
                multi: <?php echo $multi ? "true" : "false"; ?>,
                name: <?php echo "'" . esc_js($name) . "'" ?>,
                extension: 'jpg,jpeg,gif,png',
                upload_url: '<?php echo admin_url('admin-ajax.php') . '?nonce=' . wp_create_nonce('marketengine') ?>',
                <?php echo isset($maxsize) ? "maxsize : '$maxsize',\n" : ""; ?>
                <?php echo isset($maxwidth) ? "maxwidth : $maxwidth,\n" : ""; ?>
                <?php echo isset($maxheight) ? "maxheight : $maxheight,\n" : ""; ?>
                <?php echo isset($maxcount) ? "maxcount : $maxcount,\n" : ""; ?>
            });
        });
    })(jQuery);
</script>