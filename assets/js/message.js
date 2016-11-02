/* global me_globals.ajaxurl, wpAjax*/
/**
 * Created by agungbayu
 */

(function($) {

    $.fn.messageUploader = function(options)
    {
        var setting = {
            multi: false,
            runtimes : 'html5,flash,html4',
            multipart : true,
            name: 'file',
            max_file: 0,
            swf : null,
            extension: 'jpg,jpeg,gif,png',
            handler: '',
            upload_url: '',
            browse_button: 'me-message-send-btn',
            maxsize: "10mb",
            maxcount: 8,
            maxwidth: 0,
            maxheight: 0,
            removable : true
        };

        if (options) {
            options = $.extend(setting, options);
        } else {
            options = $.extend(setting);
        }

        return $(this).each(function(){

            var element = this;
            var action = options.multi ? "upload_multi_file" : "upload_single_file" ;
            var removable = options.removable ? '1' : '0';
            var preview = $(element).find('ul');
            var uploading = null;
            var uploader = null;

            var inquiry_id = options.inquiry_id;
            var listing_id = options.listing_id;

            var upload_begin = function(files){
                $.each(files, function(file){
                    var progress = "<li class='uploading'><div class='uploading-progress'></div></li>";
                    $(preview).append(progress);
                });
                uploader.start();
            };

            uploader = new plupload.Uploader({
                container: $(element).get(0),
                browse_button : options.browse_button,
                runtimes : options.runtimes,
                flash_swf_url : options.swf,
                file_data_name: options.name,
                multi_selection : false,
                url: options.upload_url + "&listing_id="+listing_id+"&inquiry_id="+inquiry_id+"&filename=" + options.name + "&action=" + action+"&removable=" + removable,
                filters:  {
                    mime_types : [
                        { title : "extensions", extensions : options.extension }
                    ],
                    max_file_size : options.maxsize
                } ,
                init: {
                    FilesAdded: function(up, files) {
                        var current = $(preview).find('li').size();
                        var totalfile = files.length + current;
                        if(options.multi) {
                            if(totalfile > options.maxcount) {
                                alert(me_globals.limitFile + options.maxcount);
                            } else {
                                upload_begin(files);
                            }
                        } else {
                            upload_begin(files);
                        }
                    },
                    UploadProgress: function(up, file) {
                        $(uploading).find('.uploading-progress').css({
                            'width' : file.percent + "%"
                        });
                    },
                    Error: function(up, err) {
                        alert("Error : " + err.message);
                        $(uploading).remove();
                    },
                    UploadFile: function(up, file){
                        uploading = $(preview).find('.uploading').last();
                    },
                    FileUploaded: function(up, file, response) {
                        $(uploading).replaceWith(response.response);
                    }
                }
            });

            uploader.init();

        });

    };

})(jQuery);


(function($) {
    $.fn.MEmessage = function(options) {
        var defaults = {
            type: 'inquiry',
            parent: 0,
            paged: 2,
            nonce: ''
        };
        var settings = $.extend({}, defaults, options);
        var full = false;
        return $(this).each(function(e) {
            var $elem = $(this);
            var $message_container = $elem.find('.me-contact-messages');
            var $load_more_button = $(this).find('.load-message-button');
            var $ul = $elem.find('ul');
            $elem.find('textarea').focus();
            // fetch message function
            var fetch_message = function() {
                    $.ajax({
                        url: me_globals.ajaxurl,
                        type: 'get',
                        data: {
                            action: 'get_messages',
                            type: settings.type,
                            parent: settings.parent,
                            paged: settings.paged,
                            _wpnonce: settings.nonce
                        },
                        beforeSend: function() {
                            settings.paged++;
                        },
                        success: function(res, xhr) {
                            if (res.data) {
                                $ul.prepend(res.data);
                                $message_container.scrollTop(600);
                            } else {
                                full = true;
                                $load_more_button.remove();
                            }
                        }
                    });
                }
                // click to load more message
            $load_more_button.click(function() {
                fetch_message();
            });
            // scroll to load older messages
            $message_container.scroll(function(e) {
                var pos = $message_container.scrollTop(),
                    h = $message_container.height();
                // check scroll and ajax get messsages
                if (pos == 0 && !full) {
                    fetch_message();
                }
            });
            // send message
            $elem.find('textarea').keydown(function(e) {
                // enter send message
                if (e.keyCode == '13' && !e.shiftKey) {
                    e.preventDefault();
                    $(this).parent('form').submit();
                }
            });
            // message form submit
            $elem.find('form').submit(function(e) {
                e.preventDefault();
                var $textarea = $(this).find('textarea'),
                    content = $textarea.val();
                // message content can not empty
                if (!content) return;
                // ajax send message
                $.ajax({
                    type: 'post',
                    url: me_globals.ajaxurl,
                    data: {
                        action: 'me_send_message',
                        type: settings.type,
                        inquiry_id: settings.parent,
                        content: content,
                        _wpnonce: settings.nonce
                    },
                    beforeSend: function() {
                        $textarea.val('');
                    },
                    success: function(response, xhr) {
                        if (response.success) {
                            $message_container.append(response.content);
                            $message_container.scrollTop($message_container[0].scrollHeight);
                        }
                    }
                });
            });
        });
    }
    /**
     * Inquiry contacts list
     */
    var contact_paged = 2;
    var loading = false;
    $('#contact-list').scroll(function() {
        var pos = $('#contact-list').scrollTop();
        var h = $('#contact-list').height();
        if (pos >= h && !loading) {
            $.ajax({
                url: me_globals.ajaxurl,
                type: 'get',
                data: {
                    action: 'get_contact_list',
                    listing: 466,
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