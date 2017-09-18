/* global FB, JSINFO */
jQuery.ajaxSetup({cache: true});

window.PluginSocial = new (function () {
    "use strict";
    this.inicialized = false;

    const parseFBAbstract = (element) => {
        if (element.disabled) {
            element.disabled = false;
            element.addEventListener("click", () => {
                FB.ui({...element.dataset});
            });
        }
    };
    const parseFBShare = () => {
        document.querySelectorAll('.plugin-social.fb.share').forEach((element) => {
            parseFBAbstract(element);
        });
    };

    const parseFBSend = () => {
        document.querySelectorAll('.plugin-social.fb.send').forEach((element) => {
            parseFBAbstract(element);
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
            appId: JSINFO.FBAppID,
            xfbml: true,
            version: 'v2.7'
        });
        this.inicialized = true;
        this.parse();
    });

})();

