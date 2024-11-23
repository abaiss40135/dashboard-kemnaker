<?php

namespace App\Http\Traits;

use Illuminate\Pagination\LengthAwarePaginator;

trait CustomPaginationTrait
{
    public $page = 5;

    public function pagination($data, $request)
    {
        $total = count($data);
        $per_page = $this->page;
        $current_page = $request?->page ?? 1;

        $starting_point = ($current_page * $per_page) - $per_page;

//        slice data yang didapatkan berdasarkan page yang dituju
        $data = array_slice($data, $starting_point, $per_page);

        return new LengthAwarePaginator($data, $total, $per_page, $current_page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);
    }
}
