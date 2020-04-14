//admin JS
jQuery(document).ready(function ($) {
    // Tab
    $(".wptp-tab").on('click', function (e) {
        e.preventDefault();
        var ids = $(this).attr('id');
        $('.wptp-tab-content').hide();
        $(".wptp-tab").removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');
        $('#' + ids + '-content').show();
    });

    $('#proxy-wptp-tab-content input[type=radio][name=proxy_status]').unbind('change').change(function () {
        $('.proxy-status-wptp').hide();
        $('#proxy_' + this.value).show();
    });

    $("#start_command").emojioneArea();

});
