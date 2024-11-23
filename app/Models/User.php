<?php

namespace App\Models;

use App\Helpers\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Lab404\Impersonate\Models\Impersonate;

class User extends Authenticatable
{
    const ADMIN = 1;
    const OPERATOR_KONTEN = 2;
    const OPERATOR_MABES = 3;
    const OPERATOR_POLDA = 4;
    const BHABIN = 5;
    const BUJP = 6;
    const SATPAM = 7;
    const PUBLIK = 8;
    const PIMPINAN_POLRI = 9;
    const BHABINKAMTIBMAS_PENSIUN = 10;
    const OPERATOR_BHABINKAMTIBMAS_POLDA = 11;
    const OPERATOR_DIVHUMAS = 12;
    const OPERATOR_MABES_2 = 15;
    const BHABINKAMTIBMAS_MUTASI = 17;
    const BAGOPSNALEV_MABES = 18;
    const BAGOPSNALEV_POLDA = 19;
    const BAGOPSNALEV_POLRES = 20;
    const OPERATOR_BHABINKAMTIBMAS_POLRES = 21;
    const OPERATOR_BHABINKAMTIBMAS_POLSEK = 22;
    const POLSUS = 23;
    const OPERATOR_POLSUS_POLDA = 24;
    const OPERATOR_POLSUS_KL = 25;
    const OPERATOR_POLSUS_KL_PROVINSI = 26;
    const OPERATOR_POLSUS_KL_KOTA_KABUPATEN = 27;
    const POLISI_RW = 28;
    const BINPOLMAS_POLRES = 30;
    const BINPOLMAS_POLDA = 31;

