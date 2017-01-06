<?php 
get_header();
$case_id = get_query_var( 'case_id' );
$case = me_get_message($case_id);
?>
<div id="marketengine-page">
    <div class="me-container">
        <div class="marketengine-content-wrap">

            <?php me_get_template('resolution/case-details/heading', array('case' => $case)); ?>
            <!-- marketengine-content -->
            <div class="marketengine-content">
                
                <?php me_get_template('resolution/case-details/mobile-nav'); ?>

                <div class="me-disputed-case">
                    
                    <?php me_get_template('resolution/case-details/info', array('case' => $case)); ?>

                    <div class="me-disputed-conversation">
                        <div class="me-row">
                            <div class="me-col-md-3 me-col-md-pull-9 me-col-sm-4 me-col-sm-pull-8">
                                <div class="me-sidebar-contact">
                                    <div class="me-party-involve">
                                        <h3><?php _e("Related Party", "enginethemes"); ?></h3>
                                        <p>Seller:<span>Supper seller</span></p>
                                        <p>Buyer:<span>Supper seller buy</span></p>
                                    </div>
                                    <div class="me-dispute-event">
                                        <h3><?php _e("Dispute Event", "enginethemes"); ?></h3>
                                        <?php
                                            $message_query = new ME_Message_Query(array('post_type' => 'revision', 'post_parent' => $case->ID, 'showposts' => 12));
                                            $revisions = $message_query->posts;
                                        ?>

                                        <?php foreach ($revisions  as $key => $message) : ?>
                                        <a href="#">
                                            <?php switch ($message->post_status) {
                                                case 'me-closed':
                                                    _e("<span>Close dispute</span>", "enginethemes");
                                                    break;
                                                case 'me-escalated' :
                                                    _e("<span>Escalate dispute</span>", "enginethemes");
                                                    break;
                                                case 'me-waiting' :
                                                        _e("<span>Close dispute request</span>", "enginethemes");
                                                    break;
                                            }
                                            ?>
                                            <span><?php echo date_i18n( get_option('date_format'),  strtotime($message->post_date) ); ?></span>
                                        </a>
                                        <?php endforeach; ?>
                                        
                                        <a href="#">
                                            <span><?php _e("Dispute started", "enginethemes"); ?></span>
                                            <span><?php echo date_i18n( get_option('date_format'),  strtotime($case->post_date) ); ?></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="me-col-md-9 me-col-md-push-3 me-col-sm-8 me-col-sm-push-4">
                                <div class="me-contact-messages-wrap">
                                    <div class="me-contact-message-user">
                                        <p>
                                            <?php 
                                            if(get_current_user_id() == $case->sender) {
                                                echo get_the_author_meta( 'display_name', $case->receiver );
                                            }else {
                                                echo get_the_author_meta( 'display_name', $case->sender );
                                            }
                                            ?>
                                        </p>
                                    </div>

                                    <?php 
                                        $message_query = new ME_Message_Query(array('post_type' => array('message', 'revision'), 'post_parent' => $case->ID, 'showposts' => 12));
                                        	$messages = array_reverse ($message_query->posts);
                                    ?>
                                    
                                    <div class="me-contact-messages">
                                        <ul class="me-contact-messages-list">
                                        <?php if( $messages ) : ?>
										<?php foreach ($messages  as $key => $message) : ?>
											<?php 
                                            if($message->post_type == 'revision') {
                                                me_get_template('resolution/revision-item', array('message' => $message));
                                            }else {
                                                me_get_template('resolution/message-item', array('message' => $message));    
                                            }
                                             ?>
										<?php endforeach; ?>
										<?php endif; ?>
                                            
                                        </ul>
                                    </div>
                                    
                                    <div class="me-message-typing-form">
                                        <form id="me-message-form" action="">
                                            <textarea name="" placeholder="New message"></textarea>
                                            <div class="me-dispute-attachment">
                                                <div class="me-row">
                                                    <div class="me-col-lg-10 me-col-md-9">
                                                        <p>
                                                            <label class="me-dispute-attach-file" for="me-dispute-file">
                                                                <input id="me-dispute-file" type="file">
                                                                <i class="icon-me-attach"></i>
                                                                Add attachment
                                                            </label>
                                                        </p>
                                                        <ul class="me-list-dispute-attach">
                                                            <li>abc.file<span class="me-remove-dispute-attach"><i class="icon-me-remove"></i></span></li>
                                                            <li>ksafdkl.sf<span class="me-remove-dispute-attach"><i class="icon-me-remove"></i></span></li>
                                                            <li>Kronog backls<span class="me-remove-dispute-attach"><i class="icon-me-remove"></i></span></li>
                                                            <li>con duong mua dnoh nkd.sf<span class="me-remove-dispute-attach"><i class="icon-me-remove"></i></span></li>
                                                        </ul>
                                                    </div>
                                                    <div class="me-col-lg-2 me-col-md-3">
                                                        <input class="marketengine-btn me-dispute-message-btn" type="submit" value="submit">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--// marketengine-content -->
        </div>
    </div>
</div>
<?php
get_footer();
?>
