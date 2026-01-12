@extends('user.layout.layout')

@section('content')
<div class="flex min-h-screen items-center justify-center bg-gray-100">
    <form method="POST" action="{{ route('register') }}"
        class="w-full max-w-md rounded-xl bg-white p-8 shadow">
        @csrf

        <h2 class="mb-1 text-2xl font-semibold text-gray-800">
            Create Account
        </h2>
        <p class="mb-6 text-sm text-gray-500">
            Đăng ký để sử dụng hệ thống realtime
        </p>

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="mb-1 block text-sm font-medium text-gray-700">
                Name
            </label>
            <input id="name" type="text" name="name"
                value="{{ old('name') }}"
                required autofocus
                class="w-full rounded-lg border border-gray-300 px-4 py-2
                       focus:border-[#ff0052] focus:ring-[#ff0052] focus:ring-1">

            @error('name')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="mb-1 block text-sm font-medium text-gray-700">
                Email
            </label>
            <input id="email" type="email" name="email"
                value="{{ old('email') }}"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-2
                       focus:border-[#ff0052] focus:ring-[#ff0052] focus:ring-1">

            @error('email')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="mb-1 block text-sm font-medium text-gray-700">
                Password
            </label>
            <input id="password" type="password" name="password"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-2
                       focus:border-[#ff0052] focus:ring-[#ff0052] focus:ring-1">

            @error('password')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <label for="password_confirmation"
                class="mb-1 block text-sm font-medium text-gray-700">
                Confirm Password
            </label>
            <input id="password_confirmation" type="password"
                name="password_confirmation"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-2
                       focus:border-[#ff0052] focus:ring-[#ff0052] focus:ring-1">
        </div>

        <!-- Submit -->
        <button type="submit"
            class="w-full rounded-lg bg-[#ff0052] py-2 font-semibold text-white
                   hover:opacity-90 transition">
            Register
        </button>

        <!-- Footer -->
        <p class="mt-6 text-center text-sm text-gray-600">
            Already have an account?
            <a href="{{ route('login') }}"
               class="font-medium text-[#ff0052] hover:underline">
                Login
            </a>
        </p>
    </form>
</div>
@endsection
