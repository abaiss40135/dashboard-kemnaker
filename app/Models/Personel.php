<?php

namespace App\Models;

use App\Helpers\Constants;
use App\Models\PolisiRW\KetuaRW;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Personel extends Model
{
    protected $table = 'personel';
    protected $primaryKey = 'personel_id';
    protected $fillable = [
        'personel_id', 'user_id', 'nama', 'pangkat', 'jabatan', 'keterangan_tambahan',
        'tmt_jabatan', 'lama_jabatan', 'satuan', 'handphone', 'jenis_kelamin',
        'tanggal_lahir', 'email', 'email_dinas', 'satuan1', 'satuan2',
        'satuan3', 'satuan4', 'satuan5', 'satuan6', 'satuan7', 'no_skep'
    ];
    protected $appends = [
        'polda', 'polres', 'polsek'
    ];
    protected $hidden = [
        'user_id', 'personel_id'
    ];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function dds()
    {
        return $this->hasManyThrough(Dds_warga::class, User::class, 'user_id', 'id', 'user_id')
            ->whereHas('laporan_informasi');
    }

    public function dd()
    {
        return $this->hasManyThrough(Deteksi_dini::class, User::class, 'user_id', 'id', 'user_id')
            ->whereHas('laporan_informasi');
    }

    public function psSengketas()
    {
        return $this->hasManyThrough(Problem_solving::class, User::class, 'user_id', 'id', 'user_id');
    }

    public function getPoldaAttribute()
    {
        return Str::beforeLast($this->satuan1, '-');
    }

    public function getPolresAttribute()
    {
        return Str::beforeLast($this->satuan2, '-');
    }

    public function getPolsekAttribute()
    {
        return Str::beforeLast($this->satuan3, '-');
    }

    public function getKodeSatuanAttribute()
    {
        $satuan = $this->satuan7 ??
                    $this->satuan6 ??
                    $this->satuan5 ??
                    $this->satuan4 ??
                    $this->satuan3 ??
                    $this->satuan2 ??
                    $this->satuan1;
        $kode_satuan = Str::afterLast($satuan, '-');
        if (auth()->user()->haveRole('operator_bhabinkamtibmas_polsek')){
            $kode_satuan = substr($kode_satuan, 0, 7);
        }
        if (auth()->user()->haveRole(['operator_bhabinkamtibmas_polres', 'operator_bagopsnalev_polres', 'operator_binpolmas_polres'])){
            $kode_satuan = substr($kode_satuan, 0, 5);
        }
        if (auth()->user()->haveRole(['operator_bhabinkamtibmas_polda', 'operator_bagopsnalev_polda', 'operator_binpolmas_polda'])){
            $kode_satuan = substr($kode_satuan, 0, 3);
        }
        return $kode_satuan;
    }

    public function akumulasi_laporans()
    {
        return $this->belongsTo(AkumulasiLaporanBhabinkamtibmas::class, 'personel_id', 'personel_id');
    }

    public function klaster_rutinitas(): HasMany
    {
        return $this->hasMany(KlasterRutinitasBhabinkamtibmas::class, 'user_id', 'user_id');
    }

    public function latest_klaster_rutinitas()
    {
        return $this->hasOne(KlasterRutinitasBhabinkamtibmas::class, 'user_id', 'user_id')
            ->latestOfMany('minggu_ke')->withDefault([
                'klaster_rutinitas' => Constants::RUTINITAS_KURANG,
                'total_laporan' => 0
            ]);
    }

    public function satuan_kerja()
    {
        return $this->belongsTo(SatuanKerja::class, 'satuan_kerja_id', 'id');
    }

    public function ketua_rw()
    {
        return $this->hasOne(KetuaRW::class, 'personel_id', 'personel_id');
    }
}
