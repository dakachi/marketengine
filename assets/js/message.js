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
            $elem.find('ul').scroll(function(e) {
                var $message_container = $(e.currentTarget),
                    pos = $message_container.scrollTop(),
                    h = $message_container.height();
                // check scroll and ajax get messsages
                if (pos == 0 && !full) {
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
                                $message_container.prepend(res.data);
                                $message_container.scrollTop(600);
                            } else {
                                full = true;
                            }
                        }
                    });
                }
            });
            
            $elem.find('textarea').on
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