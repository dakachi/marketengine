/* global me_globals.ajaxurl, wpAjax*/
(function($) {
    $('#messages-container').scroll(function() {
        var pos = $('#messages-container').scrollTop();
        var h = $('#messages-container').height();
        if (pos == 0) {
            $.ajax({
                url: me_globals.ajaxurl,
                type: 'get',
                data : {
                    action : 'get_messages',
                    type : 'inquiry',
                    parent : 62,
                    _wpnonce : $('#_wpnonce').val()
                },
                beforeSend: function() {},
                success: function(res, xhr) {
                    $('#messages-container').prepend(res.data);
                    $('#messages-container').scrollTop(600);
                }
            });
        }
    });
})(jQuery);