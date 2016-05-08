
jQuery.getScript('//connect.facebook.net/cs_CZ/sdk.js', function () {
    FB.init({
        status: true,
        appId: '911280978986775',
        xfbml: true,
        version: 'v2.5'
    });
});



jQuery(function () {
    var $ = jQuery;

    $('#pluginsocialform').find('input[name="og:image"]').each(function () {
        var $input = $(this);
        $(this).focus(function () {

            var $SM = $('.social_media_manager');
            $SM.slideDown();
            $('#mediamanager__page .select.mediafile').live("click", function () {

                $SM.slideUp();
                var name = $(this).attr('id');
                $input.val(name.substring(2));
            });
        });
    });
});
