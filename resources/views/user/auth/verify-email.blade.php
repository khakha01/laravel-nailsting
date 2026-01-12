@extends('user.layout.layout')

@section('content')
<div class="flex min-h-screen items-center justify-center bg-gray-100">
    <div class="w-full max-w-md rounded-xl bg-white p-8 shadow">

        <h2 class="mb-3 text-2xl font-semibold text-gray-800 text-center">
            Verify Your Email
        </h2>

        <p class="mb-6 text-sm text-gray-600 text-center">
            Thanks for signing up! Before getting started, please verify your email
            address by clicking on the link we just emailed to you.
            If you didn’t receive the email, we will gladly send you another.
        </p>

        @if (session('status') === 'verification-link-sent')
            <div class="mb-5 rounded-lg bg-green-50 px-4 py-2 text-sm text-green-600">
                A new verification link has been sent to your email address.
            </div>
        @endif

        <div class="flex items-center justify-between gap-4">

            <!-- Resend Verification Email -->
            <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                @csrf
                <button
                    type="submit"
                    class="w-full rounded-lg bg-[#ff0052] px-4 py-2 text-sm font-semibold text-white
                           transition hover:opacity-90"
                >
                    Resend Verification Email
                </button>
            </form>
        </div>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}" class="mt-6 text-center">
            @csrf
            <button
                type="submit"
                class="text-sm font-medium text-gray-600 hover:text-[#ff0052]"
            >
                Log Out
            </button>
        </form>

    </div>
</div>
@endsection
