@extends('user.layout.layout')

@section('content')
<div class="flex min-h-screen items-center justify-center bg-gray-100">
    <div class="w-full max-w-md rounded-xl bg-white p-8 shadow">

        <h2 class="mb-2 text-center text-2xl font-semibold text-gray-800">
            Reset Password
        </h2>

        <p class="mb-6 text-center text-sm text-gray-600">
            Enter your email and new password to reset your account password.
        </p>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email -->
            <div class="mb-5">
                <label for="email" class="mb-1 block text-sm font-medium text-gray-700">
                    Email
                </label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email', $request->email) }}"
                    required
                    autofocus
                    autocomplete="username"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm
                           focus:border-[#ff0052] focus:outline-none focus:ring-1 focus:ring-[#ff0052]"
                >

                @error('email')
                    <p class="mt-1 text-sm text-red-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- New Password -->
            <div class="mb-5">
                <label for="password" class="mb-1 block text-sm font-medium text-gray-700">
                    New Password
                </label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm
                           focus:border-[#ff0052] focus:outline-none focus:ring-1 focus:ring-[#ff0052]"
                >

                @error('password')
                    <p class="mt-1 text-sm text-red-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <label for="password_confirmation" class="mb-1 block text-sm font-medium text-gray-700">
                    Confirm Password
                </label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm
                           focus:border-[#ff0052] focus:outline-none focus:ring-1 focus:ring-[#ff0052]"
                >

                @error('password_confirmation')
                    <p class="mt-1 text-sm text-red-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="rounded-lg bg-[#ff0052] px-4 py-2 text-sm font-semibold text-white
                           transition hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-[#ff0052]/50"
                >
                    Reset Password
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
