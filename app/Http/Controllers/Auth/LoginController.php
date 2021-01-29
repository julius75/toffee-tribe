<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function authenticated()
    {
        $assignedLocation = \App\Restaurant::where('host_id', '=', Auth::user()->id)->first();
        if ( Auth::user()->hasRole('admin') ) {
            return redirect()->route('admin.home');
        }
        elseif ( Auth::user()->hasRole('host') && $assignedLocation)
        {
            return redirect()->route('host.home');
        }else{
            return redirect('/member_dashboard');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    protected function loggedOut(Request $request) {
        return redirect('/login');
    }
}
