<?php

namespace App\Repositories\Export\MasterBhabin;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Throwable;

class ExcelKlasterBhabin implements FromView, ShouldAutoSize
{
    use Exportable;

    private $collection;

    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    public function view(): View
    {
        return view('excel.bhabin-klaster', ['collection' => $this->collection]);
    }

    public function failed(Throwable $exception): void
    {
        Log::error('Excel Log: ' . $exception->getMessage());
    }
}
