<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="auth-form-wrapper px-4 py-5">
        <a href="{{ route('login') }}" class="noble-ui-logo d-block mb-2">GScan</a>
        <h5 class="text-muted font-weight-normal mb-4">Welcome back! Log in to your account.</h5>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Email" />
            <x-text-input id="password" type="password" name="password" :value="old('password')" required autofocus autocomplete="username" placeholder="Password" required autocomplete="current-password" />

            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                </label>
            </div>
            <x-primary-button>
                {{ __('Log in') }}
            </x-primary-button>
        </form>
    </div>

</x-guest-layout>
