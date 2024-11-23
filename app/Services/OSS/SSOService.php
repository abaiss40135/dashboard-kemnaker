<?php


namespace App\Services\OSS;



use Illuminate\Http\Response;

class SSOService
{
    public function validate($nib)
    {
        /**
         * Checker data pengajuan di bos
         */
        if (is_null($nib)) {
            return [
                'errors'    => 'Error',
                'message'   => 'Data nomor induk berusaha terkait tidak ditemukan',
                'status'    => Response::HTTP_NOT_FOUND
            ];
        }
        /**
         * Validasi Jenis Pelaku Usaha + Jenis Perseroan
         */
        if ($nib['jenis_pelaku_usaha'] !== "11" OR $nib['jenis_perseroan'] !== "01"){
            return [
                'errors'    => 'Error Validasi',
                'message'   => 'Pelaku usaha tidak diperkenankan berupa perseorangan',
                'status'    => Response::HTTP_UNPROCESSABLE_ENTITY
            ];
        }
        /**
         * Validasi KBLI BUJP
         */
        $isBUJP = $nib->proyeks->contains(function ($value, $key){
            return $value['kbli'] == 80100;
        });
        if (!$isBUJP){
            return [
                'errors'    => 'Error',
                'message'   => 'KBLI Perusahaan terdeteksi bukan badan usaha jasa pengamanan (BUJP)',
                'status'    => Response::HTTP_UNPROCESSABLE_ENTITY
            ];
        }
    }
}
