<?php
class Tests_ME_Message_Query extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
    }

    public function setUp() {
        $this->user_1 = self::factory()->user->create(array('role' => 'author', 'first_name' => 'Orime', 'last_name' => 'Dakachi'));
        $this->user_2 = self::factory()->user->create(array('role' => 'author', 'first_name' => 'Bui Nguyen', 'last_name' => 'Loi Dinh'));
        $this->user_3 = self::factory()->user->create(array('role' => 'author', 'first_name' => 'Do Huynh', 'last_name' => 'Anh Em'));
        wp_set_current_user($this->user_1);
        $defaults = array(
            'sender'                => $this->user_1,
            'receiver'              => $this->user_2,
            'post_content'          => 'Message Content',
            'post_content_filtered' => '',
            'post_title'            => 'Message Title',
            'post_excerpt'          => 'Message Excerpt',
            'post_status'           => 'sent',
            'post_type'             => 'inquiry',
            'post_password'         => '',
            'post_parent'           => 0,
            'guid'                  => '',
        );
        $this->message_data = $defaults;
    }

    public function test_me_query_message_by_receiver_name() {
        $message_data = $this->message_data;

        $message_data['receiver'] = $this->user_2;
        me_insert_message($message_data);
        $message_data['receiver'] = $this->user_3;
        me_insert_message($message_data);

        $message_query = new ME_Message_Query(array('receiver_name' => 'Bui'));

    }

    public function test_me_get_message(){
        $message = me_get_message(0);
        $this->assertEquals(new WP_Error('invalid_message', 'Invalid message.'), $message);
    }
}