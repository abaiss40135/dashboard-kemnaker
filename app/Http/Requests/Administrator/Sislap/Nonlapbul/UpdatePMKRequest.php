<?php

namespace App\Http\Requests\Administrator\Sislap\Nonlapbul;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePMKRequest extends FormRequest
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
        $arr = array();
        foreach ($this->kategori as $kategori) {
            foreach ($this->tipe as $tipe) {
                $arr += [
                    $kategori .'_'. $tipe => ['numeric', 'min:0']
                ];
            }
        }
        return array_merge(
            $arr,
            [
                'polda'              => ['required'],
                'polres'             => ['required'],
            ]
        );
    }

    public function authorize(): bool
    {
        return true;
    }
}
