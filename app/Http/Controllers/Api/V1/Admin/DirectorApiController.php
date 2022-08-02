<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDirectorRequest;
use App\Http\Requests\UpdateDirectorRequest;
use App\Http\Resources\Admin\DirectorResource;
use App\Models\Director;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DirectorApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('director_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DirectorResource(Director::advancedFilter());
    }

    public function store(StoreDirectorRequest $request)
    {
        $director = Director::create($request->validated());

        return (new DirectorResource($director))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create()
    {
        abort_if(Gate::denies('director_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'meta' => [],
        ]);
    }

    public function show(Director $director)
    {
        abort_if(Gate::denies('director_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DirectorResource($director);
    }

    public function update(UpdateDirectorRequest $request, Director $director)
    {
        $director->update($request->validated());

        return (new DirectorResource($director))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function edit(Director $director)
    {
        abort_if(Gate::denies('director_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'data' => new DirectorResource($director),
            'meta' => [],
        ]);
    }

    public function destroy(Director $director)
    {
        abort_if(Gate::denies('director_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $director->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
