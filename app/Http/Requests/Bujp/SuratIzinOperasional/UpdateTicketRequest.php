<?php

namespace App\Http\Requests\Bujp\SuratIzinOperasional;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->haveRole(['administrator']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'hasil_pengecekan' => 'nullable|max:255',
            'penanganan'       => 'nullable|max:255',
            'status'           => 'required|max:255',
        ];
    }
}
