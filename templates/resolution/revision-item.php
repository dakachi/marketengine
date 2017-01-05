<li class="me-contact-dispute-event">
<?php 
switch ($message->post_status) :
	case 'me-closed':
		$name = get_the_author_meta( 'display_name', $message->sender );
	?>
		<p>			
			<?php printf(__("<b>%s</b> <i>has closed the dipute</i>", "enginethemes"), $name); ?>
		</p>
	<?php
		break;
	case 'me-waiting':
		$name = get_the_author_meta( 'display_name', $message->receiver );
	?>
		<p>			
			<?php printf(__("<b>%s</b> <i>has requested to closed the dipute</i>", "enginethemes"), $name); ?>
		</p>
	<?php
endswitch;
 ?>
	<span><?php echo date_i18n(get_option('date_format') .' ' . get_option('time_format') ,strtotime($message->post_date) ); ?></span>
</li>