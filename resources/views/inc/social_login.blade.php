<div class="text-center py-2">
    <span class="text-sm">Or, login with</span>
</div>
<div class="flex justify-around py-2">
    <a href="{{ route('social.auth', 'google') }}">
        <img src="{{ asset('images/google.svg') }}" alt="google">
        <span class="text-sm">Google</span>
    </a>
    <a href="{{ route('social.auth', 'facebook') }}">
    <img height="50" width="50" src="{{ asset('images/facebook.svg') }}" alt="facebook">
    <span class="text-sm">Facebook</span>
    </a>
</div>