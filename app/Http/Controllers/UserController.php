<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users=User::all();
        return view('users',compact('users'));
    }
    public function outlets()
    {
        $outlets=Outlet::all();
        return view('outlets',compact('outlets'));
    }
}
