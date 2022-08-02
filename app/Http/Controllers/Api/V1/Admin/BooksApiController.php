<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\Admin\BookResource;
use App\Models\Autor;
use App\Models\Book;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BooksApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('book_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BookResource(Book::with(['autor'])->advancedFilter());
    }

    public function store(StoreBookRequest $request)
    {
        $book = Book::create($request->validated());

        return (new BookResource($book))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create()
    {
        abort_if(Gate::denies('book_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'meta' => [
                'autor' => Autor::get(['id', 'nom']),
            ],
        ]);
    }

    public function show(Book $book)
    {
        abort_if(Gate::denies('book_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BookResource($book->load(['autor']));
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->validated());

        return (new BookResource($book))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function edit(Book $book)
    {
        abort_if(Gate::denies('book_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'data' => new BookResource($book->load(['autor'])),
            'meta' => [
                'autor' => Autor::get(['id', 'nom']),
            ],
        ]);
    }

    public function destroy(Book $book)
    {
        abort_if(Gate::denies('book_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $book->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
