window.ME = window.ME || {};
(function(ME, $, Backbone) {
    ME.Models = ME.Models || {};
    ME.Collections = ME.Collections || {};
    ME.Views = ME.Views || {};
    ME.Routers = ME.Routers || {};
    // the pub/sub object for managing event throughout the app
    ME.pubsub = ME.pubsub || {};
    _.extend(ME.pubsub, Backbone.Events);
    ME.globals = me_globals;
    /**
     * override backbone sync function
     */
    Backbone.Model.prototype.sync = function(method, model, options) {
        var data = model.attributes;
        data.action = model.action || 'me-sync';
        switch (method) {
            case 'create':
                data.method = 'create';
                break;
            case 'update':
                data.method = 'update';
                break;
            case 'delete':
                data.method = 'remove';
                break;
            case 'read':
                data.method = 'read';
                break;
        }
        var ajaxParams = {
            type: 'POST',
            dataType: 'json',
            data: data,
            url: me_globals.ajaxurl,
            contentType: 'application/x-www-form-urlencoded;charset=UTF-8'
        };
        ajaxParams = _.extend(ajaxParams, options);

        if (options.beforeSend !== 'undefined') ajaxParams.beforeSend = options.beforeSend;
        ajaxParams.success = function(result, status, jqXHR) {
            ME.pubsub.trigger('me:success', result, status, jqXHR);
            options.success(result, status, jqXHR);
        };
        ajaxParams.error = function(jqXHR, status, errorThrown) {
            ME.pubsub.trigger('me:error', jqXHR, status, errorThrown);
            options.error(jqXHR, status, errorThrown);
        };
        $.ajax(ajaxParams);
    };
    /**
     * override backbone collection sync
     */
    Backbone.Collection.prototype.sync = function(method, collection, options) {
        var ajaxParams = {
            type: 'POST',
            dataType: 'json',
            data: {},
            url: me_globals.ajaxurl,
            contentType: 'application/x-www-form-urlencoded;charset=UTF-8'
        };
        ajaxParams.data = _.extend(ajaxParams.data, options.data);
        if (typeof collection.action !== 'undefined') {
            ajaxParams.data.action = collection.action;
        }
        /**
         * add beforsend function
         */
        if (options.beforeSend !== 'undefined') ajaxParams.beforeSend = options.beforeSend;
        /**
         * success function
         */
        ajaxParams.success = function(result, status, jqXHR) {
            ME.pubsub.trigger('me:success', result, status, jqXHR);
            options.success(result, status, jqXHR);
        };
        ajaxParams.error = function(jqXHR, status, errorThrown) {
            ME.pubsub.trigger('me:error', jqXHR, status, errorThrown);
            options.error(jqXHR, status, errorThrown);
        };
        $.ajax(ajaxParams);
    };
    /**
     * override backbone model parse function
     */
    Backbone.Model.prototype.parse = function(result) {
        if (_.isObject(result.data)) {
            return result.data;
        } else {
            return result;
        }
    };
    /**
     * override backbone model parse function
     */
    Backbone.Collection.prototype.parse = function(result) {
        if (_.isObject(result) && _.isObject(result.data)) {
            return result.data;
        } else {
            return [];
        }
    };
    // create a shorthand for our pubsub
})(window.ME, jQuery, Backbone);

