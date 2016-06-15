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
            $('#me-sub-cat-container').html(r.data);
        });
    });
    $('.select-category').on('change', function() {
        var cat = $(this).val();
        $.get(me_globals.ajaxurl, {
            'action': 'me-load-listing-type',
            'parent-cat': cat
        }, function(r, stat) {
            if (0 === r || 'success' != stat) {
                return;
            }
            $('#listing-type-container').html(r.data);
        });
    });
    $('#listing-type-select').on('change', function() {
        var cat = $(this).val();
        $.get(me_globals.ajaxurl, {
            'action': 'me-load-listing-type',
            'parent-cat': cat
        }, function(r, stat) {
            if (0 === r || 'success' != stat) {
                return;
            }
            $('#listing-type-container').html(r.data);
        });
    });

    var plupload_config = {
        // General settings
        runtimes: 'html5,flash,silverlight,html4',
        // Maximum file size
        max_file_size: '2mb',
        chunk_size: '1mb',
        // Resize images on clientside if we can
        resize: {
            width: 200,
            height: 200,
            quality: 90,
            crop: true // crop to exact dimensions
        },
        // Specify what files to browse for
        filters: [{
            title: "Image files",
            extensions: "jpg,gif,png"
        }],
        // Rename files by clicking on their titles
        rename: true,
        // Sort files
        sortable: true,
        // Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
        dragdrop: true,
        // Views to activate
        views: {
            list: true,
            thumbs: true, // Show thumbs
            active: 'thumbs'
        }, 
        browse_button : "uploader"
    }
    $.extend(true, plupload_config, plupload_opt);
    console.log(plupload_config);
    // Initialize the widget when the DOM is ready
    var uploader = new plupload.Uploader(plupload_config);
    uploader.init();

    window.tagBox.init();
    // process tag input
})(jQuery);