<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Actions\Url\CreateUrlAction;
use App\Actions\Url\DeleteUrlAction;
use App\Actions\Url\IncrementUrlAccessAction;
use App\Actions\Url\UpdateUrlAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreUrlRequest;
use App\Http\Resources\Api\V1\UrlResource;
use App\Models\Url;
use Illuminate\Http\JsonResponse;

final class UrlController extends Controller
{
    public function stats(string $code): UrlResource
    {
        $url = Url::query()->where('short_code', $code)->firstOrFail();
        return new UrlResource($url);
    }

    public function store(StoreUrlRequest $request, CreateUrlAction $action): UrlResource
    {
        $url = $action->handle($request->validated());

        return new UrlResource($url);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $code, IncrementUrlAccessAction $action): UrlResource
    {
        $url = Url::query()->where('short_code', $code)->firstOrFail();
        $action->handle($url);
        
        return new UrlResource($url);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUrlRequest $request, string $code, UpdateUrlAction $action): UrlResource
    {
        $url = Url::query()->where('short_code', $code)->firstOrFail();
        $updatedUrl = $action->handle($url, $request->validated());
        
        return new UrlResource($updatedUrl);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $code, DeleteUrlAction $action): JsonResponse
    {
        $url = Url::query()->where('short_code', $code)->firstOrFail();
        $action->handle($url);
        
        return response()->json(null, 240);
    }
}