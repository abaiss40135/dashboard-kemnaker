<?php

namespace App\Http\Requests\Administrator\Sislap\Lapsubjar\BinpolmasBaru\SupervisorPolmas;

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
            'jumlah_supervisor_polres' => 'required|integer',
            'jumlah_supervisor_polsek' => 'required|integer',
            'lampiran_file' => 'file',
        ];
    }

    public function messages()
    {
        return [
            'polda.required' => 'Polda harus diisi',
            'polres.required' => 'Polres harus diisi',
            'jumlah_supervisor_polres.required' => 'Jumlah Supervisor Polres harus diisi',
            'jumlah_supervisor_polsek.required' => 'Jumlah Supervisor Polsek harus diisi',
            'lampiran_file.mimes' => 'Lampiran harus berupa file dengan format: docx, pdf',
            'jumlah_supervisor_polres.integer' => 'Jumlah Supervisor Polres harus berupa angka',
            'jumlah_supervisor_polsek.integer' => 'Jumlah Supervisor Polsek harus berupa angka',
        ];
    }
}
