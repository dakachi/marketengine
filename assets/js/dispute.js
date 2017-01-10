jQuery(document).ready(function($) {
	$('.me-switch-tab-filter-1, .me-switch-tab-filter-2').on('click', function() {
		$('.me-resolution').toggleClass('me-rslt-filter');
	});

	$('.me-dispute-case-tabs').on('click', function() {
		$(this).toggleClass('active');
		$('body').toggleClass('me-dispute-case-tabs-active');
		return false;
	});
	
	$('.me-dispute-action-tabs').on('click', function() {
		$(this).toggleClass('active');
		$('body').toggleClass('me-dispute-action-tabs-active');
		return false;
	});

	$('.me-dispute-related-tabs').on('click', function() {
		$(this).toggleClass('active');
		$('body').toggleClass('me-dispute-related-tabs-active');
		return false;
	});

	$('.me-receive-item-field').on('change', function(event) {
		var get_refund_block_id = $(this).data('get-refund-block');
		$('#dispute-get-refund-yes').removeClass('active');
		$('#dispute-get-refund-no').removeClass('active');
		$(document.getElementById(get_refund_block_id)).addClass('active');
	});
	
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