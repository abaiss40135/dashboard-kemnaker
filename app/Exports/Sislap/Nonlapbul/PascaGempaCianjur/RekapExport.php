<?php

namespace App\Exports\Sislap\Nonlapbul\PascaGempaCianjur;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapExport implements FromArray, WithHeadings, ShouldAutoSize
{
    use Exportable;
    private array $headers, $body;

    public function __construct(array $array)
    {
        $this->headers = $array['headers'];
        $this->body = $array['body'];
    }

    public function array(): array
    {
        $rows = [];

        foreach ($this->body as $key => $prop) {
            $rows[] = array_merge([$key], $prop);
        }

        return $rows;
    }

    public function headings(): array
    {
        return ['KESATUAN', ...$this->headers];
    }
}
