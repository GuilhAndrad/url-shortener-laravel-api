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
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

final class UrlController extends Controller
{
    /**
     * Get URL statistics.
     * 
     * Returns detailed information about the URL, including the total access count.
     */
    public function stats(string $shortCode): UrlResource
    {
        $url = Url::query()->where('short_code', $shortCode)->firstOrFail();
        return new UrlResource($url);
    }

    /**
     * Redirect to the original URL.
     * 
     * This endpoint finds the URL by its short code, increments the access counter 
     * via an Action, and performs a 302 redirect to the destination.
     * Note: Test directly using the browser's address bar.
     */
    public function redirect(string $shortCode, IncrementUrlAccessAction $action): RedirectResponse
    {
        $url = Url::where('short_code', $shortCode)->firstOrFail();

        $action->handle($url);

        return Redirect::to($url->url);
    }

    /**
     * Create a new short URL.
     * 
     * Validates the provided original URL and uses an Action to generate 
     * a unique short code and persist it in the database.
     */
    public function store(StoreUrlRequest $request, CreateUrlAction $action): JsonResponse
    {
        $url = $action->handle($request->validated());

        return (new UrlResource($url))
        ->response()
        ->setStatusCode(201);
    }

    /**
     * Retrieve original URL data.
     * 
     * Returns the short URL object. Each call to this endpoint 
     * increments the access counter via an Action.
     */
    public function show(string $shortCode, IncrementUrlAccessAction $action): UrlResource
    {
        $url = Url::query()->where('short_code', $shortCode)->firstOrFail();
        $action->handle($url);

        return new UrlResource($url);
    }

    /**
     * Update an existing short URL.
     * 
     * Allows changing the destination (original URL) of an existing short code.
     * Validates new data before persisting the update.
     */
    public function update(StoreUrlRequest $request, string $shortCode, UpdateUrlAction $action): UrlResource
    {
        $url = Url::query()->where('short_code', $shortCode)->firstOrFail();
        $updatedUrl = $action->handle($url, $request->validated());

        return new UrlResource($updatedUrl);
    }

    /**
     * Delete a short URL.
     * 
     * Removes the URL record from the database. 
     * Returns a 204 No Content status on success.
     */
    public function destroy(string $shortCode, DeleteUrlAction $action): JsonResponse
    {
        $url = Url::query()->where('short_code', $shortCode)->firstOrFail();
        $action->handle($url);

        return response()->json(null, 204);
    }
}
