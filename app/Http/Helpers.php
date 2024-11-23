<?php

use Illuminate\Support\Facades\Cache;

if (!function_exists('can')) {
    /**
     * Check user permission
     * @param string $permission
     */
    function can($permission)
    {
        return (auth()->check() && auth()->user()->can($permission));
    }
}

if (!function_exists('canAny')) {
    /**
     * Check user permission
     * @param string $permission
     */
    function canAny($permission): bool
    {
        return (auth()->check() && auth()->user()->canAny($permission));
    }
}

if (!function_exists('role')) {
    /**
     * Check user permission
     * @param $role
     * @return bool
     */
    function role($role)
    {
        return (auth()->check() && Cache::get('roleForUserId' . auth()->user()->id, auth()->user()->role()) == $role);
    }
}

if (!function_exists('roles')) {
    /**
     * Check user permission
     * @param array $roles
     * @return bool
     */
    function roles(array $roles)
    {
        return (auth()->check() && auth()->user()->haveRole($roles));
    }
}

if (!function_exists('regex_digits')) {
    /**
     * Check user permission
     * @param array $roles
     * @return bool
     */
    function regex_digits(string $text)
    {
        return \App\Helpers\Regex::digits($text);
    }
}

if (!function_exists('defaultCacheTime')) {
    /**
     * Default cache time
     */
    function defaultCacheTime($param = null)
    {
        return $param ?? config('cache.ttl');
    }
}

if (!function_exists('extractLocation')) {
    /**
     * Extract long name location from $kode_daerah
     */
    function extractLocation($kode_daerah): string
    {
        $trimmed = rtrim($kode_daerah, 0);
        switch (strlen($trimmed)) {
            case 2:
                //Provinsi
                $model = \App\Models\Provinsi::class;
                break;
            case 4:
                //Kota
                $model = \App\Models\Kota::class;
                break;
            case 6:
                //Kecamatan
                $model = \App\Models\Kecamatan::class;
                break;
            case (9 || 10):
                //Desa
                $model = \App\Models\Desa::class;
                break;
            default:
                return 'Location Undefined!';
        }
        return app($model)
                ->where('code', 'like', $trimmed . '%')
                ->first()->long_location_name ?? $kode_daerah;
    }

    function extractLocationRaw($kode_daerah)
    {
        $location = extractLocation($kode_daerah);
        $locationArray = explode(",", $location);

        $result = '';
        foreach ($locationArray as $loc) {
            $result .= "<br>" . $loc;
        }

        return $result;
    }
}

if(!function_exists('getProvinsiOperatorPolsusPolda')) {
    function getProvinsiOperatorPolsusPolda($polda)
    {
        $arr_provinsi = explode(' ', auth()->user()->personel->polda);
        if(count($arr_provinsi) > 1) {
            unset($arr_provinsi[0]);

            $provinsi = App\Models\Provinsi::where('polda', implode(' ', $arr_provinsi))->first()->name;
            return strtolower($provinsi);
        }

        return false;
    }
}
