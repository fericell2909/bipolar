<style> 
  .grecaptcha-badge {
    bottom: -150px !important;
  }
</style>

<script src="https://www.google.com/recaptcha/api.js?render={{  config('recaptcha.api_site_key')}}"></script>
<script>
  function onClickContactForm(e) {
    e.preventDefault();
    if( document.getElementById('name').value == '' || document.getElementById('email').value == '' || document.getElementById('message').value == '' ) {
        console.log('error validation')
    } else {
      grecaptcha.ready(function() {
        grecaptcha.execute('{{  config('recaptcha.api_site_key')}}', {action: 'contactsubmit'}).then(function(token) {
          if (token) {
            document .getElementById ('recaptcha').value = token;
            document.getElementById('contact-form').submit();
          }
        });
      });
    }
  }
  function onClickNewsLetterForm(e){
    e.preventDefault();
    if( document.getElementById('name').value == '' || document.getElementById('email').value == '' ) {
        console.log('error validation')
    } else {
      grecaptcha.ready(function() {
        grecaptcha.execute('{{  config('recaptcha.api_site_key')}}', {action: 'newslettersubmit'}).then(function(token) {
          if (token) {
            document .getElementById ('recaptcha').value = token;
            document.getElementById('form-suscribe').submit();
          }
        });
      });
    }
  }
  function onClickPasswordResetForm(e){
    e.preventDefault();
    if(  document.getElementById('email').value == '' ) {
        console.log('error validation')
    } else {
      grecaptcha.ready(function() {
        grecaptcha.execute('{{  config('recaptcha.api_site_key')}}', {action: 'passwordsubmit'}).then(function(token) {
          if (token) {
            document.getElementById('recaptcha').value = token;
            document.getElementById('recover-password').submit();
          }
        });
      });
    } 
  }
  </script>
</script>