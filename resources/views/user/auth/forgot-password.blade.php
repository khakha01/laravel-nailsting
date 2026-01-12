@extends('user.layout.layout')

@section('content')
<div class="flex min-h-screen items-center justify-center bg-gray-100">
    <div class="w-full max-w-md rounded-xl bg-white p-8 shadow">

        <h2 class="mb-2 text-2xl font-semibold text-gray-800 text-center">
            Forgot Password
        </h2>

        <p class="mb-6 text-sm text-gray-600 text-center">
            Forgot your password? No problem. Just let us know your email address
            and we will email you a password reset link that will allow you to choose a new one.
        </p>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 rounded-lg bg-green-50 px-4 py-2 text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email -->
            <div class="mb-5">
                <label for="email" class="mb-1 block text-sm font-medium text-gray-700">
                    Email
                </label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm
                           focus:border-[#ff0052] focus:outline-none focus:ring-1 focus:ring-[#ff0052]"
                >

                @error('email')
                    <p class="mt-1 text-sm text-red-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="rounded-lg bg-[#ff0052] px-4 py-2 text-sm font-semibold text-white
                           transition hover:opacity-90"
                >
                    Email Password Reset Link
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
