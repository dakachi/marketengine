/* global me_globals.ajaxurl, wpAjax*/
(function($) {
    $('.parent-category').change(function(e) {
        var parent_cat = $(this).val();
        $.get(me_globals.ajaxurl, {
            'action': 'me-load-sub-category',
            'parent-cat': parent_cat
        }, function(r, stat) {
            if (0 === r || 'success' != stat) {
                return;
            }
            $('#me-sub-cat-container').html(r.data);
        });
    });
    // $('.select-category').on('change', function() {
    //     var cat = $(this).val();
    //     $.get(me_globals.ajaxurl, {
    //         'action': 'me-load-listing-type',
    //         'parent-cat': cat
    //     }, function(r, stat) {
    //         if (0 === r || 'success' != stat) {
    //             return;
    //         }
    //         $('#listing-type-container').html(r.data);
    //     });
    // });
    $('#listing-type-select').on('change', function() {
        var type = $(this).val();
        $('.listing-type-info').hide();
        $('#' + type + '-type-field').show();
    });
    $(".me-input-price").keydown(function(e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: Ctrl+C
            (e.keyCode == 67 && e.ctrlKey === true) ||
            // Allow: Ctrl+X
            (e.keyCode == 88 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    window.tagBox.init();
    // process tag input
})(jQuery);