<?php

namespace App\Http\Requests;

use App\Models\Artistum;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreArtistumRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('artistum_create');
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
