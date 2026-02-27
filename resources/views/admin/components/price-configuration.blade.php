@props([
    'prices' => [],
    'inputName' => 'prices',
    'title' => 'Cấu hình giá'
])

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4 flex items-center justify-between">
        <h3 class="font-bold text-slate-800 flex items-center gap-2">
            <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
            {{ $title }}
        </h3>
        <button type="button" id="addPriceBtn"
            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-md shadow-blue-200 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Thêm giá mới
        </button>
    </div>

    <div class="p-6">
        <div id="pricesContainer" class="space-y-6">
            {{-- Lấy dữ liệu cũ nếu validate lỗi, mặc định 1 dòng --}}
            @php
                $displayPrices = !empty($prices) ? $prices : [
                    ['price_type' => 'fixed', 'price' => '', 'price_min' => '', 'price_max' => '', 'note' => ''],
                ];
            @endphp

            @foreach ($displayPrices as $index => $price)
                @php
                    // Cast to array if it is an object
                    $price = (array) $price;
                    $type = $price['price_type'] ?? 'fixed';
                    $isRange = $type === 'range';
                @endphp

                <div class="price-item bg-slate-50/50 p-6 rounded-2xl border border-slate-200 relative group transition-all hover:shadow-md hover:border-blue-300 animate-fade-in-down">
                    {{-- Nút xóa --}}
                    <button type="button"
                        class="absolute -top-2 -right-2 h-8 w-8 flex items-center justify-center bg-white text-slate-400 hover:text-red-600 rounded-full border border-slate-200 shadow-sm transition-all remove-price opacity-0 group-hover:opacity-100"
                        title="Xóa dòng này">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Cột 1: Chọn loại giá --}}
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Loại giá</label>
                                <select name="{{ $inputName }}[{{ $index }}][price_type]"
                                    class="js-price-type-select w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-2.5 text-sm text-slate-900">
                                    <option value="fixed" {{ $type == 'fixed' ? 'selected' : '' }}>Giá cố định</option>
                                    <option value="per_nail" {{ $type == 'per_nail' ? 'selected' : '' }}>Từng móng</option>
                                    <option value="range" {{ $type == 'range' ? 'selected' : '' }}>Khoảng giá</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ghi chú (Tên giá)</label>
                                <input type="text" name="{{ $inputName }}[{{ $index }}][note]"
                                    value="{{ $price['note'] ?? ($price['title'] ?? '') }}"
                                    placeholder="Ví dụ: {{ $inputName === 'prices' ? 'Giá cơ bản' : 'Sơn thường' }}"
                                    class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-2.5 text-sm text-slate-900">
                            </div>
                        </div>

                        {{-- Cột 2: Ô nhập giá (Thay đổi tùy theo loại) --}}
                        <div class="price-input-wrapper space-y-4">
                            {{-- Trường hợp 1: Giá đơn (Fixed/Per Nail) --}}
                            <div class="js-single-price {{ $isRange ? 'hidden' : '' }}">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Giá tiền (VNĐ)</label>
                                <div class="relative flex items-center">
                                    <input type="text" name="{{ $inputName }}[{{ $index }}][price]"
                                        value="{{ isset($price['price']) ? number_format((float)$price['price'], 0, ',', '.') : '' }}"
                                        oninput="formatCurrency(this)"
                                        class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-2.5 text-sm text-slate-900 pr-12">
                                    <span class="absolute right-4 text-slate-400 text-xs font-bold">VNĐ</span>
                                </div>
                            </div>

                            {{-- Trường hợp 2: Khoảng giá (Range - Min/Max) --}}
                            <div class="js-range-price grid grid-cols-2 gap-4 {{ !$isRange ? 'hidden' : '' }}">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Thấp nhất</label>
                                    <div class="relative flex items-center">
                                        <input type="text" name="{{ $inputName }}[{{ $index }}][price_min]"
                                            oninput="formatCurrency(this)"
                                            value="{{ isset($price['price_min']) ? number_format((float)$price['price_min'], 0, ',', '.') : '' }}"
                                            class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-2.5 text-xs text-slate-900">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Cao nhất</label>
                                    <div class="relative flex items-center">
                                        <input type="text" name="{{ $inputName }}[{{ $index }}][price_max]"
                                            oninput="formatCurrency(this)"
                                            value="{{ isset($price['price_max']) ? number_format((float)$price['price_max'], 0, ',', '.') : '' }}"
                                            class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-2.5 text-xs text-slate-900">
                                    </div>
                                </div>
                            </div>
                            
                            {{-- is_default checkbox --}}
                            @if(isset($price['is_default']) || $inputName === 'prices')
                            <div class="pt-2 flex items-center">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="{{ $inputName }}[{{ $index }}][is_default]" value="1" 
                                        class="sr-only peer" {{ ($price['is_default'] ?? false) ? 'checked' : '' }}>
                                    <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                                    <span class="ml-3 text-sm font-bold text-slate-700">Đặt làm mặc định</span>
                                </label>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('pricesContainer');
        const addBtn = document.getElementById('addPriceBtn');
        const inputNameBase = '{{ $inputName }}';

        let priceIndex = 0;
        const findMaxIndex = () => {
            const inputs = container.querySelectorAll(`select[name^="${inputNameBase}["]`);
            let max = -1;
            inputs.forEach(input => {
                const match = input.name.match(new RegExp(`${inputNameBase}\\[(\\d+)\\]`));
                if (match) {
                    const idx = parseInt(match[1]);
                    if (idx > max) max = idx;
                }
            });
            return max + 1;
        };
        priceIndex = findMaxIndex();

        // Add row
        if (addBtn) {
            addBtn.addEventListener('click', function() {
                const html = `
                    <div class="price-item bg-slate-50/50 p-6 rounded-2xl border border-slate-200 relative group transition-all hover:shadow-md hover:border-blue-300 animate-fade-in-down">
                        <button type="button" class="absolute -top-2 -right-2 h-8 w-8 flex items-center justify-center bg-white text-slate-400 hover:text-red-600 rounded-full border border-slate-200 shadow-sm transition-all remove-price opacity-0 group-hover:opacity-100" title="Xóa dòng này">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Loại giá</label>
                                    <select name="${inputNameBase}[${priceIndex}][price_type]" class="js-price-type-select w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-2.5 text-sm text-slate-900">
                                        <option value="fixed">Giá cố định</option>
                                        <option value="per_nail">Từng móng</option>
                                        <option value="range">Khoảng giá</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ghi chú (Tên giá)</label>
                                    <input type="text" name="${inputNameBase}[${priceIndex}][note]" placeholder="Ví dụ: Giá cơ bản" class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-2.5 text-sm text-slate-900">
                                </div>
                            </div>
                            <div class="price-input-wrapper space-y-4">
                                <div class="js-single-price">
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Giá tiền (VNĐ)</label>
                                    <div class="relative flex items-center">
                                        <input type="text" name="${inputNameBase}[${priceIndex}][price]" oninput="formatCurrency(this)" class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-2.5 text-sm text-slate-900 pr-12">
                                        <span class="absolute right-4 text-slate-400 text-xs font-bold">VNĐ</span>
                                    </div>
                                </div>
                                <div class="js-range-price grid grid-cols-2 gap-4 hidden">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Thấp nhất</label>
                                        <input type="text" name="${inputNameBase}[${priceIndex}][price_min]" oninput="formatCurrency(this)" class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-2.5 text-xs text-slate-900">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Cao nhất</label>
                                        <input type="text" name="${inputNameBase}[${priceIndex}][price_max]" oninput="formatCurrency(this)" class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-2.5 text-xs text-slate-900">
                                    </div>
                                </div>
                                <div class="pt-2 flex items-center">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="${inputNameBase}[${priceIndex}][is_default]" value="1" class="sr-only peer">
                                        <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                                        <span class="ml-3 text-sm font-bold text-slate-700">Đặt làm mặc định</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', html);
                priceIndex++;
            });
        }

        container.addEventListener('click', function(e) {
            if (e.target.closest('.remove-price')) {
                e.target.closest('.price-item').remove();
            }
        });

        container.addEventListener('change', function(e) {
            if (e.target.classList.contains('js-price-type-select')) {
                const select = e.target;
                const wrapper = select.closest('.grid').querySelector('.price-input-wrapper');
                const singlePriceDiv = wrapper.querySelector('.js-single-price');
                const rangePriceDiv = wrapper.querySelector('.js-range-price');

                if (select.value === 'range') {
                    singlePriceDiv.classList.add('hidden');
                    rangePriceDiv.classList.remove('hidden');
                } else {
                    singlePriceDiv.classList.remove('hidden');
                    rangePriceDiv.classList.add('hidden');
                }
            }
        });
    });
</script>
@endpush
@endonce
