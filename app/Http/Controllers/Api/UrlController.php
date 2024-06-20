<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UrlService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class UrlController extends Controller
{
    public function __construct(
        private readonly UrlService $urlService
    ){
    }

    /**
     * Shows the list of added URLs
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $urls = $this->urlService->getAllByUser(auth()->user()->id);
        return response()->json($urls);
    }

    /**
     * Gets a URL by UUID
     *
     * @param string $uuid
     *
     * @return JsonResponse
     */
    public function get(string $uuid): JsonResponse
    {
        try {
            $url = $this->urlService->getByUuid($uuid, auth()->user()->id);
        } catch (Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 404);
        }

        return response()->json($url);
    }

    /**
     * Stores a new URL requested via API
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->only([
            'original_url'
        ]);

        try {
            $url = $this->urlService->store($data, auth()->user()->id);
        } catch (InvalidArgumentException $exception){
            return response()->json(['message' => $exception->getMessage()], 400);
        }

        return response()->json($url);
    }

    /**
     * Updates Original URL of an existing URL
     *
     * @param Request $request
     * @param string $uuid
     *
     * @return JsonResponse
     */
    public function update(Request $request, string $uuid): JsonResponse
    {
        $data = $request->only([
            'original_url'
        ]);

        try {
            $url = $this->urlService->update($data, $uuid, auth()->user()->id);
        } catch (InvalidArgumentException $exception) {
            return response()->json(['message' => $exception->getMessage()], 400);
        } catch (ResourceNotFoundException $exception) {
            return response()->json(['message' => $exception->getMessage()], 404);
        }

        return response()->json($url);
    }

    /**
     * Deletes an existing URL
     *
     * @param string $uuid
     *
     * @return JsonResponse
     */
    public function destroy(string $uuid): JsonResponse
    {
        try {
            $this->urlService->delete($uuid, auth()->user()->id);
        } catch (Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 404);
        }

        return response()->json([], 204);
    }
}