// override underscore template tag
_.templateSettings = {
    evaluate: /\<\#(.+?)\#\>/g,
    interpolate: /\{\{=(.+?)\}\}/g,
    escape: /\{\{-(.+?)\}\}/g
};
(function(Collections, Models, Views, $, Backbone) {
    Models.Options = Backbone.Model.extend({
        action: 'me-option-sync',
        defaults: function() {
            return {
                name: "option_name",
                value: "option_value"
            };
        }
    });
    Views.Options = Backbone.View.extend({
        events: {
            'change input.me-input-field': 'textChange',
            'change textarea.me-textarea-field': 'textChange',
            'change input[type=checkbox]': 'toggleSwitch',
            'click input.me-radio-field': 'checkRadio',
            'change select.select-field': 'changeSelect',
            'click input#ep-button': 'syncEndpoint',
        },
        initialize: function() {
            var view = this;
            this.option = this.model;
        },
        // text input, textarea change update option
        textChange: function(e) {
            var $target = $(e.currentTarget),
                // form = $target.parents('form'),
                view = this;
            view.option.set('name', $target.attr('name'));
            view.option.set('value', $target.val());
            view.option.save('', '', {
                success: function(result, status, jqXHR) {
                    if (status.success) {
                        // do something
                    } else {
                        if(typeof status.msg != 'undefined'){
                            alert(status.msg);
                        }
                    }
                },
            });
        },
        toggleSwitch: function(e) {
            var $target = $(e.currentTarget),
                // form = $target.parents('form'),
                view = this;
            view.option.set('name', $target.attr('name'));
            view.option.set('value', $target.attr('checked'));
            view.option.save('', '', {
                success: function(result, status, jqXHR) {
                    if (status.success) {
                        // do something
                    } else {
                        if(typeof status.msg != 'undefined'){
                            alert(status.msg);
                        }
                    }
                },
            });
        },
        checkRadio: function(e){
            var $target = $(e.currentTarget),
                // form = $target.parents('form'),
                view = this;
            view.option.set('name', $target.attr('name'));
            view.option.set('value', $target.val());
            view.option.save('', '', {
                success: function(result, status, jqXHR) {
                    if (status.success) {
                        // do something
                    } else {
                        if(typeof status.msg != 'undefined'){
                            alert(status.msg);
                        }
                    }
                },
            });
        },
        changeSelect: function (e) {
            var $target = $(e.currentTarget),
                // form = $target.parents('form'),
                view = this;
            view.option.set('name', $target.attr('name'));
            view.option.set('value', $target.val());
            view.option.save('', '', {
                success: function(result, status, jqXHR) {
                    if (status.success) {
                        // render selected language
                    } else {
                        if(typeof status.msg != 'undefined'){
                            alert(status.msg);
                        }
                    }
                },
            });
        },
        syncEndpoint: function(e) {
            e.preventDefault();
            this.model.action = 'me-endpoint-sync';
            this.model.save('', '', {
                success: function(result, status, jqXHR) {
                    if (status.success) {
                        window.location.reload();
                    } else {
                        if(typeof status.msg != 'undefined'){
                            alert(status.msg);
                        }
                    }
                },
            });
        },
    });

    Models.Page_Setting = Models.Options.extend({
        action: 'me-get-page',
    });
    Views.Page_Setting = Backbone.View.extend({
        initialize: function() {
            this.model.action = 'me-edit-page';
            this.user_acount_page_id = $('select[name=me_user_account_page_id]').val();
        },
        events: {
            'click input#ep-button': 'setPage',
            'change select': 'selectPage',
        },
        selectPage: function(e) {
            var $target = $(e.currentTarget);
            this.user_acount_page_id = $target.val();
        },
        setPage: function(e) {
            e.preventDefault();
            var fields = this.$el.find('input[type=text], select'),
                view  = this,
                group = {};

            if(fields.length > 0){
                $.each(fields, function(i, v){
                    var $v = $(v);
                    group[$v.attr('name')] = $v.val();
                })
                this.model.set('group', group);
            }
            this.model.set('page_id', this.user_acount_page_id);
            this.model.save('', '', {
                success: function(result, status, jqXHR) {
                    if (status.success) {
                        window.location.reload();
                    } else {
                        if(typeof status.msg != 'undefined'){
                            alert(status.msg);
                        }
                        console.log(status.error);
                    }
                },
            });
        }
    });

    Views.Listings_Setting = Backbone.View.extend({
        initialize: function() {
            this.model.action = 'me-edit-page';
            this.post_listings_page_id = $('select[name=me_post_listing_page_id]').val();
            this.listings_page_id = $('select[name=me_listings_page_id]').val();
        },
        events: {
            'click input#ep-button': 'setPage',
            'change select': 'selectPage',
        },
        selectPage: function(e) {
            var $target = $(e.currentTarget);
            var select_ele = ($target.attr('name'));
            switch(select_ele){
                case 'me_post_listing_page_id':
                    this.post_listings_page_id = $target.children('option:selected').val()
                    break;
                case 'me_listings_page_id':
                    this.listings_page_id = $target.children('option:selected').val()
                    break;
            }
        },
        setPage: function(e) {
            e.preventDefault();
            var fields = this.$el.find('input[type=text], select'),
                view  = this,
                group = {};
                console.log(this.model);
            if(fields.length > 0){
                $.each(fields, function(i, v){
                    var $v = $(v);
                    group[$v.attr('name')] = $v.val();
                })
                this.model.set('group', group);
            }
            this.model.set('page_id_' + this.listings_page_id, '[me_listings]');
            this.model.set('page_id_' + this.post_listings_page_id, '[me_post_listing_form]');
            this.model.save('', '', {
                success: function(result, status, jqXHR) {
                    if (status.success) {
                        window.location.reload();
                    } else {
                        if(typeof status.msg != 'undefined'){
                            alert(status.msg);
                        }
                        console.log(status.error);
                    }
                },
            });
        }
    });

    $(document).ready(function() {
        var option_model = new Models.Options();
        if($('#em-setting-tab').length > 0){
            var option_view = new Views.Options({
                el: '#em-setting-tab',
                model: option_model,
            });
        }
        if($('#authenticate-settings').length > 0){
            var auth_view = new Views.Page_Setting({
                el: '#authenticate-settings',
                model: new Models.Page_Setting({
                    content: '[me_user_account]'
                }),
            });
        }
        if($('#listings-settings').length > 0){
            var listings_view = new Views.Listings_Setting({
                el: '#listings-settings',
                model: new Models.Page_Setting(),
            });
        }
    });


})(window.ME.Collections, window.ME.Models, window.ME.Views, jQuery, Backbone);