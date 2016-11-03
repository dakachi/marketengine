<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

switch ($file_type['ext']) {
	case 'jpeg':
	case 'png':
	case 'jpeg':
	case 'jpg' :
	case 'gif' :
		?>
		<a href="<?php echo $url; ?>" class="mess-file-item" title="<?php echo $name; ?>">
			<?php echo wp_get_attachment_image( $file_id, 'thumbnail'); ?>
		</a>
		<?php
		return ;
		break;
	case 'pdf' :
		echo '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>';
		break;
	case 'docx' :
	case 'doc' :
		echo '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>';
		break;
	default:
		echo '<i class="fa fa-file-code-o" aria-hidden="true"></i>';
		break;
}
?>
<a href="<?php echo $url; ?>" class="mess-file-item"><?php echo $name ?></a>