<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAlbumRequest;
use App\Http\Requests\UpdateAlbumRequest;
use App\Http\Resources\Admin\AlbumResource;
use App\Models\Album;
use App\Models\Artistum;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AlbumApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('album_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AlbumResource(Album::with(['artista'])->advancedFilter());
    }

    public function store(StoreAlbumRequest $request)
    {
        $album = Album::create($request->validated());

        return (new AlbumResource($album))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create()
    {
        abort_if(Gate::denies('album_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'meta' => [
                'artista' => Artistum::get(['id', 'nom']),
            ],
        ]);
    }

    public function show(Album $album)
    {
        abort_if(Gate::denies('album_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AlbumResource($album->load(['artista']));
    }

    public function update(UpdateAlbumRequest $request, Album $album)
    {
        $album->update($request->validated());

        return (new AlbumResource($album))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function edit(Album $album)
    {
        abort_if(Gate::denies('album_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'data' => new AlbumResource($album->load(['artista'])),
            'meta' => [
                'artista' => Artistum::get(['id', 'nom']),
            ],
        ]);
    }

    public function destroy(Album $album)
    {
        abort_if(Gate::denies('album_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $album->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
