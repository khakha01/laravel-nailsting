@props([
    'prices' => [],
    'inputName' => 'prices',
    'title' => 'Cấu hình giá'
])

<div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
    <div class="px-4 py-6 sm:p-8">
        <div class="flex items-center justify-between mb-6 border-b pb-2">
            <h3 class="text-base font-semibold leading-6 text-gray-900">{{ $title }}</h3>
            <button type="button" id="addPriceBtn"
                class="inline-flex items-center rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z"
                        clip-rule="evenodd" />
                </svg>
                Thêm giá
            </button>
        </div>

        <div id="pricesContainer" class="space-y-4">
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

                <div class="price-item bg-gray-50 p-4 rounded-lg border border-gray-200 relative group animate-fade-in-down">
                    {{-- Nút xóa --}}
                    <button type="button"
                        class="absolute top-2 right-2 text-gray-400 hover:text-red-500 remove-price transition-colors"
                        title="Xóa dòng này">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Cột 1: Chọn loại giá --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Loại giá</label>
                            <select name="{{ $inputName }}[{{ $index }}][price_type]"
                                class="js-price-type-select block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                                <option value="fixed" {{ $type == 'fixed' ? 'selected' : '' }}>Giá cố định</option>
                                <option value="per_nail" {{ $type == 'per_nail' ? 'selected' : '' }}>Từng móng</option>
                                <option value="range" {{ $type == 'range' ? 'selected' : '' }}>Khoảng giá</option>
                            </select>
                            
                            <div class="mt-3">
                                <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Ghi chú (Tên giá)</label>
                                <input type="text" name="{{ $inputName }}[{{ $index }}][note]"
                                    value="{{ $price['note'] ?? ($price['title'] ?? '') }}"
                                    placeholder="Ví dụ: {{ $inputName === 'prices' ? 'Giá cơ bản' : 'Sơn thường' }}"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        {{-- Cột 2: Ô nhập giá (Thay đổi tùy theo loại) --}}
                        <div class="price-input-wrapper">

                            {{-- Trường hợp 1: Giá đơn (Fixed/Per Nail) --}}
                            <div class="js-single-price {{ $isRange ? 'hidden' : '' }}">
                                <label
                                    class="block text-xs font-medium text-gray-500 uppercase mb-1">Giá
                                    tiền (VNĐ)</label>
                                <input type="text" name="{{ $inputName }}[{{ $index }}][price]"
                                    step="1000" value="{{ isset($price['price']) ? number_format((float)$price['price'], 0, ',', '.') : '' }}"
                                    oninput="formatCurrency(this)"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                            </div>

                            {{-- Trường hợp 2: Khoảng giá (Range - Min/Max) --}}
                            <div
                                class="js-range-price grid grid-cols-2 gap-2 {{ !$isRange ? 'hidden' : '' }}">
                                <div>
                                    <label
                                        class="block text-xs font-medium text-gray-500 uppercase mb-1">Thấp
                                        nhất</label>
                                    <input type="text" oninput="formatCurrency(this)"
                                        name="{{ $inputName }}[{{ $index }}][price_min]" step="1000"
                                        value="{{ isset($price['price_min']) ? number_format((float)$price['price_min'], 0, ',', '.') : '' }}"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-medium text-gray-500 uppercase mb-1">Cao
                                        nhất</label>
                                    <input type="text" oninput="formatCurrency(this)"
                                        name="{{ $inputName }}[{{ $index }}][price_max]" step="1000"
                                        value="{{ isset($price['price_max']) ? number_format((float)$price['price_max'], 0, ',', '.') : '' }}"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                            
                            {{-- is_default checkbox (keep for backward compatibility if needed) --}}
                            @if(isset($price['is_default']) || $inputName === 'prices')
                            <div class="mt-4 flex items-center">
                                <input type="checkbox" name="{{ $inputName }}[{{ $index }}][is_default]" value="1"
                                    class="h-4 w-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500"
                                    {{ ($price['is_default'] ?? false) ? 'checked' : '' }}>
                                <label class="ml-2 text-sm text-gray-700 font-medium">Giá mặc định</label>
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

        // Initialize priceIndex by finding the max index in name attributes
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
                    <div class="price-item bg-gray-50 p-4 rounded-lg border border-gray-200 relative group animate-fade-in-down mt-4">
                        <button type="button" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 remove-price transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Loại giá</label>
                                <select name="${inputNameBase}[${priceIndex}][price_type]" class="js-price-type-select block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                                    <option value="fixed">Giá cố định</option>
                                    <option value="per_nail">Từng móng</option>
                                    <option value="range">Khoảng giá</option>
                                </select>
                                <div class="mt-3">
                                    <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Ghi chú (Tên giá)</label>
                                    <input type="text" name="${inputNameBase}[${priceIndex}][note]"
                                        placeholder="Ví dụ: Giá cơ bản"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            <div class="price-input-wrapper">
                                <div class="js-single-price">
                                    <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Giá tiền (VNĐ)</label>
                                    <input type="text" name="${inputNameBase}[${priceIndex}][price]" step="1000" oninput="formatCurrency(this)"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                                </div>

                                <div class="js-range-price grid grid-cols-2 gap-2 hidden">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Thấp nhất</label>
                                        <input type="text" name="${inputNameBase}[${priceIndex}][price_min]" step="1000" oninput="formatCurrency(this)"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Cao nhất</label>
                                        <input type="text" name="${inputNameBase}[${priceIndex}][price_max]" step="1000" oninput="formatCurrency(this)"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="mt-4 flex items-center">
                                    <input type="checkbox" name="${inputNameBase}[${priceIndex}][is_default]" value="1"
                                        class="h-4 w-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500">
                                    <label class="ml-2 text-sm text-gray-700 font-medium">Giá mặc định</label>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', html);
                priceIndex++;
            });
        }

        // Delegate events
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
