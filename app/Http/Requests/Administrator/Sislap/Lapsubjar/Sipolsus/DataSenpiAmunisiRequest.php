<?php

namespace App\Http\Requests\Administrator\Sislap\Lapsubjar\Sipolsus;

use Illuminate\Foundation\Http\FormRequest;

class DataSenpiAmunisiRequest extends FormRequest
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
            'laporan.*.polda'            => ['required'],
            'laporan.*.polres'           => ['required'],
        ];

        $polices = [
            "polsuspas",
            "polhut_lhk",
            "polhut_perhutani",
            "polsus_cagar_budaya",
            "polsuska",
            "polsus_pwp3k",
            "polsus_karantina_ikan",
            "polsus_barantan",
            "polsus_satpol_pp",
            "polsus_dishubdar"
        ];

        $attributes = [
            "genggam",
            "panjang",
            "jml"
        ];

        foreach($polices as $police)
        {
            foreach($attributes as $attribute)
            {
                $rules["laporan.*.{$police}_{$attribute}"] = "required|numeric|min:0";
            }
        }

        return $rules;
    }
}
