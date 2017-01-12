<?php
/**
 * This is an email template send to buyer when seller escalate dispute
 *
 * You can modify the email by copy it to {your theme}/templates/resolution/email
 * @since 1.1
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

?>
Hi [display_name], 

Seller[seller_name]/Buyer [buyer_name] has escalated the dispute for his/her transactions [order details_link]. 
Please review it here and arbitrate the dispute based on the detailed information and materials involved in this transaction which are provided by both parties.

Regards, 
[blogname]