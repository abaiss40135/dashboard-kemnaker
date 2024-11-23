<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LastBhabinReportAlert
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (role('bhabinkamtibmas') && $request->is('bhabin')) {
            $alert = [];
            $user = auth()->user();

            $latestDDs = $user->ddsWargas()->latest()->first()?->created_at;
            $latestDeteksiDini = $user->deteksiDinis()->latest()->first()?->created_at;
            $latestPs = $user->psSengketas()->latest()->first()?->created_at;
            $latestNonPs = $user->psNonSengketas()->latest()->first()?->created_at;
            $latestPsEksekutif = $user->psEksekutifs()->latest()->first()?->created_at;

            // check distance between latest report
            $latestReport = collect([$latestDDs, $latestDeteksiDini, $latestPs, $latestNonPs, $latestPsEksekutif])->filter()->max();
            $latestReport = $latestReport ? now()->diffInDays($latestReport) : null;

            Session::put('alert_harian_laporan', [
                'expired_at' => now()->addDays($latestReport > 7 ? $latestReport : 1),
                'result' => $latestReport === 0 ? 'konsisten' : 'peringatan',
                'latest_report' => $latestReport,
                'quota' => $latestReport > 7 ? $latestReport : 1,
            ]);
            // init session
            if(Session::exists('alert_harian_laporan') === false || Session::get('alert_harian_laporan.latest_report') !== $latestReport) {
                Session::put('alert_harian_laporan', [
                    'expired_at' => now()->addDays($latestReport > 7 ? $latestReport : 1),
                    'result' => $latestReport === 0 ? 'konsisten' : 'peringatan',
                    'latest_report' => $latestReport,
                    'quota' => $latestReport > 7 ? $latestReport : 1,
                ]);
            }

            if($latestReport > 7) {
                $alert['alert']   = 'error';
                $alert['message'] = "Anda terdeteksi sudah 7 hari tidak mengirimkan laporan ke Binmas Online Systems, mohon lakukan perbaikan pada 1 minggu ke depan.<br>Apabila tidak ada perbaikan akan ada teguran yang dikirimkan dari Korbinmas Baharkam Polri." . '<br><br>' . 'Silahkan klik OK, lalu kirimkan laporan anda';
            } else if ($latestReport > 0) {
                $alert['alert']   = 'warning';
                $alert['message'] = "Anda terdeteksi pada hari kemarin tidak mengirimkan laporan ke Binmas Online Systems, mohon lakukan perbaikan pada hari ini dengan mengirimkan laporan rutin ke Binmas Online Systems.<br>Apabila tidak ada perbaikan akan ada teguran yang dikirimkan dari Korbinmas Baharkam Polri." . '<br><br>' . 'Silahkan klik OK, lalu kirimkan laporan anda';
            } else {
                $alert['alert']   = 'success';
                $alert['message'] = "Terima kasih anda sudah melaporkan kegiatan rutin pada hari kemarin, kami pimpinan di Korbinmas Baharkam Polri mengapresiasi laporan anda.<br>Pertahankan dan terus tingkatkan kinerja Anda!. Salam sehat & salam semangat.";
            }

            $session = Session::get('alert_harian_laporan');
            if ((isset($alert['message']) && $session['expired_at'] > now() && $session['quota'] > 0) || $session['type'] === 'peringatan') {
                request()->session()->flash('swal_alert_harian_laporan_bhabin', [
                        'title'     => 'Perhatian',
                        'type'      => $alert['alert'],
                    ] + $alert);

                // update quota session
                if($session['result'] === 'konsisten') {
                    $session['quota'] = $session['quota'] - 1;
                    Session::put('alert_harian_laporan', $session);
                }
            }

            // create session if session is expired (1 day)
            if ($session['expired_at'] < now()) {
                $session = [
                    'expired_at' => now()->addDays($latestReport > 7 ? $latestReport : 1),
                    'quota' => $latestReport > 7 ? $latestReport : 1,
                ];
                Session::put('alert_harian_laporan', $session);
            }
        }
        return $next($request);
    }
}
