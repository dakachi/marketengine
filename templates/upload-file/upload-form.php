<div id="<?php echo esc_attr($id); ?>" class="me-upload-wrapper">
    <div class="upload_preview_container">
        <ul class="marketengine-gallery-img">
            <?php
            if($source) {
                if(!$multi) {
                    me_get_template('upload-file/single-file-form', array(
                        'image_id' => $source,
                        'filename' => $name,
                        'close' => apply_filters('me_enable_close', true)
                    ));
                } else {
                    echo $source;
                }
            }
            ?>

        </ul>
    </div>

    <?php
        if(apply_filters('me_enable_upload', true)) {
    ?>
    <span id="<?php echo esc_attr($button); ?>" class="me-gallery-add-img">
        <?php _e("Choose image", "enginethemes"); ?>
    </span>
    <?php
        } else {
            echo apply_filters('me_enable_upload_msg', '');
        }
    ?>

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