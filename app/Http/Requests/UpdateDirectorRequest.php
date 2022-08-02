<?php

namespace App\Http\Requests;

use App\Models\Director;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDirectorRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('director_edit');
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
