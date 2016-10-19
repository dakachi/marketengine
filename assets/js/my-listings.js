jQuery(document).ready(function($){
	$('.me-item-action span').on('click', function(e){
		var form = $(this).parents('form'),
			_status = $(this).data('status'),
			_lising_id = form.children('#listing_id').val(),
			data = {
				action: 'me_update_listing_status',
				status: _status,
				listing_id: _lising_id,
				_wpnonce: form.children('#_wpnonce').val()
			};

		var _confirm = false;
		if( 'me-archived' == _status ) {
			_confirm = confirm("Are you sure?");
		}

		if( _confirm || 'me-archived' != _status ) {
				$.post( me_globals.ajaxurl, data, function(res){
				if(res.success) {
					window.location = res.redirect;
				}
			});
		}
	})
});