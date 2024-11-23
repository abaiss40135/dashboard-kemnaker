<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\{ Instansi,
    Polsus,
    User
};
use Maatwebsite\Excel\Concerns\{
    Importable,
    ToCollection,
    WithHeadingRow,
    WithStartRow,
    WithValidation
};
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class RegisterPolsusImport implements ToCollection,
                                      WithHeadingRow,
                                      WithValidation,
                                      WithStartRow
{
    use Importable;

    private $isAdmin;
    private $isOperatorPolda;
    private $nipNotFound = [];
    private $totalRows;

    public function startRow(): int
    {
        return 3;
    }

    public function __construct(private $role, private $type) {
        $this->isAdmin = auth()->user()->haveRole('administrator');
        $this->isOperatorPolda = auth()->user()->haveRole('operator_polsus_polda');

        HeadingRowFormatter::extend('custom', function($value, $key) {
            $result = match ($key) {
                13 => 'provinsi',
                14 => 'kabupaten',
                15 => 'kecamatan',
                16 => 'desa',
                17 => 'detail_alamat',
                18 => 'rt',
                19 => 'rw',
                default => strtolower(implode('_', explode(' ', $value)))
            };

            // attribute email dan password tidak ada di file excel yang di import
            if(in_array(23, $this->role)) {
                $result = match ($key) {
                    11 => 'provinsi',
                    12 => 'kabupaten',
                    13 => 'kecamatan',
                    14 => 'desa',
                    15 => 'detail_alamat',
                    16 => 'rt',
                    17 => 'rw',
                    default => strtolower(implode('_', explode(' ', $value)))
                };
            }

            // jika file excel yang di import memiliki header kategori (nama daop, lapas, unit, dll)
            if (
                ($key == 31 || $key == 29)
                && $value != 'Kelengkapan Perorangan'
                && $value != 'Pejabat yang Mengeluarkan Izin Pegang Senpi dan Amunisi'
            ) {
                return 'kategori';
            } else {
                return $result;
            }
        });

        HeadingRowFormatter::default('custom');
    }

    public function collection(Collection $rows)
    {
        $this->totalRows = count($rows);
        $rows->map(function($row) {
            $row = $row->toArray();

            $jenjang_diklat = $this->getJenjangDiklat($row['jenjang_diklat_polsus']);
            $kepemilikan_kta = $row['no_kta_anggota_polsus'] ? '1' : null;
            $instansi_id = $this->isAdmin || $this->isOperatorPolda
                ? Instansi::firstWhere('instansi', 'ilike', '%'.$row['instansi'].'%')?->id
                : auth()->user()->polsus->instansi_id;
            $jenis_polsus = $this->isAdmin || $this->isOperatorPolda
                ? strtolower(implode('_', explode(' ', $row['jenis_polsus'])))
                : auth()->user()->polsus->jenis_polsus;

            // date type
            $expired_kta = $this->calculateDate($row["kta_berlaku_hingga"], "Tanggal KTA berlaku hingga");
            $expired_izin_pegang = $this->calculateDate($row["masa_berlaku_izin_pegang_senpi_dan_amunisi"], 'Tanggal Masa berlaku izin pegang senpi');
            $tanggal_dikeluarkan_ijazah = $this->calculateDate($row["tanggal_dikeluarkan_ijazah"], 'Tanggal dikeluarkan ijazah');
            $tanggal_lahir = $this->calculateDate($row["tanggal_lahir"], 'Tanggal lahir');

            $memiliki_izin_senpi_amunisi = $row['no_izin_pegang_senpi_dan_amunisi'] ? 1 : null;
            $dataTambahan = [
                'provinsi'     => strtoupper(trim($row['provinsi'])),
                'kabupaten'    => ucwords(trim($row['kabupaten'])),
                'kecamatan'    => ucwords(trim($row['kecamatan'])),
                'kepemilikan_kta' => $kepemilikan_kta,
                'kategori'     => $row['kategori'] ?? '',
                'no_hp'        => $row['no_handphone_aktif'],
                'jenjang_diklat' => $jenjang_diklat,
                'no_skep'      => $row['no_skep_pengangkat_anggota_polsus'],
                'no_kta'       => $row['no_kta_anggota_polsus'],
                'expired_kta'  => $expired_kta,
                'expired_izin_pegang' => $expired_izin_pegang,
                'tanggal_lahir' => $tanggal_lahir,
                'tanggal_dikeluarkan_ijazah' => $tanggal_dikeluarkan_ijazah,
                'instansi_id'   => $instansi_id,
                'jenis_polsus'  => $jenis_polsus,
                'memiliki_izin_senpi_amunisi' => $memiliki_izin_senpi_amunisi,
                'no_izin_pegang_senpi' => $row['no_izin_pegang_senpi_dan_amunisi'],
                'pejabat_yang_mengeluarkan_izin_pegang_senpi' => $row['pejabat_yang_mengeluarkan_izin_pegang_senpi_dan_amunisi'],
            ];

            $polsusData = array_merge($this->removeNotUsedColumn($row), $dataTambahan);

            if ($this->type == 'register') { // create polsus
                if (in_array(23, $this->role)) {
                    Polsus::create($polsusData);
                } else { // operator polsus have to have relationship with user
                    $user = User::create([
                        'email'    => $row['email'],
                        'password' => bcrypt($row['password'])
                    ]);
                    $user->roles()->sync($this->role);
                    $user->polsus()->create($polsusData);
                }
            } else { // update polsus
                $polsus = Polsus::where('no_nip', $polsusData['no_nip'])?->first();
                if ($polsus) $polsus->update($polsusData);
                else array_push($this->nipNotFound, $polsusData['no_nip']);
            }
        });
    }

    public function rules(): array
    {
        $instansi = Instansi::get('instansi')->map(fn ($arr) => $arr['instansi'])->toArray();

        $jenisPolsus = [
            'Polsus Cagar Budaya',
            'Polhut LHK',
            'Polsuska',
            'Polsus Karantina Ikan',
            'Polsus PWP3K',
            'Polsuspas',
            'Polsus Barantan',
            'Polsus Dishubdar',
            'Polhut Perhutani',
            'Polsus Satpol PP'
        ];

        $roles = [
            'no_handphone_aktif' => 'required',
            'nama'          => 'required',
            'tempat_lahir'  => 'required',
            'tanggal_lahir' => 'required',
            'pangkat'       => 'required',
            'golongan'      => 'required',
            'no_nip'        => 'required',
            'jabatan'       => 'required',
            'detail_alamat' => 'required',
            'rt'            => 'nullable',
            'rw'            => 'nullable',
            'jenjang_diklat_polsus'  => 'required|in:Diklat Reguler,Belum Mengikuti Diklat Polsus,Diklat Khusus Pensiunan TNI/Polri,Diklat Khusus Pejabat di Lingkungan K/L',
            'kelengkapan_perorangan' => 'nullable',
        ];

        if ($this->isAdmin || $this->isOperatorPolda) {
            $roles = array_merge($roles, [
                'instansi'     => 'required|in:'.implode(',', $instansi),
                'jenis_polsus' => 'required|in:'.implode(',', $jenisPolsus),
            ]);
        }

        if (!in_array(23, $this->role)) {
            $roles = array_merge($roles, [
                'email'    => 'required|email|unique:users,email',
                'password' => 'required',
            ]);
        }

        return $roles;
    }

    public function customValidationMessages()
    {
        return [
            'jenjang_diklat_polsus.in' => 'Data Jenjang Diklat yang anda isi tidak sesuai dengan format, mohon sesuaikan seperti yang tertera di Form! Pilihan yang tersedia: Diklat Reguler, Belum Mengikuti Diklat Polsus, Diklat Khusus Pensiunan TNI/Polri dan Diklat Khusus Pejabat di Lingkungan K/L',
            'instansi.in' => 'Data Instansi yang anda isi tidak sesuai dengan format, mohon sesuaikan seperti yang tertera di Form!',
            'jenis_polsus.in' => 'Data Jenis Polsus yang anda isi tidak sesuai dengan format, mohon sesuaikan seperti yang tertera di Form!',
        ];
    }

    private function removeNotUsedColumn($row) {
        unset(
            $row['no'],
            $row['email'],
            $row['password'],
            $row['instansi'],
            $row['jenis_polsus'],
            $row['provinsi'],
            $row['kabupaten'],
            $row['kecamatan'],
            $row['no_handphone_aktif'],
            $row['tanggal_lahir'],
            $row['jenjang_diklat_polsus'],
            $row['tanggal_dikeluarkan_ijazah'],
            $row['no_skep_pengangkat_anggota_polsus'],
            $row['no_kta_anggota_polsus'],
            $row['kta_berlaku_hingga'],
            $row['masa_berlaku_izin_pegang_senpi_dan_amunisi'],
            $row['no_izin_pegang_senpi_dan_amunisi'],
            $row['pejabat_yang_mengeluarkan_izin_pegang_senpi_dan_amunisi'],
            $row[''],
        );

        return $row;
    }

    private function getJenjangDiklat($jenjang_diklat)
    {
        return match($jenjang_diklat) {
            'Diklat Reguler' => 'reguler',
            'Belum Mengikuti Diklat Polsus' => 'belum',
            'Diklat Khusus Pensiunan TNI/Polri' => 'khusus_tni_polri',
            'Diklat Khusus Pejabat di Lingkungan K/L' => 'khusus_pejabat_kl',
            default => 'belum'
        };
    }

    public function getNipNotFound(): array
    {
        return $this->nipNotFound;
    }

    public function getTotalRows()
    {
        return $this->totalRows;
    }

    private function calculateDate($date, $type) {
        if(!isset($date)) {
            return null;
        }

        if(is_int($date)) { // jika sudah berbentuk integer
            return gmdate("Y/m/d", (strtotime($date) - 25569) * 86400);
        } else {
            if(strpos($date, '/')) { //jika formatnya 08/07/2023
                return Carbon::createFromFormat('d/m/Y', $date, 'asia/jakarta')->format("Y/m/d");
            } else { // jika formatnya 8 juli 2023
                $bulanIndonesia = ['januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'];
                $bulanInggris = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];

                $en_time = str_replace($bulanIndonesia, $bulanInggris, strtolower($date));
                if($en_time === strtolower($date)) {
                    Throw new \Exception("Cek kembali format {$type} yang anda upload! Mungkin terjadi kesalahan ketik atau yang lain<br>Nilai: {$date}");
                }
                return Carbon::createFromFormat('j F Y', $en_time, 'asia/jakarta')->format("Y/m/d");
            }
        }

        Throw new \Exception($type . ' memiliki format yang salah! Silahkan bisa diperbaiki kembali');
    }
}
