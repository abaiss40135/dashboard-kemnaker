<?php

namespace App\Http\Controllers\Bhabin;

use App\Helpers\CollectionHelper;
use App\Models\Notification;
use App\Models\AtensiPimpinan;
use App\Http\Controllers\Controller;
use App\Models\Infografis;
use App\Models\Meme;
use App\Models\Naskah;
use App\Models\Paparan;
use App\Models\Uu;
use App\Models\UuDalamPolri;
use App\Models\UuLuarPolri;
use App\Notifications\AtensiPimpinanNotification;
use App\Notifications\JukrahNotification;
use App\Notifications\PusatInformasiNotification;

class NotificationController extends Controller
{
    public function index () {
        $notifications  = auth()->user()->unreadNotifications->groupBy('type')->toArray();
        return view('bhabin.notification', [
            'atensi'    => CollectionHelper::paginate(collect($notifications[AtensiPimpinanNotification::class] ?? []), 10),
            'jukrah'    => CollectionHelper::paginate(collect($notifications[JukrahNotification::class] ?? []), 10),
            'informasi' => CollectionHelper::paginate(collect($notifications[PusatInformasiNotification::class] ?? []), 10),
        ]);
    }

    public function atensiPimpinan(){
        // ambil jumlah isi dari tabel notification
        $notification = AtensiPimpinan::sum('notification');
        if($notification !== 0){
            Notification::updateOrCreate(
                ['atensi_pimpinan' => auth()->user()->email],
                ['atensi_pimpinan_jumlah' => 0]
            );
            Notification::where('atensi_pimpinan' , auth()->user()->email)->increment('atensi_pimpinan_jumlah' , $notification);

            $wasRead = Notification::where('atensi_pimpinan' , auth()->user()->email)->get();
            foreach ($wasRead as $user) {
                if($user->atensi_pimpinan == auth()->user()->email){
                    $notification = $notification - $user->atensi_pimpinan_jumlah;
                }
            }
            return response()->json($notification);
        }
        else {
            echo $notification;
        }
    }

    // infografis notification

    public function paparan (){

        // ambil jumlah isi dari tabel notification
        $notification = Paparan::sum('notification');
        if($notification !== 0){
            Notification::updateOrCreate(
                ['paparan' => auth()->user()->email],
                ['paparan_jumlah' => 0]
            );
            Notification::where('paparan' , auth()->user()->email)->increment('paparan_jumlah' , $notification);

            $wasRead = Notification::where('paparan' , auth()->user()->email)->get();
            foreach ($wasRead as $user) {
                if($user->paparan == auth()->user()->email){
                    $notification = $notification - $user->paparan_jumlah;
                }
            }
            return response()->json($notification);
        }
        else {
            echo $notification;
        }
    }
    // infografis notification

    public function infografis (){
        // ambil jumlah isi dari tabel notification
        $notification = Infografis::sum('notification');
        if($notification !== 0){
            Notification::updateOrCreate(
                ['infografis' => auth()->user()->email],
                ['infografis_jumlah' => 0]
            );
            Notification::where('infografis' , auth()->user()->email)->increment('infografis_jumlah' , $notification);

            $wasRead = Notification::where('infografis' , auth()->user()->email)->get();
            foreach ($wasRead as $user) {
                if($user->infografis == auth()->user()->email){
                    $notification = $notification - $user->infografis_jumlah;
                }
            }
            return response()->json($notification);
        }
        else {
            echo $notification;
        }
    }

    // meme notification

    public function meme (){
        // ambil jumlah isi dari tabel notification
        $notification = Meme::sum('notification');
        if($notification !== 0){
            Notification::updateOrCreate(
                ['meme' => auth()->user()->email],
                ['meme_jumlah' => 0]
            );
            Notification::where('meme' , auth()->user()->email)->increment('meme_jumlah' , $notification);

            $wasRead = Notification::where('meme' , auth()->user()->email)->get();
            foreach ($wasRead as $user) {
                if($user->meme == auth()->user()->email){
                    $notification = $notification - $user->meme_jumlah;
                }
            }
            return response()->json($notification);
        }
        else {
            echo $notification;
        }
    }


    // peraturan dalam polri notification
    public function peraturanDalamPolri (){
        // ambil jumlah isi dari tabel notification
        $notification = UuDalamPolri::sum('notification');
        if($notification !== 0){
            Notification::updateOrCreate(
                ['peraturan_dalam' => auth()->user()->email],
                ['peraturan_dalam_jumlah' => 0]
            );
            Notification::where('peraturan_dalam' , auth()->user()->email)->increment('peraturan_dalam_jumlah' , $notification);

            $wasRead = Notification::where('peraturan_dalam' , auth()->user()->email)->get();
            foreach ($wasRead as $user) {
                if($user->peraturan_dalam == auth()->user()->email){
                    $notification = $notification - $user->peraturan_dalam_jumlah;
                }
            }
            return response()->json($notification);
        }
        else {
            echo $notification;

        }
    }

    // peraturan luar polri notification
    public function peraturanLuarPolri (){
        // ambil jumlah isi dari tabel notification
        $notification = UuLuarPolri::sum('notification');
        if($notification !== 0){
            Notification::updateOrCreate(
                ['peraturan_luar' => auth()->user()->email],
                ['peraturan_luar_jumlah' => 0]
            );
            Notification::where('peraturan_luar' , auth()->user()->email)->increment('peraturan_luar_jumlah' , $notification);

            $wasRead = Notification::where('peraturan_luar' , auth()->user()->email)->get();
            foreach ($wasRead as $user) {
                if($user->peraturan_luar == auth()->user()->email){
                    $notification = $notification - $user->peraturan_luar_jumlah;
                }
            }
            return response()->json($notification);
        }
        else {
            echo $notification;
        }
    }

    // undang undang notification
    public function undangUndang(){
        // ambil jumlah isi dari tabel notification
        $notification = Uu::sum('notification');
        if($notification !== 0){
            Notification::updateOrCreate(
                ['undang_undang' => auth()->user()->email],
                ['undang_undang_jumlah' => 0]
            );
            Notification::where('undang_undang' , auth()->user()->email)->increment('undang_undang_jumlah' , $notification);

            $wasRead = Notification::where('undang_undang' , auth()->user()->email)->get();
            foreach ($wasRead as $user) {
                if($user->undang_undang == auth()->user()->email){
                    $notification = $notification - $user->undang_undang_jumlah;
                }
            }
            return response()->json($notification);
        }
        else {
            echo $notification;
        }
    }

    // naskah notification
    public function naskah(){
        // ambil jumlah isi dari tabel notification
        $notification = Naskah::sum('notification');
        if($notification !== 0){
            Notification::updateOrCreate(
                ['naskah' => auth()->user()->email],
                ['naskah_jumlah' => 0]
            );
            Notification::where('naskah' , auth()->user()->email)->increment('naskah_jumlah' , $notification);

            $wasRead = Notification::where('naskah' , auth()->user()->email)->get();
            foreach ($wasRead as $user) {
                if($user->naskah == auth()->user()->email){
                    $notification = $notification - $user->naskah_jumlah;
                }
            }
            return response()->json($notification);
        }
        else {
            echo $notification;
        }
    }

    public function checkAtensiPimpinan(){

        $notification = AtensiPimpinan::sum('notification');

         // check apakah user sudah membaca notification
        $wasRead = Notification::where('atensi_pimpinan', auth()->user()->email)->get();
        foreach ($wasRead as $user) {
            if($user->atensi_pimpinan == auth()->user()->email){
               $notification = $notification - $user->atensi_pimpinan_jumlah;
            }
        }

        return response()->json($notification);
    }



}
