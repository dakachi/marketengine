(function($) {
    $(document).ready(function() {
        //=== Click continue button
        $('.me-scontinue-btn').on('click', function(event) {
            event.preventDefault();
            var target = event.currentTarget;
            var parent_section = $(target).parents('.me-setup-section');
            var parent_container = $(target).parents('.me-setup-container');
            var data_step = $(parent_container).data('step');
            var data_next = data_step + 1;
            // activity
            $(parent_section).addClass('me-setup-section-loading');
            setTimeout(function() {
                $(parent_section).removeClass('me-setup-section-loading');
                $(parent_container).removeClass('active');
                $('.me-setup-container').eq(data_next).addClass('active');
                $('.me-setup-line-step').eq(data_next).addClass('active');
            }, 100);
        });
        //=== Click previous button
        $('.me-sprevious-btn').on('click', function(event) {
            event.preventDefault();
            var target = event.currentTarget;
            var parent_container = $(target).parents('.me-setup-container');
            var data_step = $(parent_container).data('step');
            var data_prev = data_step - 1;
            //activity
            $(parent_container).removeClass('active');
            $('.me-setup-container').eq(data_prev).addClass('active');
            $('.me-setup-line-step').eq(data_step).removeClass('active');
        });
        $('.me-setup-add-cat').on('click', function(event) {
            var parent_sfield = $(this).parent();
            $(parent_sfield).append('<input type="text" /> <input type="text" /><small>More categories can be added later in MarketEngine settings</small>')
            $(this).hide();
        });
    });
})(jQuery);