<?php

namespace App\Http\Requests;

use App\Models\Album;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAlbumRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('album_create');
    }

    public function rules()
    {
        return [
            'titol' => [
                'string',
                'nullable',
            ],
            'valoracio' => [
                'string',
                'nullable',
            ],
            'data' => [
                'date_format:' . config('project.date_format'),
                'nullable',
            ],
            'tipus' => [
                'string',
                'nullable',
            ],
            'format' => [
                'string',
                'nullable',
            ],
            'artista_id' => [
                'integer',
                'exists:artista,id',
                'nullable',
            ],
        ];
    }
}
