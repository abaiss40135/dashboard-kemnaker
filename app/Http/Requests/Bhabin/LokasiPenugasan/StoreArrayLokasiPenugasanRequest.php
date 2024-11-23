<?php

namespace App\Http\Requests\Bhabin\LokasiPenugasan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreArrayLokasiPenugasanRequest extends FormRequest
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
        $rules = [
            'jenis_lokasi' => 'required|array',
            'jenis_lokasi.*' => 'required',
        ];
        if ($this->request->has('jenis_lokasi')){
            foreach ($this->request->get('jenis_lokasi') as $key => $jenis_lokasi) {
                $rules['provinsi_id.'.$key] = 'required|exists:provinces,code';
                if ($jenis_lokasi == 'desa'){
                    $rules['kota_id.'.$key]     = 'required|exists:cities,code';
                    $rules['kecamatan_id.'.$key]    = 'required|exists:districts,code';
                    $rules['desa_id.'.$key]         = 'required';
                    $rules['desa_lainnya.'.$key]         = Rule::requiredIf(function () use ($key) {
                        return isset($this->request->get('desa_id')[$key]) && $this->request->get('desa_id')[$key] == 'lainnya';
                    });
                } else if ($jenis_lokasi == 'kawasan'){
                    if (auth()->user()->personel->polda !== 'POLDA METRO JAYA') $rules['kota_id.'.$key]     = 'required|exists:cities,code';
                    $rules['kawasan.'.$key]    = 'required';
                }
            }
        }
        return $rules;
    }

    public function messages()
    {
        $messages = [];
        if ($this->request->has('jenis_lokasi')) {
            foreach ($this->request->get('jenis_lokasi') as $key => $value) {
                $messages['provinsi_id.' . $key . '.required'] = 'Provinsi pada urutan ke-' . ($key + 1) . '  wajib diisi';
                $messages['kota_id.' . $key . '.required'] = 'Kabupaten pada urutan ke-' . ($key + 1) . '  wajib diisi';
                $messages['kecamatan_id.' . $key . '.required'] = 'Kecamatan pada urutan ke-' . ($key + 1) . '  wajib diisi';
                $messages['desa_id.' . $key . '.required'] = 'Desa pada urutan ke-' . ($key + 1) . '  wajib diisi';
            }
        }
        return $messages;
    }
}
