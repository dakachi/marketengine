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
                <div class="me-disputed-case">
                    <div class="me-disputed-info">
                        <div class="me-disputed-product-order">
                            <div class="me-row">
                                <div class="me-col-md-6">
                                    <div class="me-disputed-product-info">
                                        <h3>
                                            <?php _e("Product infomation", "enginethemes"); ?>
                                        </h3>
                                        <a href="<?php echo get_permalink( $item['ID'] ); ?>">
                                            <?php echo get_the_post_thumbnail($item['ID']) ?>
                                        </a>
                                        <div class="me-disputed-product">
                                            <h2>
                                                <a href="<?php echo get_permalink( $item['ID'] ); ?>">
                                                    <?php echo $item['title']; ?>
                                                </a>
                                            </h2>
                                            <p>
                                                <span>
                                                    <?php _e("Unit price:", "enginethemes"); ?>
                                                </span>
                                                <?php echo me_price_format($item['price']); ?>
                                            </p>
                                            <p>
                                                <span>
                                                    <?php _e("Quantity:", "enginethemes"); ?>
                                                </span>
                                                <?php echo $item['qty']; ?>
                                            </p>
                                            <p>
                                                <span>
                                                    <?php _e("Total amount:", "enginethemes"); ?>
                                                </span>
                                                <?php echo me_price_format($transaction->get_total()); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="me-col-md-6">
                                    <div class="me-disputed-order-info">
                                        <h3>
                                            <?php _e("Case information", "enginethemes"); ?>
                                        </h3>
                                        <p>
                                            <span>
                                                <?php _e("Order ID:", "enginethemes"); ?>
                                            </span>
                                            #<?php echo $transaction->ID; ?>
                                        </p>
                                        <p>
                                            <span>
                                                <?php _e("Case status:", "enginethemes"); ?>
                                            </span>
                                            <?php echo me_dispute_status_label($case->post_status); ?>
                                        </p>
                                        <p>
                                            <span>
                                                <?php _e("Case amount:", "enginethemes"); ?>
                                            </span>
                                            <?php echo me_price_format($transaction->get_total()); ?>
                                        </p>
                                        <p>
                                            <span>
                                                <?php _e("Your problem:", "enginethemes"); ?>
                                            </span>
                                            <?php echo me_rc_dispute_problem_text($case_id); ?>
                                        </p>
                                        <p>
                                            <span>
                                                You want to:
                                            </span>
                                            <?php echo me_rc_case_expected_solution_label($case_id); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="me-disputed-action">
                            <h3>
                                Action
                            </h3>
                            <div class="me-row">
                                <div class="me-col-md-6">
                                    <div class="me-disputed-close">
                                        <h4>
                                            <a href="#">
                                                Close dispute
                                            </a>
                                        </h4>
                                        <p>
                                            In case you totally agree with what the Seller offer, you can close this dispute. Once the dispute is closed, it cannot be re-opened.
                                        </p>
                                    </div>
                                </div>
                                <div class="me-col-md-6">
                                    <div class="me-disputed-escalate">
                                        <h4>
                                            <a href="#">
                                                Escalate
                                            </a>
                                        </h4>
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
                                    <div class="me-authors">
                                        <span class="me-avatar">
                                            <img alt="" src="http://0.gravatar.com/avatar/c655f931959fd28e3594563edd348833?s=60&d=mm&r=G">
                                                <b>
                                                    author listing
                                                </b>
                                            </img>
                                        </span>
                                        <ul class="me-author-info">
                                            <li>
                                                <span class="pull-left">
                                                    From:
                                                </span>
                                                <b class="pull-right">
                                                    Banglades
                                                </b>
                                            </li>
                                            <li>
                                                <span class="pull-left">
                                                    Language:
                                                </span>
                                                <b class="pull-right">
                                                    Vietnam
                                                </b>
                                            </li>
                                            <li>
                                                <span class="pull-left">
                                                    Member Sinced:
                                                </span>
                                                <b class="pull-right">
                                                    30 NOV, 2017
                                                </b>
                                            </li>
                                        </ul>
                                        <a class="me-view-profile" href="">
                                            View profile
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="me-col-md-9 me-col-md-push-3 me-col-sm-8 me-col-sm-push-4">
                                <div class="me-contact-messages-wrap">
                                    <div class="me-contact-message-user">
                                        <h2>
                                            David Copperfield
                                        </h2>
                                    </div>
                                    <div class="me-contact-header">
                                        <a href="#">
                                            DISPUTED CASE
                                        </a>
                                        <ul class="me-contact-tabs">
                                            <li class="me-disputed-case-tabs">
                                                <span>
                                                    Case Info
                                                </span>
                                            </li>
                                            <li class="me-disputed-action-tabs">
                                                <span>
                                                    Action Info
                                                </span>
                                            </li>
                                        </ul>
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
                                    <div class="me-message-typing">
                                        <input placeholder="New message" type="text">
                                            <span class="me-message-send-btn">
                                                <i class="icon-me-attach">
                                                </i>
                                            </span>
                                        </input>
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
