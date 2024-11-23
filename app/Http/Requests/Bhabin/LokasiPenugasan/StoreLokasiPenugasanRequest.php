<?php

namespace App\Http\Requests\Bhabin\LokasiPenugasan;

use App\Helpers\Constants;
use Illuminate\Foundation\Http\FormRequest;

class StoreLokasiPenugasanRequest extends FormRequest
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
            "jenis_lokasi" => "required",
            "kawasan" => "required_if:jenis_lokasi,kawasan",
            "district_code" => "required_if:jenis_lokasi,desa",
            "village_code" => "required_if:jenis_lokasi,desa",
            "desa_lainnya" => "required_if:village_code,lainnya",
        ];
        if (auth()->user()->personel->polda !== 'POLDA METRO JAYA' || $this->request->get('jenis_lokasi') === 'desa'){
            $rules = array_merge($rules, [
                "province_code" => 'required|exists:provinces,code',
                "city_code" => "required|exists:cities,code",
            ]);
        }
        return $rules;
    }
}
