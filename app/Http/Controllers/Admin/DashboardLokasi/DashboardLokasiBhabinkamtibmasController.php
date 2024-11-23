<?php

namespace App\Http\Controllers\Admin\DashboardLokasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

class DashboardLokasiBhabinkamtibmasController extends Controller
{
    public function index()
    {
        return view('administrator.dashboard-lokasi.bhabinkamtibmas');
    }

    public function getProfile(Request $request)
    {
        $payload = $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $cache_name = 'bhabinkamtibmas-profile-' . $payload['user_id'];

        return Cache::remember($cache_name, 60, function () use ($payload) {
            $user = \App\Models\User::where('id', $payload['user_id'])
                ->select('id', 'nrp', 'last_login_at')
                ->first();

            $personel = \App\Helpers\ApiHelper::getBhabinByNrp($user->nrp);
            $lokasi_penugasan = \App\Models\LokasiPenugasan::where('user_id', $user->id)->get();

            return response()->json([
                'user' => $user,
                'personel' => $personel,
                'lokasi_penugasan' => $lokasi_penugasan
            ]);
        });
    }

    public function getPaginatedLocs(Request $request)
    {
        [$query, $cache_name] = array_values($this->baseQuery($request));

        $page = $request->page ?? 1;
        $locations = $query->paginate(20, ['*'], 'page', $page);

        return Cache::remember("$cache_name-page-$page", 60, function () use ($locations) {
            return response()->json([
                'payload' => $locations->items(),
                'last_page' => $locations->lastPage()
            ]);
        });
    }

    public function getLocs(Request $request)
    {
        [$query, $cache_name] = array_values($this->baseQuery($request));

        $locations = $this->convertToGeoJSON($query->get());

        return Cache::remember($cache_name, 60, function () use ($locations) {
            return response($locations)->header('Content-Type', 'application/json');
        });
    }

    private function baseQuery(Request $request)
    {
        $polda = roles(['operator_bhabinkamtibmas_polda'])
            ? auth()->user()->personel->satuan1
            : null;

        $polres = roles(['operator_bhabinkamtibmas_polres'])
            ? auth()->user()->personel->satuan2
            : null;

        $cache_name = 'bhabinkamtibmas-locations';

        $variables = ['provinsi', 'kota', 'nrp', 'start_date', 'end_date', 'polda', 'polres'];

        foreach($variables as $v)
        {
            if (!in_array($v, ['polda', 'polres'])) ${$v} = $request->$v;

            ${$v.'_exist'} = isset($$v);

            if (${$v.'_exist'}) $cache_name .= "-{$v}-{$$v}";
        }

        $query = \App\Models\Location::select([
            'locations.user_id',
            'latitude',
            'longitude'
        ])
        ->when($provinsi_exist || $kota_exist, fn ($q) =>
            $q->join('lokasi_penugasans AS l', 'l.user_id', '=', 'locations.user_id')
            ->when($provinsi_exist, fn ($q) => $q->where('l.provinsi', $provinsi))
            ->when($kota_exist, fn ($q) => $q->where('l.kota', $kota))
        )
        ->when($polda_exist || $polres_exist, fn ($q) =>
            $q->join('personel AS p', 'p.user_id', '=', 'locations.user_id')
            ->when($polda_exist, fn ($q) => $q->where('p.satuan1', $polda))
            ->when($polres_exist, fn ($q) => $q->where('p.satuan2', $polres))
        )
        ->when($nrp_exist || $start_date_exist || $end_date_exist, fn ($q) =>
            $q->join('users AS u', 'u.id', '=', 'locations.user_id')
            ->when($nrp_exist, fn ($q) => $q->where('u.nrp', $nrp))
            ->when($start_date_exist, fn ($q) => $q->whereDate('u.last_login_at', '>=', $start_date))
            ->when($end_date_exist, fn ($q) => $q->whereDate('u.last_login_at', '<=', $end_date))
        )
        // exclude locations with latitude and longitude outside of Indonesia
        ->whereBetween('latitude', [-11, 6])
        ->whereBetween('longitude', [95, 141]);

        return [$query, $cache_name];
    }

    function convertToGeoJSON(Collection $locations)
    {
        $features = $locations->map(fn ($location) => [
            'type' => 'Feature',
            'geometry' => [
                'type' => 'Point',
                'coordinates' => [$location->longitude, $location->latitude],
            ],
            'properties' => [
                'name' => 'bhabinkamtibmas-locations',
                'user_id' => $location->user_id,
            ],
        ]);

        $geoJSON = [
            'type' => 'FeatureCollection',
            'features' => $features,
        ];

        return json_encode($geoJSON);
    }
}
