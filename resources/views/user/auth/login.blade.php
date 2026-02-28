@extends('user.layout.layout')

@section('content')
    @if (session('status'))
        <div class="mb-4 rounded bg-green-100 px-4 py-3 text-green-700">
            {{ session('status') }}
        </div>
    @endif

    <div class="flex min-h-screen items-center justify-center bg-gray-100">
        <form method="POST" action="{{ route('login') }}" class="w-full max-w-md rounded-xl bg-white p-8 shadow">
            @csrf

            <h2 class="mb-1 text-2xl font-semibold text-gray-800 text-left">
                Login
            </h2>
            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="mb-1 block text-sm font-medium text-gray-700">
                    Email
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-[#ff0052] focus:outline-none focus:ring-1 focus:ring-[#ff0052]">

                @error('email')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="mb-1 block text-sm font-medium text-gray-700">
                    Password
                </label>
                <input id="password" type="password" name="password" required
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-[#ff0052] focus:outline-none focus:ring-1 focus:ring-[#ff0052]">

                @error('password')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember + Forgot -->
            <div class="mb-6 flex items-center justify-between text-sm">
                <label class="flex items-center gap-2 text-gray-600">
                    <input type="checkbox" name="remember"
                        class="rounded border-gray-300 text-[#ff0052] focus:ring-[#ff0052]">
                    Remember me
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-[#ff0052] hover:underline">
                        Forgot password?
                    </a>
                @endif
            </div>

            <button type="submit"
                class="w-full rounded-lg bg-[#ff0052] py-2 text-white font-semibold hover:bg-pink-600 transition">
                Log in
            </button>
            <div class="mt-4 flex justify-center">
                <a href="{{ route('google.redirect') }}"
                    class="inline-flex items-center px-6 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-100 transition">
                    <svg class="w-5 h-5 mr-2" viewBox="0 0 48 48">
                        <path fill="#EA4335"
                            d="M24 9.5c3.5 0 6.6 1.2 9 3.2l6.7-6.7C36.5 2.5 30.6 0 24 0 14.7 0 6.6 4.9 2.5 12.2l7.9 6.1C12.5 13.2 17.8 9.5 24 9.5z" />
                        <path fill="#4285F4"
                            d="M46.5 24c0-1.6-.1-3.2-.4-4.7H24v9h12.7c-.5 2.9-2 5.4-4.3 7.1l6.7 5.2c3.9-3.6 6.1-9 6.1-15.6z" />
                        <path fill="#FBBC05"
                            d="M12.4 28.3c-.5-1.5-.8-3.1-.8-4.8s.3-3.3.8-4.8l-7.9-6.1C3.5 15.5 2.5 19.6 2.5 24c0 4.4 1 8.5 2.9 12.1l7.9-6.1z" />
                        <path fill="#34A853"
                            d="M24 48c6.6 0 12.5-2.2 16.7-6l-7.9-6.1c-2.2 1.5-5 2.4-8.8 2.4-6.2 0-11.5-3.7-14.2-9l-7.9 6.1C6.6 43.1 14.7 48 24 48z" />
                        <path fill="none" d="M0 0h48v48H0z" />
                    </svg>
                    Login with Google
                </a>
            </div>

            <p class="mt-6 text-center text-sm text-gray-600">
                Don’t have an account?
                <a href="{{ route('register') }}" class="text-[#ff0052] hover:underline">
                    Register
                </a>
            </p>
        </form>
    </div>
@endsection