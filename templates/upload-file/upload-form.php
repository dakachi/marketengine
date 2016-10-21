<div id="<?php echo esc_attr($id); ?>" class="upload_wrapper">
    <div class="upload_preview_container">
        <ul class="marketengine-gallery-img">
            <?php
            if($source) {
                if(!$multi) {
                    jeg_get_template_part('upload-file/single-image-form', array(
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
    <div id="<?php echo esc_attr($button); ?>" class="btn btn-default btn-sm btn-block-xs">
        <i class="fa fa-folder-open-o"></i>
        <?php _e('Choose Image', 'enginethemes'); ?>
    </div>
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