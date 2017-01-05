<?php 
get_header();
$case_id = get_query_var( 'p' );
$case = me_get_message($case_id);
$transaction = me_get_order($case->post_parent);
$items = $transaction->get_listing_items();
$item = array_pop($items);
?>
<div id="marketengine-page">
    <div class="me-container">
        <div class="marketengine-content-wrap">
            <div class="marketengine-page-title">
                <h2>
                    <?php _e("DISPUTED CASE", "enginethemes"); ?>
                </h2>
                <ol class="me-breadcrumb">
                    <li>
                        <a href="<?php echo me_resolution_center_url(); ?>">
                            <?php _e("Resolution Center", "enginethemes"); ?>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            #<?php echo $case_id; ?>
                        </a>
                    </li>
                </ol>
            </div>
            <!-- marketengine-content -->
            <div class="marketengine-content">
                <!--Display mobile-->
                <div class="me-dispute-contact-header">
                    <ul class="me-dispute-contact-tabs">
                        <li class="me-dispute-case-tabs">
                            <span>
                                <?php _e("Case Info", "enginethemes"); ?>
                            </span>
                        </li>
                        <li class="me-dispute-action-tabs">
                            <span>
                                <?php _e("Action Info", "enginethemes"); ?>
                            </span>
                        </li>
                        <li class="me-dispute-related-tabs">
                            <span>
                                <?php _e("Related Party &amp; Event", "enginethemes"); ?>
                            </span>
                        </li>
                    </ul>
                </div>

                <div class="me-disputed-case">
                    <div class="me-disputed-info">
                        <div class="me-disputed-product-order">
                            <div class="me-row">
                                <div class="me-col-md-6">
                                    <div class="me-disputed-order-info">
                                        <h3>
                                            <?php _e("Case infomation", "enginethemes"); ?>
                                        </h3>
                                        <p>
                                            <span>
                                                <?php _e("Case status:", "enginethemes"); ?>
                                            </span>
                                            <?php echo me_dispute_status_label($case->post_status); ?>
                                        </p>
                                        <p>
                                            <span>
                                                <?php _e("Open date:", "enginethemes"); ?>
                                            </span>
                                            <?php echo date_i18n( get_option( 'date_format' ), strtotime( $case->post_date ) ); ?>
                                        </p>
                                        <p>
                                            <span>
                                                <?php _e("Listing:", "enginethemes"); ?>
                                            </span>
                                            <a href="<?php echo get_permalink( $item['ID'] ); ?>">
                                                <?php echo $item['title']; ?>
                                            </a>
                                        </p>
                                        <p>
                                            <span>
                                                <?php _e("Problem:", "enginethemes"); ?>
                                            </span>
                                            <?php echo me_rc_dispute_problem_text($case_id); ?>
                                        </p>
                                        <p>
                                            <span>
                                                <?php _e("You want to:", "enginethemes"); ?>
                                            </span>
                                            <?php echo me_rc_case_expected_solution_label($case_id); ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="me-col-md-6">
                                    <div class="me-disputed-order-info">
                                        <h3>
                                            <?php _e("Order information", "enginethemes"); ?>
                                        </h3>
                                        <p>
                                            <span>
                                                <?php _e("Order ID:", "enginethemes"); ?>
                                            </span>
                                            #<?php echo $transaction->ID; ?>
                                        </p>
                                        <p>
                                            <span>
                                                <?php _e("Total amount:", "enginethemes"); ?>
                                            </span>
                                            <?php echo me_price_format($transaction->get_total()); ?>
                                        </p>
                                        <p>
                                            <span>
                                                <?php _e("Order date:", "enginethemes"); ?>
                                            </span>
                                            <?php echo get_the_date(get_option('date_format'), $transaction->ID); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="me-disputed-action">
                            <div class="me-row">
                                <div class="me-col-md-6">
                                    <div class="me-disputed-close">
                                        <a href="#">
                                            Close dispute
                                        </a>
                                        <p>
                                            In case you totally agree with what the Seller offer, you can close this dispute. Once the dispute is closed, it cannot be re-opened.
                                        </p>
                                    </div>
                                </div>
                                <div class="me-col-md-6">
                                    <div class="me-disputed-escalate">
                                        <a href="#">
                                            Escalate
                                        </a>
                                        <p>
                                            In case you totally agree with what the Seller offer, you can close this dispute. Once the dispute is closed, it cannot be re-opened.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="me-disputed-conversation">
                        <div class="me-row">
                            <div class="me-col-md-3 me-col-md-pull-9 me-col-sm-4 me-col-sm-pull-8">
                                <div class="me-sidebar-contact">
                                    <div class="me-party-involve">
                                        <h3>Related Party</h3>
                                        <p>Seller:<span>Supper seller</span></p>
                                        <p>Buyer:<span>Supper seller buy</span></p>
                                    </div>
                                    <div class="me-dispute-event">
                                        <h3>Dispute Event</h3>
                                        <a href="#">
                                            <span>Escalate dispute</span>
                                            <span>03/01/2017</span>
                                        </a>
                                        <a href="#">
                                            <span>Close dispute request</span>
                                            <span>02/01/2017</span>
                                        </a>
                                        <a href="#">
                                            <span>Dispute started</span>
                                            <span>01/01/2017</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="me-col-md-9 me-col-md-push-3 me-col-sm-8 me-col-sm-push-4">
                                <div class="me-contact-messages-wrap">
                                    <div class="me-contact-message-user">
                                        <p>
                                            David Copperfield
                                        </p>
                                    </div>

                                    <?php 
                                        $message_query = new ME_Message_Query(array('post_type' => 'message', 'post_parent' => $case->ID, 'showposts' => 12));
                                        	$messages = array_reverse ($message_query->posts);
                                    ?>
                                    
                                    <div class="me-contact-messages">
                                        <ul class="me-contact-messages-list">
                                        <?php if( $messages ) : ?>
										<?php foreach ($messages  as $key => $message) : ?>
											<?php me_get_template('resolution/message-item', array('message' => $message)); ?>
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
