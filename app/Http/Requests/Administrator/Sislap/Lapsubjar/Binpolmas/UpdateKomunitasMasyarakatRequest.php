<?php

namespace App\Http\Requests\Administrator\Sislap\Lapsubjar\Binpolmas;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKomunitasMasyarakatRequest extends FormRequest
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
            'polda'            => ['required'],
            'polres'           => ['required'],
            'nama_kommas'       => ["required"],
            "akta_notaris" => ["required"],
            "npwp" => ["required", "numeric"],
            "sumber_dana" => ["required"],
            "bidang_kegiatan" => ["required"],
            "jml_anggota" => ["required", "numeric"],
            "alamat" => ["required"],
            "nama_ketua" => ["required"],
            'no_hp' => ["required", "numeric"]
        ];
    }
}
