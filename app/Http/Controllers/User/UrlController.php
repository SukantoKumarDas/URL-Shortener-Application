<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UrlService;

class UrlController extends Controller
{
    protected $urlService;

    public function __construct(UrlService $urlService) {
        $this->urlService = $urlService;
    }
    
    public function index() {
        return view('user.index');
    }

    public function shortenUrl(Request $request) {
        $request->validate([
            'url' => 'required|url',
        ]);

        $shortenedUrl = $this->urlService->createShortenedUrl($request->input('url'));

        return redirect('/')->with('shortened_url', url($shortenedUrl->shortened_alias));
    }

    public function customShortenUrl(Request $request) {
        $request->validate([
            'url' => 'required|url',
            'custom_alias' => 'nullable|string|alpha_dash|unique:urls,shortened_alias',
            'expires_after' => 'nullable|integer|min:1',
            'is_private' => 'nullable|boolean'
        ]);

        $shortenedUrl = $this->urlService->createShortenedUrl(
            $request->input('url'),
            $request->input('custom_alias'),
            $request->input('expires_after', 6),
            $request->input('is_private', 0)
        );

        return response()->json(['shortened_url' => url($shortenedUrl->shortened_alias)]);
    }

    public function redirect($alias) {
        $url = $this->urlService->checkUrlExpiry($alias);

        if (!$url) {
            abort(404, 'URL not found.');
        }

        if ($url->expired_at && \Carbon\Carbon::now()->greaterThan($url->expired_at)) {
            abort(410, 'This URL has expired.');
        }

        if ($url->is_private && (!auth()->check() || auth()->id() !== $url->user_id)) {
            abort(403, 'Unauthorized access to this URL.');
        }

        return redirect()->to($url->original_url);
    }

    public function showCustomUrlForm() {
        return view('user.create-custom-url');
    }

    public function checkUrlAvailable(Request $request) {
        $alias = $request->input('custom_url');
        $valid = !$this->urlService->checkUrlExpiry($alias);

        return response()->json(['valid' => $valid]);
    }
}
