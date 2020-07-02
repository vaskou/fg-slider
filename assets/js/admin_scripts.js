(function ($) {

    $(function () {
        let selected = $('#fg_slider_options_type option:selected').val();
        show_on(selected);

        $('#fg_slider_options_type').change(function () {
            let selected = $(this).children('option:selected').val();
            show_on(selected);
        });

        function show_on(selected) {
            $('.show-on').hide();
            $('.show-on-' + selected).show();
        }

    });

})(jQuery);