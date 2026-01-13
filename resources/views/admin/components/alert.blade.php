@props(['type' => 'success', 'message'])

@php
    $colors = [
        'success' => ['bg' => 'bg-green-50', 'border' => 'border-green-400', 'text' => 'text-green-800', 'icon' => 'text-green-400', 'icon_path' => 'M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z'],
        'error' => ['bg' => 'bg-red-50', 'border' => 'border-red-400', 'text' => 'text-red-800', 'icon' => 'text-red-400', 'icon_path' => 'M10 18a8 8 0 100-16 8 8 0 000 16zm-1-4a1 1 0 112 0 1 1 0 01-2 0zm1-8a1 1 0 00-1 1v4a1 1 0 002 0V7a1 1 0 00-1-1z']
    ];
    $color = $colors[$type] ?? $colors['success'];
@endphp

<div class="mb-6 rounded-md {{ $color['bg'] }} p-4 border-l-4 {{ $color['border'] }} shadow-sm">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 {{ $color['icon'] }}" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="{{ $color['icon_path'] }}" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium {{ $color['text'] }}">
                {{ $message }}
            </p>
        </div>
    </div>
</div>
