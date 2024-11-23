<?php

namespace App\Http\Controllers\Admin\PusatInformasiKamtibmas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\PusatInformasi\Video\StoreVideoRequest;
use App\Http\Requests\Administrator\PusatInformasi\Video\UpdateVideoRequest;
use App\Models\VideoLanding;
use App\Services\Interfaces\VideoLandingServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoLandingController extends Controller
{
    /**
     * @var VideoLandingServiceInterface
     */
    private $videoLandingService;

    public function __construct(VideoLandingServiceInterface $videoLandingService)
    {
        $this->videoLandingService = $videoLandingService;
    }

    public function getDatatable()
    {
        return $this->videoLandingService->getDatatable();
    }

    public function index()
    {
        return view('administrator.informasi-kamtibmas.video.index');
    }

    public function store(StoreVideoRequest $request)
    {
        try {
            $video = VideoLanding::create([
                'judul_video'       => $request->judul_video,
                'file_video'        => $this->addVid($request->file_video),
                'tanggal_diunggah'  => now()->isoFormat('dddd, D MMMM Y')
            ]);
            $video->tag($request->tags);
            return $this->responseSuccess([
                'message' => 'Video berhasil ditambahkan'
            ]);
        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }

    public function show(VideoLanding $video)
    {
        return $video->load('tagged');
    }

    public function update(UpdateVideoRequest $request, VideoLanding $video)
    {
        try {
            $video->judul_video = $request->judul_video;
            if ($request->file('edit_file_video')) {
                $this->deleteVid($video->file_video);      // delete from storage
                $video->file_video = $this->addVid($request->file_video);
            }
            $video->save();
            $video->retag($request->tags);
            return $this->responseSuccess([
                'message' => 'Video berhasil diperbarui'
            ]);
        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }

    public function destroy($id)
    {
        try {
            $video = VideoLanding::find($id);
            // delete from database, if true then delete video from storage server
            if ($video->delete()){
                $this->deleteVid($video->file_video);      // delete from storage
            }
            return $this->responseSuccess([
                'message' => 'Video berhasil dihapus!'
            ]);
        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }

    private function addVid($file)
    {
        $this->uploadPath = 'pusat-informasi/video';
        return $this->saveFiles($file);
    }

    private function deleteVid($url)
    {
        $this->deleteFiles($url);
    }
}
