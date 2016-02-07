

 window.fbAsyncInit = function() {
    FB.init({
      appId      : '911280978986775',//put here FBappID
      xfbml      : true,
      version    : 'v2.5'
    });
  };

(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id))
        return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/cs_CZ/sdk.js#xfbml=1&version=v2.0";
    fjs.parentNode.insertBefore(js, fjs);

}(document, 'script', 'facebook-jssdk'));