<div class="text-center py-2">
    <span class="text-sm">Or, login with</span>
</div>
<div class="flex justify-around py-2">
    <a href="{{ route('social.auth', 'google') }}">
        <img src="{{ asset('images/google.svg') }}" alt="google">
        <span class="text-sm">Google</span>
    </a>
    {{-- <a href="{{ route('social.auth', 'facebook') }}">
    <img height="50" width="50" src="{{ asset('images/facebook.svg') }}" alt="facebook">
    <span onclick="loginWithFacebook()" class="text-sm">Facebook</span>
    </a> --}}
     <div onclick="loginWithFacebook()" class="cursor-pointer">
    <img height="50" width="50" src="{{ asset('images/facebook.svg') }}" alt="facebook">
    <span  class="text-sm">Facebook</span>
    </div>
</div>
@push('scripts')
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId            : '{{ env('FACEBOOK_CLIENT_ID') }}',
      xfbml            : true,
      version          : 'v23.0'
    });
  };
</script>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
<script>
        function loginWithFacebook() {
      FB.login(function(response) {
        if (response.authResponse) {
          // Send the access token to your Laravel backend
          fetch('/social/facebook/callback', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ access_token: response.authResponse.accessToken })
          })
          .then(response => response.json())
          .then(data => {
            // Handle successful login (redirect, etc.)
            console.log(data);
          })
          .catch(error => {
            // Handle errors
            console.error(error);
          });
        } else {
          // User cancelled login or did not grant permissions
          console.log('User cancelled login or did not grant permissions.');
        }
      }, {scope: 'email,public_profile'}); // Request permissions
    }
</script>
@endpush