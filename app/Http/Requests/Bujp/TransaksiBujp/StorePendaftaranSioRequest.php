<?php

namespace App\Http\Requests\Bujp\TransaksiBujp;

use Illuminate\Foundation\Http\FormRequest;

class StorePendaftaranSioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nib' => 'required|exists:nomor_induk_berusaha,nib',
            'riwayat_sio_id' => 'required|exists:riwayat_sio,id',
            'id_izin' => 'required|exists:data_checklist,id_izin',
            'nama_polda' => 'required',
            'berkas_pendaftaran_sio' => 'required|array',
            'berkas_pendaftaran_sio.*' => 'required|mimes:pdf,xls,xlsx,doc,docx,jpg,jpeg,png|max:5120',
        ];
    }

    public function messages(){
        return [
            'berkas_pendaftaran_sio.required' => 'Dokumen persyaratan wajib diisi',
            'berkas_pendaftaran_sio.*.required' => 'file harus di isi !',
            'berkas_pendaftaran_sio.*.mimes' => 'file harus berformat pdf,xls,xlsx,doc,docx,jpg,jpeg,png !',
            'berkas_pendaftaran_sio.*.max' => 'file harus berukuran maksimal 5MB',

        ];
    }
}
