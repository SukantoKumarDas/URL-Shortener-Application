<?php

namespace App\Http\Controllers\User;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class UrlController extends Controller
{
    public function index() {
        return view('user.index');
    }

    public function shortenUrl(Request $request) {
        $request->validate([
            'url' => 'required|url',
        ]);

        $originalUrl = $request->input('url');
        $alias = Str::random(6); // Generate a 6-character random alias
        
        // Ensure alias is unique
        while (Url::where('shortened_alias', $alias)->exists()) {
            $alias = Str::random(6);
        }

        $url = new Url();
        $url->original_url = $originalUrl;
        $url->shortened_alias = $alias;
        $url->is_private = 0;
        $url->expired_at = Carbon::now()->addHours(6);
        $url->save();

        return redirect('/')->with('shortened_url', url($alias));
    }

    public function customShortenUrl(Request $request) {
        $request->validate([
            'url' => 'required|url',
            'custom_alias' => 'nullable|string|alpha_dash|unique:urls,shortened_alias',
            'expires_after' => 'nullable|integer|min:1',
            'is_private' => 'nullable|boolean'
        ]);

        $originalUrl = $request->input('url');
        $customAlias = $request->input('custom_alias');
        $expirationTime = $request->input('expires_after') ?? 6;
        $isPrivate = $request->input('is_private', 0);

        if ($customAlias) {
            $alias = $customAlias;
        } else {
            $alias = Str::random(6); // Generate a 6-character random alias

            // Ensure alias is unique
            while (Url::where('shortened_alias', $alias)->exists()) {
                $alias = Str::random(6);
            }
        }

        $url = new Url();
        $url->user_id = auth()->user()->id;
        $url->original_url = $originalUrl;
        $url->shortened_alias = $alias;
        $url->is_private = $isPrivate;
        $url->expired_at = Carbon::now()->addHours($expirationTime);
        $url->save();

        return response()->json(['shortened_url' => url($alias)]);
    }

    public function redirect($alias) {
        try {
            $url = Url::where('shortened_alias', $alias)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'URL not found.');
        }

        if ($url->expired_at && \Carbon\Carbon::now()->greaterThan($url->expired_at)) {
            abort(410, 'This URL has expired.');
        }

        if ($url->is_private) {
            if (auth()->check() && auth()->id() === $url->user_id) {
                return redirect()->to($url->original_url);
            } else {
                abort(403, 'Unauthorized access to this URL.');
            }
        }
        return redirect()->to($url->original_url);
    }

    public function showCustomUrlForm() {
        return view('user.create-custom-url');
    }

    public function checkUrlAvailable(Request $request) {
        $alias = $request->input('custom_url');
        if( Url::where('shortened_alias', $alias)->exists() ) {
            return response()->json(['valid' => false]);
        } else {
            return response()->json(['valid' => true]);
        }
    }
}
