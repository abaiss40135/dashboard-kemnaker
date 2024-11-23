<?php

namespace App\Http\Requests\Administrator\PusatInformasi\Video;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVideoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'judul_video'   => 'required',
            'file_video'    => 'mimes:mp4,webm,mkv',
            'tags'          => 'required|array'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages()
    {
        return [
            'file_video.mimes' => 'Format video harus mp4, webm, atau mkv'
        ];
    }
}
