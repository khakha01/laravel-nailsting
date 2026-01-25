@extends('user.layout.layout')
@section('content')

    <div class="pt-32 pb-16">
        <div class="max-w-2xl mx-auto px-4">
            <div class="relative text-center">
                <div class="inline-flex items-center justify-center space-x-2 mb-4">
                    <span class="w-8 h-[1px] bg-pink-300"></span>
                    <span class="text-pink-500 font-bold tracking-[0.3em] text-[10px] uppercase">Gìn giữ nét thanh
                        xuân</span>
                    <span class="w-8 h-[1px] bg-pink-300"></span>
                </div>

                <h2 class="text-4xl md:text-5xl font-serif text-gray-800 mb-1">
                    Đặt Lịch <span class="text-pink-500 italic">Làm Nails</span>
                </h2>

                <div class="absolute -top-10 left-1/4 w-32 h-32 bg-pink-200/40 rounded-full blur-3xl -z-10"></div>
            </div>

            @include('user.components.booking')
        </div>
    </div>

@endsection