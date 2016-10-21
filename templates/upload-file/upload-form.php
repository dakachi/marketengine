<div id="<?php echo esc_attr($id); ?>" class="upload_wrapper">
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
            
            <?php
                if(apply_filters('me_enable_upload', true)) {
            ?>
            <li id="<?php echo esc_attr($button); ?>" class="me-item-img">
                <span class="me-gallery-img me-gallery-add-img">
                    <a class="me-add-img">
                        <i class="icon-me-add"></i>
                    </a>
                </span>
            </li>
            <?php
                } else {
                    echo apply_filters('me_enable_upload_msg', '');
                }
            ?>

        </ul>
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