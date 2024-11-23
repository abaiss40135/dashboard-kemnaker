<?php

namespace App\Http\Requests\Administrator\Sislap;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApprovalLaporanStoreRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        if (!is_array($this->approvable_id)){
            $this->merge([
                'approvable_id' => array($this->approvable_id),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'approvable_id'   => ['required', 'array'],
            'approvable_type' => [Rule::requiredIf(function (){
                return file_exists(base_path($this->request->get('approvable_type')));
            }), 'string'],
            'is_approve'      => ['nullable']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
