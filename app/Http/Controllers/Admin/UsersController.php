<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventModel;
use App\Models\RegistrationModel;
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
        $pastEvent = RegistrationModel::with(['event:id,name', 'token:id,token'])
            ->where('user_id', '=', $id)
            ->paginate(10);

        return view('User.Detail', compact('user', 'pastEvent'));
    }
    public function edit()
    {
    }
}
