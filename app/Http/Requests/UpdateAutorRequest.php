<?php

namespace App\Http\Requests;

use App\Models\Autor;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAutorRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('autor_edit');
    }

    public function rules()
    {
        return [
            'nom' => [
                'string',
                'nullable',
            ],
        ];
    }
}
