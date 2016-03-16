window.fbAsyncInit = function () {
    FB.init({
        status: true,
        appId: '911280978986775',
        xfbml: true,
        version: 'v2.5'
    });
};
(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {
        return;
    }
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/cs_CZ/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


jQuery(function () {
    var $ = jQuery;

    $('#pluginsocialform').find('input[name="og:image"]').each(function () {
        var $input = $(this);
        $(this).focus(function () {
     
            var $SM = $('.social_media_manager');
            $SM.slideDown();
            $('#mediamanager__page .select.mediafile').live("click",function () {
             
                $SM.slideUp();
                
                var name = $(this).attr('id');
                $input.val(name.substring(2));
                 
               
            });

        });

    });
});


