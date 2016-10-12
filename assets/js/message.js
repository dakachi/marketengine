/* global me_globals.ajaxurl, wpAjax*/
(function($) {
    var paged = 2;
    $('#messages-container').scroll(function() {
        var pos = $('#messages-container').scrollTop();
        var h = $('#messages-container').height();
        if (pos == 0) {
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
                    }
                }
            });
        }
    });

    // search buyer

    // scroll buyer list

})(jQuery);