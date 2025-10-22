<x-guest-layout>
<!-- Session Status -->
<x-auth-session-status class="mb-4" :status="session('status')" />

<form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email Address -->
    <div>
        <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
        <div class="relative mt-1">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                <i class="fa-regular fa-envelope text-gray-400"></i>
            </div>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                   class="block w-full ps-10 border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm">
        </div>
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="mt-4">
        <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
        <div class="relative mt-1">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                <i class="fa-solid fa-lock text-gray-400"></i>
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="block w-full ps-10 border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm">
        </div>
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Remember Me & Forgot Password -->
    <div class="flex items-center justify-between mt-4">
        <label for="remember_me" class="inline-flex items-center">
            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500" name="remember">
            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
        </label>

        @if (Route::has('password.request'))
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
        @endif
    </div>

    <div class="mt-6">
        <button type="submit" class="w-full justify-center inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
            {{ __('Log in') }}
        </button>
    </div>
</form>


</x-guest-layout>