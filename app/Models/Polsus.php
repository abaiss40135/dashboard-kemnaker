<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Polsus extends Model
{
    protected $table = 'polsus';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fotoProfile()
    {
        // ketika operator / admin mendaftarkan user dengan cara import excel, maka foto profil akan terisi default dengan link foto
        if (explode(':', $this->foto_profile)[0] == 'https') {
            return $this->foto_profile;
        } else {
            return config('filesystems.storage_url').preg_replace('/\/\//', '/', $this->foto_profile);
        }
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function scopeFilterByAttributeUser($query)
    {
        return $query->when(role('operator_polsus_kl')
                || role('operator_polsus_kl_provinsi')
                || role('operator_polsus_kl_kota_kabupaten'), function ($q) {
                    return $q->filterByJenisPolsus(auth()->user()->polsus->jenis_polsus);
                })->when(auth()->user() && auth()->user()->haveRole('operator_polsus_polda'), function ($q) {
                    $provinsi = getProvinsiOperatorPolsusPolda(auth()->user()->personel->polda);

                    return $q->where('provinsi', strtolower($provinsi));
                });
    }

    public function scopeFilterKategoriNotNullPolsus($query)
    {
        $arrJenisPolsus = ['polsuspas', 'polsuska', 'polhut_lhk', 'polhut_perhutani'];

        return $query->when(role('operator_polsus_kl')
            || role('operator_polsus_kl_provinsi')
            || role('operator_polsus_kl_kota_kabupaten')
            && in_array(auth()->user()->polsus->jenis_polsus, $arrJenisPolsus), function ($q) {
                return $q->whereNotNull('kategori');
            });
    }

    public function scopeFilterByJenjangDiklat($query, $jenjang_diklat)
    {
        return $query->when($jenjang_diklat != 'all', function ($q) use ($jenjang_diklat) {
            $q->where('jenjang_diklat', $jenjang_diklat);
        });
    }

    public function scopeFilterByJenisPolsus($query, $jenis_polsus)
    {
        return $query->where('jenis_polsus', $jenis_polsus);
    }

    // filter polsus berdasarkan provinsi dan kabupaten instansinya
    public function scopeFilterByPolsusProvinceAndKabupaten($query)
    {
//        $operatorPolsusPolda = auth()->user() && auth()->user()->haveRoleID(User::OPERATOR_POLSUS_POLDA);
//        $operatorKlProv = auth()->user() && auth()->user()->haveRoleID(User::OPERATOR_POLSUS_KL_PROVINSI);
//        $operatorKotaKab = auth()->user() && auth()->user()->haveRoleID(User::OPERATOR_POLSUS_KL_KOTA_KABUPATEN);
//
//        return $query->when($operatorKlProv, function ($q) {
//            $q->where('provinsi', 'ilike', '%'.auth()->user()->polsus->provinsi.'%');
//        })
//            ->when($operatorPolsusPolda, function ($q) {
//                $q->where('provinsi', 'ilike', '%'.getProvinsiOperatorPolsusPolda(auth()->user()->personel->polda).'%');
//            })
//            ->when($operatorKotaKab, function ($q) {
//                $q->where('kabupaten', 'ilike', '%'.auth()->user()->polsus->kabupaten.'%');
//            });
        return $query;
    }

    public function scopeFilterPolsusPensiun($query)
    {
        return $query->where('status_pensiun', 1);
    }

    public function scopeFilterPolsusAktif($query)
    {
        return $query->whereNull('status_pensiun');
    }

    public function scopeFilterRolePolisiKhusus($query)
    {
        return $query->doesntHave('user')->orWhereHas('user', function ($q) {
            $q->whereHas('roles', function ($q) {
                $q->where('id', User::POLSUS);
            });
        });
    }

    public function getRtAttribute($value)
    {
        return $value ? $value : '-';
    }

    public function getRwAttribute($value)
    {
        return $value ? $value : '-';
    }
}
