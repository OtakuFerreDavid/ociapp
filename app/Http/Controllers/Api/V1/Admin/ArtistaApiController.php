<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArtistumRequest;
use App\Http\Requests\UpdateArtistumRequest;
use App\Http\Resources\Admin\ArtistumResource;
use App\Models\Artistum;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArtistaApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('artistum_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ArtistumResource(Artistum::advancedFilter());
    }

    public function store(StoreArtistumRequest $request)
    {
        $artistum = Artistum::create($request->validated());

        return (new ArtistumResource($artistum))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create()
    {
        abort_if(Gate::denies('artistum_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'meta' => [],
        ]);
    }

    public function show(Artistum $artistum)
    {
        abort_if(Gate::denies('artistum_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ArtistumResource($artistum);
    }

    public function update(UpdateArtistumRequest $request, Artistum $artistum)
    {
        $artistum->update($request->validated());

        return (new ArtistumResource($artistum))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function edit(Artistum $artistum)
    {
        abort_if(Gate::denies('artistum_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'data' => new ArtistumResource($artistum),
            'meta' => [],
        ]);
    }

    public function destroy(Artistum $artistum)
    {
        abort_if(Gate::denies('artistum_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $artistum->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
