/* global me_globals.ajaxurl, wpAjax*/
(function($) {
    // process upload file
    var ImageModel = Backbone.Model.extend({
        defaults: {},
        initialize: function() {}
    });
    var ImageList = Backbone.Collection.extend({});
    var ImageItemView = Backbone.View.extend({});
    var ImageGalleryView = Backbone.View.extend({});
    $('.parent-category').change(function(e) {
        var parent_cat = $(this).val();
        $.get(me_globals.ajaxurl, {
            'action': 'me-load-sub-category',
            'parent-cat': parent_cat
        }, function(r, stat) {
            if (0 === r || 'success' != stat) {
                return;
            }
            $('#me_child_cat_containcer').html(r.data);
        });
    });
    // process tag input
})(jQuery);