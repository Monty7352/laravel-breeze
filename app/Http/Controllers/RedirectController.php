<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedirectController extends Controller
{
    //
    public function redirectuser(){
        if(auth()->user()->hasRole('super-admin')){
            return redirect()->route('superadmin.dashboard');
        }
        elseif(auth()->user()->hasRole('manager')){
            return redirect()->route('manager.dashboard');
        }
        elseif(auth()->user()->hasRole('user')){
            return redirect()->route('user.dashboard');
        }
      
        

    }
}
