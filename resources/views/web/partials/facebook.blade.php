<div id="fb-root"></div>
<script>
  $(document).ready(function () {
    function getUserData() {
      FB.api('/me', {fields: 'id, first_name, last_name, email, gender, verified'}, function (authUser) {
        FB.api('/' + authUser.id + '/picture?height=300', function (image) {
          $.post('/ajax/oauth/facebook', {
            user: authUser,
            image: image
          }, function (response) {
            if (response.success === true) {
              window.location.href = response['url'];
            } else {
              alert(response.message)
            }
          });
        });
      });
    }
  
    function loginUser() {
      FB.login(function (respuesta) {
        if (respuesta.status === 'connected') {
          getUserData();
        }
      }, {scope: 'public_profile,email,user_friends'});
    }
  
    window.fbAsyncInit = function () {
      FB.init({
        appId: '{{ env('FACEBOOK_APP_API') }}',
        xfbml: true,
        version: 'v2.10',
        cookie: true
      });
      //FB.AppEvents.logPageView();
    };
  
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "https://connect.facebook.net/es_ES/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  });


  $(document).on('click', '#authFacebook', function () {
    loginUser();
  });
</script>