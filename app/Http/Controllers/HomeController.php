<?php

namespace App\Http\Controllers;

use App\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
     {
         $this->middleware('auth')->only(['index', 'complete_user_profile', 'store_user_profile']);
     }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $assignedLocation = \App\Restaurant::where('host_id', '=', Auth::user()->id)->first();
        if ($user){
            if ($user->hasRole('admin')){
                return redirect()->to('/toffee-admin');
            }
            elseif ($user->hasRole('host') && $assignedLocation)
            {
                return redirect()->to('/toffee-host');
            }
            else{
                return redirect()->to('/member_dashboard');
            }
        }else{
            return redirect()->to('/login');
        }
        //return view('home');
    }

    public function complete_user_profile()
    {
        return view('Users.complete-profile-form');
    }

    public function store_user_profile(Request $request){

        $user_id = Auth::user()->id;
        $location = $request->input('location');
        $grind = $request->input('grind');
        $info_source= $request->input('info_source');
        $profile = new UserProfile([
            'user_id' => $user_id,
            'location' => $location,
            'grind' => $grind,
            'info_source' => $info_source,
        ]);

        $profile->save();
        return redirect()->route('member.index');
    }
    
  public function karel(){
        return view('Check-In.karel-checkin');
    }
    public function lava(){
        return view('Check-In.lava-checkin');
    }
    public function connect(){
        return view('Check-In.connect-checkin');
    }
    public function zion(){
        return view('Check-In.zion-checkin');
    }
    public function chez(){
        return view('Check-In.chez-checkin');
    }
    //temporary
     public function toffeebreakfast(){
        return view('Check-In.toffeebreakfast');
    }
    public function chekafe(){
        return view('Check-In.chekafe');
    }
    public function ate(){
        return view('Check-In.ate');
    }
    public function coffee_casa(){
        return view('Check-In.coffee_casa');
    }
}
