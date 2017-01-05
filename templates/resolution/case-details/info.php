<?php
$transaction = me_get_order($case->post_parent);
$items = $transaction->get_listing_items();
$item = array_pop($items);
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
                        #<?php echo $transaction->ID; ?>
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

    <div class="me-disputed-action">
    <?php if(get_current_user_id() == $case->sender) : ?>
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
    <?php else : ?>
        <div class="me-row">
            <div class="me-col-md-6">
                <div class="me-disputed-close">
                    <a href="#">Request To Close</a>
                    <p>In case both the Buyer and you agree with the deal, you can request to finish the dispute.</p>
                </div>
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

</div>