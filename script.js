jQuery.ajaxSetup({cache: true});

window.PluginSocial = new (function () {
    "use strict";
    let $ = jQuery;

    this.inicialized = false;

    const parseFBAbstract = ($button) => {
        if ($button.is(':disabled')) {
            $button.prop('disabled', false);
            $button.click(() => {
                FB.ui($button.data());
            });
        }
    };
    const parseFBShare = () => {
        $('.plugin-social.fb.share').each(function () {
            parseFBAbstract($(this));
        });
    };

    const parseFBSend = () => {
        $('.plugin-social.fb.send').each(function () {
            parseFBAbstract($(this));
        });
    };

    const parseFB = () => {
        parseFBShare();
        parseFBSend();
        FB.XFBML.parse();
    };

    this.parse = () => {
        if (!this.inicialized) {
            return;
        }
        parseFB();
    };

    jQuery.getScript('//connect.facebook.net/cs_CZ/sdk.js', () => {
        FB.init({
            status: true,
            appId: '180514955816293',
            xfbml: true,
            version: 'v2.7'
        });
        this.inicialized = true;
        this.parse();
    });

})();

