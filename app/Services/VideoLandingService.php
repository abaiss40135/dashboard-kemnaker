<?php


namespace App\Services;



use App\Models\VideoLanding;
use Yajra\DataTables\Facades\DataTables;

class VideoLandingService implements Interfaces\VideoLandingServiceInterface
{
    public function getDatatable()
    {
        $query = VideoLanding::with('tagged')->latest();
        return DataTables::eloquent($query)
            ->addColumn('action', function ($collection) {
                $button = '<button type="button" data-id="' . $collection->id . '" class="btn btn-sm btn-warning btn-edit"><i class="fas fa-edit"></i></button>';
                $button .= '&nbsp;<button type="button" data-id="' . $collection->id . '" class="btn btn-sm btn-danger btn-delete"><i class="far fa-trash-alt"></i></button>';
                return $button;
            })
            ->addColumn('tags', function ($collection) {
                return $collection->tagged->implode('tag_name', ', ');
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
