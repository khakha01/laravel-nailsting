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

            <p class="mt-6 text-center text-sm text-gray-600">
                Don’t have an account?
                <a href="{{ route('register') }}" class="text-[#ff0052] hover:underline">
                    Register
                </a>
            </p>
        </form>
    </div>
@endsection
