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
            url: me_globals.ajaxURL,
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
(function(Models, Views, $, Backbone) {
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
        },
        initialize: function() {
            var view = this;
            this.option = this.model;
        },
        // text input, textarea change update option
        textChange: function(e) {
            var $target = $(e.currentTarget),
                form = $target.parents('form'),
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
                form = $target.parents('form'),
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
                form = $target.parents('form'),
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
                form = $target.parents('form'),
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
    });

    $(document).ready(function() {
        var option_model = new Models.Options();
        var option_fiels = [
            '#haha',
            '#me-textarea',
            '#me-switch-default',
            '#me-switch-optional',
            '#me-radio',
            '#child-textbox',
            '#child-switch',
            '#child-radio',
            '#me-translate'
        ];
        for(var i = 0; i < option_fiels.length; i++){
            if($(option_fiels[i]).length > 0){
                var option_view = new Views.Options({
                    el: option_fiels[i],
                    model: option_model,
                });
            }
        }
    });

})(window.ME.Models, window.ME.Views, jQuery, Backbone);