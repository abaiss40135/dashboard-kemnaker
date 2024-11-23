<?php

namespace App\Http\Requests\Panduan;

use Illuminate\Foundation\Http\FormRequest;

class PanduanRequest extends FormRequest
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
            "title" => "required|string",
        ];
        if ($this->input('type') === "panduan"){
            return array_merge($rules, [
                "parent_id" => "required",
                "file"   => ["file", "max:" . (1024*10), "mimes:pdf"],
            ]);
        }
        return $rules;
    }
}
