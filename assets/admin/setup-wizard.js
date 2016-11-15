(function($) {
    $(document).ready(function() {
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
                    action : 'me-do-setup',
                    _wpnonce: $('#_wpnonce').val(),
                    step: $parent_container.find('input[name="step"]').val()
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