<?php

namespace App\Http\Requests\Bujp\SuratIzinOperasional;

use App\Models\RiwayatSio;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSuratIzinOperasionalRequest extends FormRequest
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
        $riwayatSio = RiwayatSio::find($this->surat_izin_operasional);

        $rules = [
            "hasil_audit" => "nullable",
        ];

        if (role('operator_polda')) {
            $rules["file_hasil_audit"] = [Rule::requiredIf(function () use ($riwayatSio) {
                //jadwal audit sudah lewat, asumsinya sudah diaudit
                return !empty(request('status_audit')) && empty($riwayatSio->file_hasil_audit);
            }), "file"];
            $rules["file_surat_rekomendasi"] = [Rule::requiredIf(function () use ($riwayatSio) {
                //lulus audit required
                return empty($riwayatSio->file_surat_rekom) && $this->request->get('hasil_audit') == 1;
            }), "file"];
            $rules["penilaian_audit"] = [Rule::requiredIf(function () {
                //tidak lulus audit required
                return $this->request->get('hasil_audit') == 2;
            })];
        }

        if (roles(['operator_mabes', 'operator_mabes_2'])) {
            $rules['validasi_hasil_audit'] = ['required', 'boolean'];
            $rules['keterangan_validasi_hasil_audit'] = ['required_if:validasi_hasil_audit,0'];
            $rules['validasi_surat_rekom'] = ['required', 'boolean'];
            $rules['keterangan_validasi_surat_rekom'] = ['required_if:validasi_surat_rekom,0'];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'keterangan_validasi_hasil_audit.required_if' => 'Keterangan validasi dokumen penilaian audit wajib diisi apabila tidak valid dipilih',
            'keterangan_validasi_surat_rekom.required_if' => 'Keterangan validasi dokumen surat rekomendasi wajib diisi apabila tidak valid dipilih'
        ];
    }
}
