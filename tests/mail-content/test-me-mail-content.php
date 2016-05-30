<?php
class Tests_ME_Email_Content extends WP_UnitTestCase {
    // test confirm email content
    public function test_confirm_mail_content() {
        ob_start();
        me_get_template_part('emails/activation');
        $content = ob_get_clean();
        $this->assertEquals('<p>Hello [display_name],</p>
<p>You have successfully registered an account with [blogname].Here is your account information:</p>
<ol><li>Username: [user_login]</li><li>Email: [user_email]</li></ol>
<p>Please click the link below to confirm your email address.</p>
<p>[activate_email_link]</p>
<p>Thank you and welcome to [blogname].</p>', $content);
    }
}