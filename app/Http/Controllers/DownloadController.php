<?php

namespace App\Http\Controllers;

use App\Models\PemanfaatanInformasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{

    public function download(Request $request) {
        $request->validate(['url' => 'required'], ['url.required' => 'URL file tidak valid']);

        $path = str_replace(config('filesystems.storage_url'), "", $request->url);
        $path = str_replace('//', '/', $path);

        if (isset($request->type) && isset($request->id)) {
            (new PemanfaatanInformasiController())->download($request);
        }
        if (Storage::disk($this->disk)->exists($path)) {
            return Storage::disk($this->disk)->download($path);
        }
    }

    public function downloadAsset(Request $request)
    {

        $file= public_path($request->url);

        $headers = array(
                'Content-Type: application/png',
                );

        return response()->download($file, $request->filename, $headers);
    }

    /**
     * Example upload function
     *
     * @param Request $request
     * @return string
     */
    public function upload(Request $request)
    {
        $this->uploadPath = 'aditya';
        $this->folderName = 'prayoga';
        $this->fileName = 'testing-file-uploads.' . $request->file('file')->getClientOriginalExtension();

        $path = $this->uploadPath . '/' . $this->folderName . '/' . $this->fileName;
        $this->saveFiles($request->file('file'));
        return $path;
    }
}
