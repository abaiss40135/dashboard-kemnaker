<?php

namespace App\Http\Requests\Administrator\Sislap\Nonlapbul;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePMKRequest extends FormRequest
{
    private $kategori = [
        'hewan',
        'kandang',
        'terinfeksi',
        'mati',
        'potong',
        'sembuh',
        'vaksin',
    ];
    private $tipe = [
        'sapi',
        'kerbau',
        'kambing',
        'domba',
        'babi'
    ];

    public function rules(): array
    {
        $this->redirect = route('penyakit-mulut-kuku.index');
        $arr = array();
        foreach ($this->kategori as $kategori) {
            foreach ($this->tipe as $tipe) {
                $arr += [
                    'laporan.*.' . $kategori .'_'. $tipe => ['numeric', 'min:0']
                ];
            }
        }
        return array_merge(
            $arr,
            [
                'laporan.*.polda'              => ['required',  Rule::notIn(['-'])],
                'laporan.*.polres'             => ['required',  Rule::notIn(['-'])],
            ]
        );
        /*return [
            'laporan.*.polda'              => ['required',  Rule::notIn(['-'])],
            'laporan.*.polres'             => ['required',  Rule::notIn(['-'])],
            'laporan.*.kandang_sapi'       => ['numeric', 'min:0'],
            'laporan.*.kandang_kerbau'     => ['numeric', 'min:0'],
            'laporan.*.kandang_kambing'    => ['numeric', 'min:0'],
            'laporan.*.kandang_domba'    => ['numeric', 'min:0'],
            'laporan.*.kandang_babi'       => ['numeric', 'min:0'],
            'laporan.*.hewan_sapi'         => ['numeric', 'min:0'],
            'laporan.*.hewan_kerbau'       => ['numeric', 'min:0'],
            'laporan.*.hewan_kambing'      => ['numeric', 'min:0'],
            'laporan.*.hewan_domba'      => ['numeric', 'min:0'],
            'laporan.*.hewan_babi'         => ['numeric', 'min:0'],
            'laporan.*.terinfeksi_sapi'    => ['numeric', 'min:0'],
            'laporan.*.terinfeksi_kerbau'  => ['numeric', 'min:0'],
            'laporan.*.terinfeksi_kambing' => ['numeric', 'min:0'],
            'laporan.*.terinfeksi_domba' => ['numeric', 'min:0'],
            'laporan.*.terinfeksi_babi'    => ['numeric', 'min:0'],
            'laporan.*.vaksin_sapi'        => ['numeric', 'min:0'],
            'laporan.*.vaksin_kerbau'      => ['numeric', 'min:0'],
            'laporan.*.vaksin_kambing'     => ['numeric', 'min:0'],
            'laporan.*.vaksin_domba'     => ['numeric', 'min:0'],
            'laporan.*.vaksin_babi'        => ['numeric', 'min:0'],
        ];*/
    }

    public function authorize(): bool
    {
        return true;
    }
}
