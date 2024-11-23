<?php

namespace App\Http\Requests\Administrator\Sislap\Lapsubjar\BinpolmasBaru\SupervisorPolmas;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
        $this->redirect = route('supervisor-polmas.index');
        return [
            'laporan.*.polda' => 'required|string',
            'laporan.*.polres' => 'required|string',
            'laporan.*.jumlah_supervisor_polres' => 'required|integer',
            'laporan.*.jumlah_supervisor_polsek' => 'required|integer',
            'laporan.*.lampiran_file' => 'required|file',
        ];
    }

    public function messages()
    {
        return [
            'laporan.*.polda.required' => 'Polda harus diisi',
            'laporan.*.polres.required' => 'Polres harus diisi',
            'laporan.*.jumlah_supervisor_polres.required' => 'Jumlah Supervisor Polres harus diisi',
            'laporan.*.jumlah_supervisor_polsek.required' => 'Jumlah Supervisor Polsek harus diisi',
            'laporan.*.lampiran_file.required' => 'Lampiran file harus diisi',
            'laporan.*.lampiran_file.mimes' => 'Lampiran harus berupa file dengan format: docx, pdf',
            'laporan.*.jumlah_supervisor_polres.integer' => 'Jumlah Supervisor Polres harus berupa angka',
            'laporan.*.jumlah_supervisor_polsek.integer' => 'Jumlah Supervisor Polsek harus berupa angka',
        ];
    }
}
