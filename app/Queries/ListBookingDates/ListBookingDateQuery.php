<?php
namespace App\Queries\ListBookingDates;

class ListBookingDateQuery
{
    public function __construct(
        public int $page ,
        public int $perPage ,
        public ?string $date = null,
        public ?bool $isOpen = null
    ) {
        $this->date = trim($this->date ?? ''); // chuẩn hoá dữ liệu đầu vào | Loại bỏ khoảng trắng dư
    }
}
