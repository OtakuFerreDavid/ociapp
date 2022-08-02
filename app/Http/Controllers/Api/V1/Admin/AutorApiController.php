<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAutorRequest;
use App\Http\Requests\UpdateAutorRequest;
use App\Http\Resources\Admin\AutorResource;
use App\Models\Autor;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AutorApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('autor_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AutorResource(Autor::advancedFilter());
    }

    public function store(StoreAutorRequest $request)
    {
        $autor = Autor::create($request->validated());

        return (new AutorResource($autor))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create()
    {
        abort_if(Gate::denies('autor_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'meta' => [],
        ]);
    }

    public function show(Autor $autor)
    {
        abort_if(Gate::denies('autor_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AutorResource($autor);
    }

    public function update(UpdateAutorRequest $request, Autor $autor)
    {
        $autor->update($request->validated());

        return (new AutorResource($autor))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function edit(Autor $autor)
    {
        abort_if(Gate::denies('autor_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'data' => new AutorResource($autor),
            'meta' => [],
        ]);
    }

    public function destroy(Autor $autor)
    {
        abort_if(Gate::denies('autor_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $autor->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
