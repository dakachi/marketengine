/**
 * Created by agungbayu
 */

(function($) {

    $.fn.jUploader = function(options)
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
            browse_button: 'btn-upload',
            maxsize: "10mb",
            maxcount: 8,
            maxwidth: 0,
            maxheight: 0
        };

        if (options) {
            options = $.extend(setting, options);
        } else {
            options = $.extend(setting);
        }

        return $(this).each(function(){

            var element = this;
            var action = options.multi ? "upload_multi_file" : "upload_single_file" ;
            var preview = $(element).find('.upload_preview_container ul');
            var uploading = null;
            var uploader = null;

            var upload_begin = function(files){
                $.each(files, function(file){
                    var progress = "<li class='uploading'><div class='uploading-progress'></div></li>";
                    $(preview).prepend(progress);
                });
                uploader.start();
            };

            uploader = new plupload.Uploader({
                container: $(element).get(0),
                browse_button : options.browse_button,
                runtimes : options.runtimes,
                flash_swf_url : options.swf,
                file_data_name: options.name,
                multi_selection : options.multi,
                url: options.upload_url + "&filename=" + options.name + "&action=" + action,
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
                        $(preview).sortable('destroy');
                        if(options.multi) {
                            $(uploading).replaceWith(response.response);
                        } else {
                            $(preview).html(response.response);
                        }
                        $(preview).sortable();
                    }
                }
            });

            uploader.init();

            $(this).find(".upload_preview_container").on('click', '.remove', function(){
                var parent = $(this).parents('li.me-item-img');
                $(parent).fadeOut(function(){
                    $(this).remove();
                });
            });

            $(element).find('.upload_preview_container ul').sortable();
        });

    };

})(jQuery);