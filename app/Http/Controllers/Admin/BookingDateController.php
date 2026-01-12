<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingDate;
use App\Services\BookingDate\BookingDateService;
use Illuminate\Http\Request;

class BookingDateController extends Controller
{
    public function __construct(
        protected BookingDateService $bookingDateService
    ) {}

    public function create()
    {
        return view('admin.booking-date-management.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'is_open' => 'nullable|boolean',
            'time_slots' => 'array',
            'time_slots.*.start' => 'nullable|date_format:H:i',
            'time_slots.*.end' => 'nullable|date_format:H:i',
            'time_slots.*.is_open' => 'boolean',
        ]);

         $this->bookingDateService->create($validated);

        return redirect()
            ->route('booking-dates.index')
            ->with('success', 'Tạo ngày & khung giờ thành công');
    }
    public function index()
    {
$dates = $this->bookingDateService->list();
        return view('admin.booking-date-management.index', compact('dates'));
    }
}
