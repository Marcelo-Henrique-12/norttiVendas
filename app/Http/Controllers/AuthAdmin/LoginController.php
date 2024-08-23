<?php

namespace App\Http\Controllers\AuthAdmin;

use App\Models\Contexto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = RouteServiceProvider::HOMEADMIN;

    protected function guard()
    {
        return Auth::guard('admin');
    }

    protected function loggedOut(Request $request)
    {

        return redirect('admin/login');
    }

    public function showLoginForm()
    {
        return view('auth-admin.login');
    }

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    protected function validateLogin(Request $request)
    {

        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);

    }


}
