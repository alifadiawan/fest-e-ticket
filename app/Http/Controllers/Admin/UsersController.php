<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::paginate(20);

        return view('User.Index', compact('users'));
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('User.Detail', compact('user'));
    }
    public function edit()
    {
    }
}
