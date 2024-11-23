<?php

namespace App\Http\Requests\Administrator\Sislap\Lapsubjar\BinpolmasBaru\PembinaPolmas;

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
        $this->redirect = route('pembina-polmas.index');
        return [
            'laporan.*.polda' => 'required|string',
            'laporan.*.polres' => 'required|string',
            'laporan.*.jumlah_pembina_polda' => 'required|integer',
            'laporan.*.jumlah_pembina_polres' => 'required|integer',
            'laporan.*.lampiran_file' => 'required|file',
        ];
    }

    public function messages()
    {
        return [
            'laporan.*.polda.required' => 'Polda harus diisi',
            'laporan.*.polres.required' => 'Polres harus diisi',
            'laporan.*.jumlah_pembina_polda.required' => 'Jumlah Pembina Polda harus diisi',
            'laporan.*.jumlah_pembina_polres.required' => 'Jumlah Pembina Polres harus diisi',
            'laporan.*.lampiran_file.required' => 'Lampiran file harus diisi',
            'laporan.*.lampiran_file.mimes' => 'Lampiran harus berupa file dengan format: docx, pdf',
            'laporan.*.jumlah_pembina_polda.integer' => 'Jumlah Pembina Polda harus berupa angka',
            'laporan.*.jumlah_pembina_polres.integer' => 'Jumlah Pembina Polres harus berupa angka',
        ];
    }
}
