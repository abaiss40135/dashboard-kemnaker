<?php

namespace App\Http\Requests\Administrator\Sislap\Lapsubjar\BinpolmasBaru\PembinaPolmas;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'polda' => 'required|string',
            'polres' => 'required|string',
            'jumlah_pembina_polda' => 'required|integer',
            'jumlah_pembina_polres' => 'required|integer',
            'lampiran_file' => 'file',
        ];
    }

    public function messages()
    {
        return [
            'polda.required' => 'Polda harus diisi',
            'polres.required' => 'Polres harus diisi',
            'jumlah_pembina_polda.required' => 'Jumlah Pembina Polda harus diisi',
            'jumlah_pembina_polres.required' => 'Jumlah Pembina Polres harus diisi',
            'lampiran_file.mimes' => 'Lampiran harus berupa file dengan format: docx, pdf',
            'jumlah_pembina_polda.integer' => 'Jumlah Pembina Polda harus berupa angka',
            'jumlah_pembina_polres.integer' => 'Jumlah Pembina Polres harus berupa angka',
        ];
    }
}
