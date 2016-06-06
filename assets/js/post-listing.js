(function($) {
    // process upload file
    var ImageModel = Backbone.Model.extend({
        defaults :{

        },
        initialize : function() {

        }
    });
    var ImageList = Backbone.Collection.extend({

    });
    var ImageItemView = Backbone.View.extend({});
    var ImageGalleryView = Backbone.View.extend({});

    
    $('.parent-category').change(function(e) {
        $('.sub-category').find('option').remove();
    })
    // process tag input
})(jQuery);