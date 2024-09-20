<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Url;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $number_of_user = count(User::all());
        $number_of_link = count(Url::all());
        return view('admin.index', compact('number_of_user', 'number_of_link'));
    }

    public function showUsers() {
        $users = User::all();
        return view('admin.users-list', compact('users'));
    }

    public function showLinks() {
        $links = Url::all();
        return view('admin.links-list', compact('links'));
    }
}
