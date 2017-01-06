<?php
$transaction = me_get_order($case->post_parent);
$items = $transaction->get_listing_items();
$item = array_pop($items);
me_print_notices();
?>
<div class="me-disputed-info">
    <div class="me-disputed-product-order">
        <div class="me-row">
            <div class="me-col-md-6">
                <div class="me-disputed-order-info">
                    <h3>
                        <?php _e("Case infomation", "enginethemes");?>
                    </h3>
                    <p>
                        <span>
                            <?php _e("Case status:", "enginethemes");?>
                        </span>
                        <?php echo me_dispute_status_label($case->post_status); ?>
                    </p>
                    <p>
                        <span>
                            <?php _e("Open date:", "enginethemes");?>
                        </span>
                        <?php echo date_i18n(get_option('date_format'), strtotime($case->post_date)); ?>
                    </p>
                    <p>
                        <span>
                            <?php _e("Listing:", "enginethemes");?>
                        </span>
                        <a href="<?php echo get_permalink($item['ID']); ?>">
                            <?php echo $item['title']; ?>
                        </a>
                    </p>
                    <p>
                        <span>
                            <?php _e("Problem:", "enginethemes");?>
                        </span>
                        <?php echo me_rc_dispute_problem_text($case->ID); ?>
                    </p>
                    <p>
                        <span>
                            <?php _e("You want to:", "enginethemes");?>
                        </span>
                        <?php echo me_rc_case_expected_solution_label($case->ID); ?>
                    </p>
                </div>
            </div>
            <div class="me-col-md-6">
                <div class="me-disputed-order-info">
                    <h3>
                        <?php _e("Order information", "enginethemes");?>
                    </h3>
                    <p>
                        <span>
                            <?php _e("Order ID:", "enginethemes");?>
                        </span>
                        <a href="<?php echo $transaction->get_order_detail_url(); ?>">
                            #<?php echo $transaction->ID; ?>
                        </a>
                    </p>
                    <p>
                        <span>
                            <?php _e("Total amount:", "enginethemes");?>
                        </span>
                        <?php echo me_price_format($transaction->get_total()); ?>
                    </p>
                    <p>
                        <span>
                            <?php _e("Order date:", "enginethemes");?>
                        </span>
                        <?php echo get_the_date(get_option('date_format'), $transaction->ID); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php if('me-closed' !== $case->post_status ) : ?>
    <div class="me-disputed-action">
    <?php if(get_current_user_id() == $case->sender) : ?>
        <div class="me-row">
            <div class="me-col-md-6">
                <div class="me-disputed-close">
                    <a onclick="if(!confirm('<?php _e("Are you sure you want to close this dispute?", "enginethemes"); ?>')) return false;" 
                    href="<?php echo wp_nonce_url(add_query_arg(array('close' => $case->ID) ), 'me-close_dispute' ,'wpnonce' ) ?>">
                        <?php _e("Close dispute", "enginethemes"); ?>
                    </a>
                    <p>
                        <?php _e("In case you totally agree with what the Seller offer, you can close this dispute. Once the dispute is closed, it cannot be re-opened.", "enginethemes"); ?>
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
    <?php else : ?>
        <div class="me-row">
            <div class="me-col-md-6">
            <?php if($case->post_status == 'me-waiting') : ?>
                <div class="me-disputed-request-close">
                    <h4>Waiting for Buyer,s respond</h4>
                    <p>You have already sent request to close dispute to the Buyer. Whenever the Buyer accept your request, the dispute will be closed.</p>
                </div>
            <?php else : ?>
                <div class="me-disputed-close">
                    <a onclick="if(!confirm('<?php _e("Are you sure you want to remind buyer of closing this dispute??", "enginethemes"); ?>')) return false;" 
                    href="<?php echo wp_nonce_url(add_query_arg(array('request-close' => $case->ID) ), 'me-request_close_dispute' ,'wpnonce' ) ?>">
                        <?php _e("Request To Close", "enginethemes"); ?>
                    </a>
                    <p>In case both the Buyer and you agree with the deal, you can request to finish the dispute.</p>
                </div>
            <?php endif; ?>
            </div>
            <div class="me-col-md-6">
                <div class="me-disputed-escalate">
                    <a href="#">Escalate</a>
                    <p>In case you totally agree with what the Seller offer, you can close this dispute. Once the dispute is closed, it cannot be re-opened.</p>
                </div>
            </div>
        </div>
    <?php endif; ?>
    </div>
    <?php endif; ?>
</div>