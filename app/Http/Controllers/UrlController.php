<?php

namespace App\Http\Controllers;

use App\Services\UrlService;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use InvalidArgumentException;

class UrlController extends Controller
{
    public function __construct(
        private readonly UrlService $urlService
    ){
    }

    /**
     * Shows the URL Shortener dashboard together with the list of added URLs
     *
     * @return View|Factory
     */
    public function index(): View|Factory
    {
        $urls = $this->urlService->getAllByUser(auth()->user()->id);
        return view('url.dashboard', compact('urls'));
    }

    /**
     * Stores a new URL coming from web
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->only([
            'original_url'
        ]);

        try {
            $this->urlService->store($data, auth()->user()->id);
        } catch (InvalidArgumentException $exception){
            return redirect()->route('dashboard')->withErrors($exception->getMessage());
        }

        return redirect()->route('dashboard');
    }

    /**
     * Updates Original URL of an existing URL
     *
     * @param Request $request
     * @param string $uuid
     *
     * @return RedirectResponse
     */
    public function update(Request $request, string $uuid): RedirectResponse
    {
        $data = $request->only([
            'original_url'
        ]);

        try {
            $this->urlService->update($data, $uuid, auth()->user()->id);
        } catch (Exception $exception){
            return redirect()->route('dashboard')->withErrors($exception->getMessage());
        }

        return redirect()->route('dashboard');
    }

    /**
     * Deletes an existing URL
     *
     * @param string $uuid
     *
     * @return RedirectResponse
     */
    public function destroy(string $uuid): RedirectResponse
    {
        try {
            $this->urlService->delete($uuid, auth()->user()->id);
        } catch (Exception $exception){
            return redirect()->route('dashboard')->withErrors($exception->getMessage());
        }

        return redirect()->route('dashboard');
    }

    /**
     * Redirect users to the Original URL based on the shortened URL
     *
     * @param string $shortenedUrl
     *
     * @return Redirector|RedirectResponse
     */
    public function redirect(string $shortenedUrl): Redirector|RedirectResponse
    {
        $url = $this->urlService->getByShortenedUrl($shortenedUrl);
        return redirect($url->original_url, 302);
    }
}
