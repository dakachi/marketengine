(function($) {
    $(document).ready(function() {
        if (window.location.hash) {
            if ($(window.location.hash).length > 0) {
                var step = $(window.location.hash).attr('data-step');
                $('.me-setup-container').removeClass('active');
                $('.me-setup-line-step').removeClass('active');

                $(window.location.hash).addClass('active');
                for (var i = 0; i <= parseInt(step); i++) {
                    $('.me-setup-line-step').eq(i).addClass('active');
                };
            }
        }
        $('.wizard-start').on('click', function(event) {
            //event.preventDefault();
            var target = event.currentTarget;
            var parent_section = $(target).parents('.me-setup-section');
            var parent_container = $(target).parents('.me-setup-container');
            var data_step = parent_container.data('step');
            var data_next = data_step + 1;
            // activity
            parent_container.removeClass('active');
            $('.me-setup-container').eq(data_next).addClass('active');
            $('.me-setup-line-step').eq(data_next).addClass('active');
        });
        //=== Click continue button
        $('.me-next').on('click', function(event) {
            //event.preventDefault();
            var $target = $(event.currentTarget);
            var $parent_section = $target.parents('.me-setup-section');
            var $parent_container = $target.parents('.me-setup-container');
            var data_step = $parent_container.data('step');
            var data_next = data_step + 1;
            // activity
            $.ajax({
                type: 'post',
                url: me_globals.ajaxurl,
                data: {
                    action: 'me-do-setup',
                    _wpnonce: $('#_wpnonce').val(),
                    content: $parent_container.find('form').serialize()
                },
                beforeSend: function() {
                    $parent_section.addClass('me-setup-section-loading');
                },
                success: function(res, xhr) {
                    $parent_section.removeClass('me-setup-section-loading');
                    $parent_container.removeClass('active');
                    $('.me-setup-container').eq(data_next).addClass('active');
                    $('.me-setup-line-step').eq(data_next).addClass('active');
                }
            });
        });
        $('#me-add-sample-data').on('click', function(e) {
            $.ajax({
                type: 'post',
                url: me_globals.ajaxurl,
                data: {
                    action: 'me-add-sample-data',
                    _wpnonce: $('#_wpnonce').val()
                },
                beforeSend: function() {
                    $parent_section.addClass('me-setup-section-loading');
                },
                success: function(res, xhr) {
                    $parent_section.removeClass('me-setup-section-loading');
                }
            });
        });
        //=== Click skip button
        $('.me-skip-btn').on('click', function(event) {
            //event.preventDefault();
            var target = event.currentTarget;
            var parent_section = $(target).parents('.me-setup-section');
            var parent_container = $(target).parents('.me-setup-container');
            var data_step = parent_container.data('step');
            var data_next = data_step + 1;
            // activity
            parent_container.removeClass('active');
            $('.me-setup-container').eq(data_next).addClass('active');
            $('.me-setup-line-step').eq(data_next).addClass('active');
        });
        $('.me-setup-add-cat').on('click', function(event) {
            var parent_sfield = $(this).parent();
            $(parent_sfield).find('.more-cat').slideDown();
            $(this).hide();
        });
    });
})(jQuery);