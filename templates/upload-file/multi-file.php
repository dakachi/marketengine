<?php
/**
 * 	The Template for displaying file uploader.
 * 	This template can be overridden by copying it to yourtheme/marketengine/upload-file/multi-file.php.
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 * @since       1.0.0
 * @version     1.0.0
 */
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
$attached_file = get_attached_file($image_id);
$file_name     = basename($attached_file);
?>
<li class="me-item-img" title="<?php _e("Drag to sort", "enginethemes"); ?>">
	<input type="hidden" name="<?php echo esc_attr($filename); ?>[]" value="<?php echo esc_attr($image_id) ?>">
	<?php echo $file_name; ?><a class="me-delete-img remove"></a>
</li>