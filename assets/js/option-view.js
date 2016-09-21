/**
 * backend models Options
 */
(function(Models, Views, $, Backbone) {
    /**
     * model option
     */
    Models.Options = Backbone.Model.extend({
        action: 'ae-option-sync',
        defaults: function() {
            return {
                name: "option_name",
                value: "option_value"
            };
        }
    });

    Views.Options = Backbone.View.extend({
        events: {
            'change input.regular-text': 'textChange',
            'change input.regular-check': 'textChange',
            'change select.regular-select': 'textChange',
            'change textarea.regular-text': 'textChange',
            //'click .inner-menu li a': 'changeMenu',
            'focusout  textarea.regular-editor': 'editorChange',
            'click div.field-desc .btn-template-help': 'toggleDesc',
            'click a.reset-default': 'resetOption',
            'keypress input ': 'preventSubmit',
            'click .toggle-desc': 'toogleContent'
            // 'click .switch a'				: 'switch'
        },
        initialize: function() {
            var view = this;
            this.switchopt = [];
            this.imageSelectOpt = [];

            this.$el.find('.image-select-option').each(function(index, element) {
                var el = view.$('.image-select-option:eq(' + index + ')');
                view.imageSelectOpt[index] = new Views.imageSelectOption({
                    el: el
                });
            });

            this.$el.find('.switch').each(function(index, element) {
                var el = view.$('.switch:eq(' + index + ')');
                view.switchopt[index] = new Views.switchOption({
                    el: el
                });
            });

            this.$el.find('.editor').each(function() {
                if (typeof tinymce !== 'undefined') {
                    tinymce.EditorManager.execCommand('mceAddEditor', true, $(this).attr('id'));
                }
            });
            this.option = this.model;
            this.blockUi = new Views.BlockUi();
            this.uploaders = [];
            cbBeforeSend = function(ele) {
                button = $(ele).find('.image');
                view.blockUi.block(button);
            },
            cbSuccess = function() {
                view.blockUi.unblock();
            };
            var uploaders = [];
            $('.upload-logo').each(function() {
                var upload_id = $(this).attr('data-id');
                uploaders.push(upload_id);
            });
            for (var i = uploaders.length - 1; i >= 0; i--) {
                var upload_id = uploaders[i];
                $container = view.$('#' + upload_id + '_container');
                view.uploaders[upload_id] = new Views.File_Uploader({
                    el: $container,
                    uploaderID: upload_id,
                    thumbsize: 'thumbnail',
                    multipart_params: {
                        _ajax_nonce: $container.find('.et_ajaxnonce').attr('id'),
                        data: upload_id,
                        imgType: upload_id
                    },
                    cbUploaded: function(up, file, res) {
                        if (res.success) {
                            $('#' + this.container).parents('.desc').find('.error').remove();
                        } else {
                            $('#' + this.container).parents('.desc').append('<div class="error">' + res.msg + '</div>');
                        }
                    },
                    beforeSend: cbBeforeSend,
                    success: cbSuccess
                });
            };
            view.$('.map-setting').each(function(index, element) {
                new Views.MapSetting({
                    el: element
                });
            });
            // setup router
            this.router = new SettingRouter();
            Backbone.history.start();
        },
        // text input, textarea change update option
        textChange: function(e) {
            var $target = $(e.currentTarget),
                form = $target.parents('form');
            if(!form.valid()) return;
            view = this;
            if (form.attr('data-name') !== 'undefined' && form.attr('data-name')) {
                view.option.set('name', form.attr('data-name'));
                view.option.set('group', 1);
                view.option.set('value', form.serialize());
            } else {
                view.option.set('name', $target.attr('name'));
                view.option.set('value', $target.val());
            }
            view.option.save('', '', {
                success: function(result, status, jqXHR) {
                    view.blockUi.unblock();
                    // check status and append tick success
                    if (status.success) {
                        $target.parent().append('<span class="icon form-icon" data-icon="3"></span>');
                        setTimeout(function() {
                            view.$('.form-icon').remove();
                        }, 2000);
                    } else {
                        $target.parent().append('<span class="icon form-icon" data-icon="!"></span>');
                        setTimeout(function() {
                            view.$('.form-icon').remove();
                        }, 2000);
                        if(typeof status.msg != 'undefined'){
                            alert(status.msg);
                        }
                    }
                },
                beforeSend: function() {
                    view.blockUi.block($target);
                }
            });
        },
        // update text in editor
        editorChange: _.debounce(function(e) {
            var $target = $(e.currentTarget),
                $container = $target.parents('.form-item'),
                form = $target.parents('form');
            view = this;console.log(form);
            if (form.attr('data-name') !== 'undefined' && form.attr('data-name')) {
                this.option.set('name', form.attr('data-name'));
                this.option.set('group', 1);
                this.option.set('value', form.serialize());
            } else {
                this.option.set('name', $target.attr('name'));
                this.option.set('value', $target.val());
            }
            this.option.save('', '', {
                success: function(result, status, jqXHR) {
                    view.blockUi.unblock();
                    // check status and append tick success
                    if (status.success) {
                        $target.parent().append('<span class="icon form-icon" data-icon="3"></span>');
                        setTimeout(function() {
                            view.$('.form-icon').remove();
                        }, 2000);
                    } else {
                        $target.parent().append('<span class="icon form-icon" data-icon="!"></span>');
                        setTimeout(function() {
                            view.$('.form-icon').remove();
                        }, 2000);
                    }
                },
                beforeSend: function() {
                    view.blockUi.block($container);
                }
            });
        }, 500),
        /**
         * toogle description file hidden content
         */
        toggleDesc: function(e) {
            e.preventDefault();
            $(e.currentTarget).parent().find('.cont-template-help').toggle();
        },
        /**
         * reset an option to default value
         */
        resetOption: function(e) {
            e.preventDefault();
            var view = this,
                $target = $(e.currentTarget),
                $textarea = $target.parents('.form-item').find('textarea'),
                mail_type = $textarea.attr('name'); 
            var $container = $target.parents('.form-item'),
                form = $target.parents('form');

            $.ajax({
                url: ae_globals.ajaxURL,
                type: 'post',
                data: {
                    option_name: mail_type,
                    action: 'ae-reset-option'
                },
                beforeSend: function(event) {},
                success: function(response) {
                    if (response && typeof response.msg !== 'undefined') {
                        $textarea.val(response.msg);
                        if ($textarea.hasClass('regular-editor')) {
                            var ed = tinymce.EditorManager.get($textarea.attr('id'));
                            ed.setContent(response.msg);
                        }
                    }
                }
            });
        },
        preventSubmit: function(event) {
            if (event.which == 13) {
                return false;
            }
        },
        toogleContent: function(event) {
            var $target = $(event.currentTarget),
                $form = $target.parents('form');
            $form.find('.toggle').toggle();
        },
        /**
         * change menu view
         */
        changeMenu: function(e) {
            e.preventDefault();
            var $target = $(e.currentTarget);
            this.$('.inner-content').hide();
            this.$('.inner-menu li a').removeClass('active');
            this.$($target.attr('href')).show();
            $target.addClass('active');
        }
    });

})(window.AE.Models, window.AE.Views, jQuery, Backbone);