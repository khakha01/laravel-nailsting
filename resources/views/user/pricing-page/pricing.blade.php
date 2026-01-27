@extends('user.layout.layout')

@section('title', 'Bảng Giá Dịch Vụ')

@section('content')
    <section class="pt-32 pb-20 bg-white relative overflow-hidden min-h-screen">
        {{-- Decorative elements --}}
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-pink-100/40 rounded-full blur-[100px] -mr-32 -mt-32">
        </div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-blue-50/40 rounded-full blur-[100px] -ml-40 -mb-40">
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            {{-- Header Section --}}
            <div class="text-center">
                <div class="flex items-center justify-center gap-2 mb-4">
                    <span class="h-[1px] w-8 bg-pink-200"></span>
                    <span class="text-pink-500 font-bold tracking-[0.3em] text-[10px] uppercase">Service Menu</span>
                    <span class="h-[1px] w-8 bg-pink-200"></span>
                </div>
                <h1 class="text-3xl md:text-4xl font-light text-gray-900 mb-4">
                    Bảng Giá <span class="font-serif italic text-pink-500">Dịch Vụ</span>
                </h1>
                <p class="text-gray-400 text-sm max-w-lg mx-auto leading-relaxed font-light">
                    Giá trị thực trên từng chi tiết. Trải nghiệm dịch vụ chăm sóc móng chuẩn mực trong không gian thư giãn.
                </p>
            </div>

            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- Main Menu Container --}}
                <div
                    class="relative bg-[#fdfdfc] shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-gray-100 rounded-[2rem] overflow-hidden">
                    <div class="relative p-8 md:p-16">
                        {{-- Categories Grid --}}
                        @if($categories && $categories->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-12 relative">

                                {{-- Vertical Divider Line (Chỉ hiện trên Desktop để tạo khối Menu) --}}
                                <div
                                    class="hidden md:block absolute left-1/2 top-0 bottom-0 w-[1px] bg-gray-100 -translate-x-1/2">
                                </div>

                                @foreach($categories as $category)
                                    @if($category->products && $category->products->count() > 0)
                                        <div class="space-y-8">
                                            {{-- Category Name --}}
                                            <div class="text-center md:text-left">
                                                <h3 class="text-lg font-bold text-gray-800 tracking-wide uppercase mb-1">
                                                    {{ $category->name }}
                                                </h3>
                                                <p class="text-[10px] text-gray-400 italic">Dịch vụ chăm sóc & làm đẹp móng</p>
                                            </div>

                                            {{-- Products --}}
                                            <div class="space-y-6">
                                                @foreach($category->products as $product)
                                                    <div class="group cursor-default">
                                                        <div class="flex justify-between items-end gap-2 mb-1">
                                                            <div class="flex items-center gap-2">
                                                                <span
                                                                    class="text-sm md:text-base font-medium text-gray-700 group-hover:text-pink-600 transition-colors">
                                                                    {{ $product->name }}
                                                                </span>
                                                                @if($product->is_hot)
                                                                    <span
                                                                        class="text-[7px] bg-pink-500 text-white px-1.5 py-0.5 rounded font-black uppercase tracking-tighter">Hot</span>
                                                                @endif
                                                            </div>

                                                            {{-- Dot Leader --}}
                                                            <div class="flex-1 border-b border-dotted border-gray-300 mb-1.5 opacity-50">
                                                            </div>

                                                            @php
                                                                $priceDisplay = 'Liên hệ';
                                                                if ($product->prices && $product->prices->count() > 0) {
                                                                    $price = $product->prices->first();
                                                                    if ($price->price_type === 'fixed' && $price->price) {
                                                                        $priceDisplay = number_format($price->price, 0, ',', '.');
                                                                    } elseif ($price->price_type === 'range' && $price->price_min) {
                                                                        $priceDisplay = number_format($price->price_min, 0, ',', '.') . ($price->price_max ? ' - ' . number_format($price->price_max, 0, ',', '.') : '+');
                                                                    }
                                                                }
                                                            @endphp
                                                            <span
                                                                class="text-sm font-bold text-gray-900 font-sans tracking-tight">{{ $priceDisplay }}</span>
                                                        </div>

                                                        @if($product->description)
                                                            <p class="text-[11px] text-gray-400 font-light leading-snug">
                                                                {{ $product->description }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        {{-- Menu Footer --}}
                        <div class="mt-20 pt-10 border-t border-gray-50 text-center">
                            <div class="inline-flex items-center gap-6">
                                <div class="text-left">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Thời gian
                                        làm việc</p>
                                    <p class="text-xs text-gray-600">09:00 AM - 08:00 PM</p>
                                </div>
                                <div class="h-8 w-[1px] bg-gray-200"></div>
                                <a href="{{ route('appointment') }}"
                                    class="text-xs font-bold text-pink-600 uppercase tracking-[0.2em] hover:text-pink-700 transition-all border-b border-pink-200 pb-1">
                                    Đặt lịch ngay &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection