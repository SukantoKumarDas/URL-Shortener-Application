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
            'custom_alias' => 'nullable|string|alpha_dash|unique:urls,shortened_alias',
            'expiration_time' => 'nullable|integer|min:1',
            'is_private' => 'nullable|boolean'
        ]);

        $originalUrl = $request->input('url');
        $customAlias = $request->input('custom_alias');
        $expirationTime = $request->input('expiration_time') ?? 6;
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

        // Ensure alias is unique
        while (Url::where('shortened_alias', $alias)->exists()) {
            $alias = Str::random(6);
        }

        $url = new Url();
        $url->original_url = $originalUrl;
        $url->shortened_alias = $alias;
        $url->is_private = $isPrivate;
        $url->is_active = 1;
        $url->expired_at = Carbon::now()->addHours($expirationTime);
        $url->save();

        return redirect('/')->with('shortened_url', url($alias));
    }

    public function redirect($alias) {
        $url = Url::where('shortened_alias', $alias)->firstOrFail();
        return redirect()->to($url->original_url);
    }

    public function showCustomUrlForm() {
        return view('user.create-custom-url');
    }
}
