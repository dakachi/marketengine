<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
/**
* ME_Seller
*
* User behavior manager
*
* @class       ME Seller
* @version     1.0
* @package     MarketEngine/Users
* @author      EngineThemesTeam
* @category    Class
*/
class ME_Seller extends ME_User {
	public function __construct($id) {
        $this->id = $id;
        $this->user_data = get_user_meta($id);
    }

}
