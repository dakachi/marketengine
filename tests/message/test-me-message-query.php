<?php
class Tests_ME_Message_Query extends WP_UnitTestCase
{
    public function __construct($factory = null)
    {
        parent::__construct($factory);
    }

    public function setUp()
    {
        $this->user_1 = self::factory()->user->create(array('role' => 'author', 'first_name' => 'Orime', 'last_name' => 'Dakachi'));
        $this->user_2 = self::factory()->user->create(array('user_name' => 'bui_nguyen', 'role' => 'author', 'first_name' => 'Bui Nguyen', 'last_name' => 'Loi Dinh'));
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

        $this->msg_ids = array();
    }

    public function tearDown()
    {
        global $wpdb;
        $message_table = $wpdb->prefix . 'marketengine_message_item';
        remove_filter( 'query', array( $this, '_drop_temporary_tables' ) );
        /* these lines don't work for some reason */
        $wpdb->query('DELETE FROM ' . $message_table);
        add_filter( 'query', array( $this, '_drop_temporary_tables' ) );
        parent::tearDown();
    }

    public function test_me_query_message_by_receiver_name()
    {
        $message_data = $this->message_data;

        $message_data['receiver'] = $this->user_2;
        $this->msg_ids[] = me_insert_message($message_data);

        $message_data['receiver'] = $this->user_3;
        $this->msg_ids[] = me_insert_message($message_data);

        $message_query = new ME_Message_Query(array('post_type' => 'inquiry', 'receiver_name' => 'bui_nguyen'));

        $this->assertEquals(1, $message_query->found_posts);

    }

    public function test_me_get_message_null()
    {
        $message = me_get_message(0);
        $this->assertNull($message);
    }

    public function test_me_get_message()
    {
        $message_data             = $this->message_data;
        $message_data['receiver'] = $this->user_2;
        $message_id               = me_insert_message($message_data);

        $message = me_get_message($message_id);
        $this->assertInstanceOf(ME_Message::class, $message);
    }

}
