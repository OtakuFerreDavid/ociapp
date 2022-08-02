<?php

namespace App\Http\Requests;

use App\Models\Peliculess;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePeliculessRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('peliculess_create');
    }

    public function rules()
    {
        return [
            'titol' => [
                'string',
                'nullable',
            ],
            'director_id' => [
                'integer',
                'exists:directors,id',
                'nullable',
            ],
            'data' => [
                'date_format:' . config('project.date_format'),
                'nullable',
            ],
            'valoracio' => [
                'string',
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
        ];
    }
}
