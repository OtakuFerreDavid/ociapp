<?php

namespace App\Http\Requests;

use App\Models\Book;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreBookRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('book_create');
    }

    public function rules()
    {
        return [
            'codi' => [
                'integer',
                'min:-2147483648',
                'max:2147483647',
                'nullable',
            ],
            'titol' => [
                'string',
                'nullable',
            ],
            'autor_id' => [
                'integer',
                'exists:autors,id',
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
        ];
    }
}
