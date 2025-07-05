<div class="text-center py-2">
    <span class="text-sm">Or, {{request()->routeIs('login') ?  'login ' : 'sing up '}} with</span>
</div>
<div class="flex justify-around py-2">
    <div>
        <div 
        id="g_id_onload"
        data-client_id="{{ env('GOOGLE_CLIENT_ID') }}"
        data-context="signin"
        data-ux_mode="popup"
        data-callback="handleGoogleSignIn"
        data-auto_prompt="false"
        ></div>
        <div class="g_id_signin bg-white dark:bg-black"
        data-type="icon"
        data-shape="circle"
        data-theme="filled_blue"
        data-text="signin_with"
        data-size="large"
        data-logo_alignment="left">
        </div>
    </div>
     <div onclick="loginWithFacebook()" class="cursor-pointer">
    <img height="45" width="45" src="{{ asset('images/facebook.svg') }}" alt="facebook">
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
            FB.api('/me',{fields: 'name, email, picture'}, function(response) {
            fetch('/social/facebook/callback', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ id: response.id, name:response.name, email:response.email, avatar:response.picture.data.url })
          })
          .then(response => response.json())
          .then(data => {
            window.location.href = "{{ route('home') }}"
          })
          .catch(error => {
            // Handle errors
            console.error(error);
          });
            });
            } else {
            console.log('User cancelled login or did not fully authorize.');
            }
        });
    }
</script>
<script src="https://accounts.google.com/gsi/client" async></script>
<script>
    function handleGoogleSignIn(res){
        // Decode the JWT to access user profile information
        const profile = JSON.parse(atob(res.credential.split('.')[1]));
        fetch("/social/google/callback", {
        method: "POST",
        headers: { 
            "Content-Type": "application/json",
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Cross-Origin-Opener-Policy': 'same-origin',
         },
        body: JSON.stringify({ name: profile.name, email:profile.email, id:profile.sub, avatar:profile.picture }),
    })
    .then(response => response.json())
    .then(data => {
        window.location.href = "{{ route('home') }}"
    })
    .catch(console.error);
    }
</script>

@endpush