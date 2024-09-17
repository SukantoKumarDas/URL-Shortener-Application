<?php

namespace App\Http\Controllers\User;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class UrlController extends Controller
{
    public function index() {
        dd(auth('web')->user());
        
        return view('user.index');
    }

    public function shortenUrl(Request $request) {
        $request->validate([
            'url' => 'required|url'
        ]);

        $originalUrl = $request->input('url');
        $alias = Str::random(6); // Generate a 6-character random alias

        // Ensure alias is unique
        while (Url::where('shortened_alias', $alias)->exists()) {
            $alias = Str::random(6);
        }

        Url::create([
            'original_url' => $originalUrl,
            'shortened_alias' => $alias
        ]);

        return redirect('/')->with('shortened_url', url($alias));
    }

    public function redirect($alias) {
        $url = Url::where('shortened_alias', $alias)->firstOrFail();
        return redirect()->to($url->original_url);
    }
}
