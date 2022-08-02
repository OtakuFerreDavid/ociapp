<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePeliculessRequest;
use App\Http\Requests\UpdatePeliculessRequest;
use App\Http\Resources\Admin\PeliculessResource;
use App\Models\Director;
use App\Models\Peliculess;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PeliculessApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('peliculess_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PeliculessResource(Peliculess::with(['director'])->advancedFilter());
    }

    public function store(StorePeliculessRequest $request)
    {
        $peliculess = Peliculess::create($request->validated());

        return (new PeliculessResource($peliculess))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create()
    {
        abort_if(Gate::denies('peliculess_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'meta' => [
                'director' => Director::get(['id', 'nom']),
            ],
        ]);
    }

    public function show(Peliculess $peliculess)
    {
        abort_if(Gate::denies('peliculess_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PeliculessResource($peliculess->load(['director']));
    }

    public function update(UpdatePeliculessRequest $request, Peliculess $peliculess)
    {
        $peliculess->update($request->validated());

        return (new PeliculessResource($peliculess))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function edit(Peliculess $peliculess)
    {
        abort_if(Gate::denies('peliculess_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'data' => new PeliculessResource($peliculess->load(['director'])),
            'meta' => [
                'director' => Director::get(['id', 'nom']),
            ],
        ]);
    }

    public function destroy(Peliculess $peliculess)
    {
        abort_if(Gate::denies('peliculess_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peliculess->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
