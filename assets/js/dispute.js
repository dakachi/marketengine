jQuery(document).ready(function($) {
    $('#dispute-file').jUploader({
        browse_button: 'me-dipute-upload',
        multi: true,
        name: 'dispute_file',
        extension: 'jpg,jpeg,gif,png',
        upload_url: me_globals.ajaxurl + '?nonce=' + $('#me-dispute-file').val(),
        maxsize: '2mb',
        maxcount: 5,
    });
    /*submit dispute message form*/
    $('#dispute-message-form').submit(function(e) {
        e.preventDefault();
        var content = $('#debate_content').val();
        if (!content) {
            $('#debate_content').focus();
            return false;
        }
        if ($('.upload-container').hasClass('uploading')) {
            return false;
        }
        /* ajax send debate message in dispute details */
        $.post({
            url: me_globals.ajaxurl,
            data: $(this).serialize() + '&action=me-dispute-debate',
            beforeSend: function() {
                // loading
            },
            success: function(res) {
                // remove loading
                if (res.success) {
                    $('.me-contact-messages-list').append(res.html);
                    $('#debate_content').val('');
                    $('.upload_preview_container ul').html('');
                }
            }
        });
    });
});