    use Notifiable, HasFactory, Impersonate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nrp', 'password', 'email', 'fcm_key'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime'
    ];

    /**
     * By default, all users can impersonate anyone
     * this example limits it so only developers can
     * impersonate other users
     */
    public function canImpersonate(): bool
    {
        return in_array($this->email, [
            'aditya@brainmatics.com',
            'karno@brainmatics.com',
            'julianto@brainmatics.com',
            'aziz@brainmatics.com'
        ]);
    }

    /**
     * By default, all users can be impersonated,
     * this limits it to only certain users (di bawah level 6[pimpinan polri]).
     */
    public function canBeImpersonated(): bool
    {
        return $this->roles()->where('level', '<', 6)->exists();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id')->withTimestamps();
    }

    public function getRole($columns = ['*'])
    {
        return $this->roles()->select($columns)->first();
    }

    public function permissions()
    {
        return $this->roles->map->permissions->flatten()->pluck('name')->unique();
    }

    public function scopeIsAdministrator($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->where('id', self::ADMIN);
        });
    }

    public function scopeIsOperatorMabes($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->where('id', self::OPERATOR_MABES);
        });
    }

    public function scopeIsBhabinkamtibmas($query)
    {
        return $query->hasNrp()
            ->whereHas('roles', function ($query) {
                $query->where('id', self::BHABIN);
            });
    }

    public function scopeIsPublik($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->where('id', 8);
        });
    }

    public function scopeIsSatpam($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->where('id', 7);
        });
    }

    public function scopeIsBujp($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->where('id', self::BUJP);
        });
    }

    public function scopeHasNrp($query)
    {
        return $query->whereRaw('LENGTH(nrp) = 8');
    }

    public function scopeIsOperatorBinpolmas($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->where('id', self::BINPOLMAS_POLDA);
        });
    }

    public function scopeIsOperatorBinpolmasPolres($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->where('id', self::BINPOLMAS_POLRES);
        });
    }

    public function role()
    {
        return Cache::remember('roleForUserId' . $this->id, defaultCacheTime(), function () {
            return $this->roles()->first(['name'])->name;
        });
    }

    public function roleName()
    {
        return $this->roles()->first(['alias'])->alias;
    }

    public function haveRole($role)
    {
        if (!is_array($role)) {
            $role = array($role);
        }
        return Cache::remember('existRolesForUserId' . $this->id . '.' . json_encode($role), defaultCacheTime(), function () use ($role) {
            return $this->roles()->whereIn('name', $role)->exists();
        });
    }

    public function haveRoleID($role_id)
    {
        if (!is_array($role_id)) {
            $role_id = array($role_id);
        }
        return Cache::remember('existRolesForUserId' . $this->id . '.' . json_encode($role_id), defaultCacheTime(), function () use ($role_id) {
            return $this->roles()->whereIn('id', $role_id)->exists();
        });
    }

    public function doesntHaveRole()
    {
        return $this->roles()->doesntExist();
    }

    public function haveLevel(int $level)
    {
        return Cache::remember('existRolesForUserId' . $this->id . '.level.' . json_encode($level), defaultCacheTime(), function () use ($level) {
            return $this->roles()->where('level', '>=', $level)->exists();
        });
    }

    public function bujp()
    {
        return $this->hasOne(Bujp::class, 'user_id', 'id')->withDefault([
            'nama_penanggung_jawab' => 'N/A'
        ]);
    }

    public function satpam()
    {
        return $this->hasOne(Satpam::class, 'user_id', 'id')->withDefault([
            'nama' => 'Karno Nur Cahyo',
            'lokasi' => 'Kaliwungu',
            'foto_kta' => asset('img/bhabin/user/karno2.svg'),
            'no_kta' => '12345',
            'tanggal_lahir' => '16-04-1996',
            'no_hp' => '08118228886',
        ]);
    }

    public function pengguna_publik()
    {
        return $this->hasOne(PenggunaPublik::class, 'user_id', 'id');
    }

    public function lokasiPenugasans()
    {
        return $this->hasMany(LokasiPenugasan::class, 'user_id');
    }

    public function lokasi_tugas()
    {
        return $this->hasOne(LokasiPenugasan::class, 'user_id')->orderByDesc('updated_at');
    }

    public function ddsWargas()
    {
        return $this->hasMany(Dds_warga::class, 'user_id');
    }

    public function deteksiDinis()
    {
        return $this->hasMany(Deteksi_dini::class, 'user_id');
    }

    public function psSengketas()
    {
        return $this->hasMany(Problem_solving::class, 'user_id');
    }

    public function psNonSengketas()
    {
        return $this->hasMany(PsNonSengketa::class, 'user_id');
    }

    public function psEksekutifs()
    {
        return $this->hasMany(PsEksekutif::class, 'user_id');
    }

    public function personel()
    {
        return $this->hasOne(Personel::class, 'user_id', 'id')->withDefault([
            'nama' => 'Tidak terdaftar pada SIPP 2.0',
            'lama_jabatan' => '-',
            'pangkat' => '-',
            'handphone' => '-',
            'polda' => '-',
            'polres' => '-'
        ]);
    }

    public function akumulasi_laporans(): HasMany
    {
        return $this->hasMany(AkumulasiLaporanBhabinkamtibmas::class, 'user_id');
    }

    public function latest_akumulasi_laporan()
    {
        $current_periode = now()->format('Y-m');
        return $this->hasOne(AkumulasiLaporanBhabinkamtibmas::class, 'user_id')
            ->where('periode', now()->format('Y-m'))
            ->latestOfMany('periode')->withDefault([
                'total_laporan' => 0,
                'periode' => $current_periode
            ]);
    }

    public function klaster_rutinitas(): HasMany
    {
        return $this->hasMany(KlasterRutinitasBhabinkamtibmas::class, 'user_id');
    }

    public function latest_klaster_rutinitas()
    {
        return $this->hasOne(KlasterRutinitasBhabinkamtibmas::class, 'user_id')
            ->where('minggu_ke', now()->weekOfYear)
            ->latestOfMany('minggu_ke')->withDefault([
                'klaster_rutinitas' => Constants::RUTINITAS_KURANG,
                'total_laporan' => 0
            ]);
    }

    public function polsus()
    {
        return $this->hasOne(Polsus::class);
    }

    public function laporanKejadianPolsus() {
        return $this->hasMany(LaporanKejadianPolsus::class);
    }

    public function mutasiUsers()
    {
        return $this->hasMany(MutasiUser::class, 'user_id');
    }

    public function mutasi()
    {
        return $this->hasOne(MutasiUser::class, 'user_id')
            ->latestOfMany('created_at')
            ->withDefault([
                'mutasi' => false
            ]);
    }

    public function emailChanges()
    {
        return $this->hasMany(EmailChange::class, 'user_id');
    }


    public function location()
    {
        return $this->hasOne(Location::class, 'user_id');
    }

    public function dikumPersonel()
    {
        return $this->hasMany(DikumPersonel::class, 'user_id');
    }

    public function lokasi_penugasan_rw()
    {
        return $this->hasOne(\App\Models\PolisiRW\LokasiPenugasan::class, 'user_id', 'id');
    }

    /**
     * Specifies the user's FCM token
     *
     * @return string|array
     */
    public function routeNotificationForFcm()
    {
        return $this->fcm_key;
    }
}
