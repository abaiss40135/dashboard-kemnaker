<?php

namespace App\Http\Controllers;

use App\Models\Panduan;

class PanduanPenggunaController extends Controller
{
    public function index()
    {
        return view("panduan", [
            "panduans" => Panduan::parentOnly()->has("children")->with("children")->get()
        ]);
    }
}
