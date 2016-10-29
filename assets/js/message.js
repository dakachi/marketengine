/* global me_globals.ajaxurl, wpAjax*/
(function($) {

    $.fn.MEmessage = function(options) {
        var setting = {
            type : 'inquiry'
        };

        var file_limit = 0;

        if (options) {
            options = $.extend(setting, options);
        } else {
            options = $.extend(setting);
        }

        return $(this).each(function(){
            
        });
    }

    var paged = 2;
    var full = false;
    $('#messages-container').scroll(function() {
        var pos = $('#messages-container').scrollTop();
        var h = $('#messages-container').height();
        if (pos == 0 && !full) {
            $.ajax({
                url: me_globals.ajaxurl,
                type: 'get',
                data: {
                    action: 'get_messages',
                    type: 'inquiry',
                    parent: 62,
                    paged: paged,
                    _wpnonce: $('#_wpnonce').val()
                },
                beforeSend: function() {
                    paged++;
                },
                success: function(res, xhr) {
                    if (res.data) {
                        $('#messages-container').prepend(res.data);
                        $('#messages-container').scrollTop(600);
                    }else {
                        full = true;
                    }
                }
            });
        }
    });

    // search buyer

    // scroll buyer list
    var contact_paged = 2;
    var loading = false;
    $('#contact-list').scroll(function() {
        var pos = $('#contact-list').scrollTop();
        var h = $('#contact-list').height();
        if (pos >= h && !loading ) {
            console.log(pos + ' '  + h );
            $.ajax({
                url: me_globals.ajaxurl,
                type: 'get',
                data: {
                    action: 'get_contact_list',
                    listing : 466,
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