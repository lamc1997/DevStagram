<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    use AuthorizesRequests;
    use ValidatesRequests;
}

class LoginController extends Controller
{
    //
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {

        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required',

        ]);

        //Auth::attempt($request->only('email','password'))

        if(!Auth::attempt($request->only('email','password'),$request->remember))
        
        {
            return back()->with('mensaje','Credenciales Incorrectas');

        }

        return redirect()->route('posts.index', ['user' => $request->user()->username]);


        
    }

}
