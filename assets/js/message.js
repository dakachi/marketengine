/* global me_globals.ajaxurl, wpAjax*/
(function($) {
    $.fn.MEmessage = function(options) {
        var defaults = {
            type: 'inquiry',
            parent: 0,
            paged: 2,
            nonce: ''
        };
        var settings = $.extend({}, defaults, options);
        var full = false;
        return $(this).each(function(e) {
            var $elem = $(this);
            var $message_container = $elem.find('.me-contact-messages');
            var $load_more_button = $(this).find('.load-message-button');
            var $ul = $elem.find('ul');
            $elem.find('textarea').focus();
            // fetch message function
            var fetch_message = function() {
                    $.ajax({
                        url: me_globals.ajaxurl,
                        type: 'get',
                        data: {
                            action: 'get_messages',
                            type: settings.type,
                            parent: settings.parent,
                            paged: settings.paged,
                            _wpnonce: settings.nonce
                        },
                        beforeSend: function() {
                            settings.paged++;
                        },
                        success: function(res, xhr) {
                            if (res.data) {
                                $ul.prepend(res.data);
                                $message_container.scrollTop(600);
                            } else {
                                full = true;
                                $load_more_button.remove();
                            }
                        }
                    });
                }
                // click to load more message
            $load_more_button.click(function() {
                fetch_message();
            });
            // scroll to load older messages
            $message_container.scroll(function(e) {
                var pos = $message_container.scrollTop(),
                    h = $message_container.height();
                // check scroll and ajax get messsages
                if (pos == 0 && !full) {
                    fetch_message();
                }
            });
            // send message
            $elem.find('textarea').keydown(function(e) {
                // enter send message
                if (e.keyCode == '13' && !e.shiftKey) {
                    e.preventDefault();
                    $(this).parent('form').submit();
                }
            });
            // message form submit
            $elem.find('form').submit(function(e) {
                e.preventDefault();
                var $textarea = $(this).find('textarea'),
                    content = $textarea.val();
                // message content can not empty
                if (!content) return;
                // ajax send message
                $.ajax({
                    type: 'post',
                    url: me_globals.ajaxurl,
                    data: {
                        action: 'me_send_message',
                        type: settings.type,
                        inquiry_id: settings.parent,
                        content: content,
                        _wpnonce: settings.nonce
                    },
                    beforeSend: function() {
                        $textarea.val('');
                    },
                    success: function(response, xhr) {
                        if (response.success) {
                            $message_container.append(response.content);
                            $message_container.scrollTop($message_container[0].scrollHeight);
                        }
                    }
                });
            });
        });
    }
    var contact_paged = 2;
    var loading = false;
    $('#contact-list').scroll(function() {
        var pos = $('#contact-list').scrollTop();
        var h = $('#contact-list').height();
        if (pos >= h && !loading) {
            $.ajax({
                url: me_globals.ajaxurl,
                type: 'get',
                data: {
                    action: 'get_contact_list',
                    listing: 466,
                    paged: contact_paged,
                    _wpnonce: $('#_wpnonce').val()
                },
                beforeSend: function() {
                    contact_paged++;
                    loading = true
                },
                success: function(res, xhr) {
                    loading = false;
                    if (res.data) {
                        $('#contact-list').append(res.data);
                    }
                }
            });
        }
    });
})(jQuery);