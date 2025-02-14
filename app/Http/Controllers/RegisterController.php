<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;   

abstract class Controller
{
    use AuthorizesRequests;
    use ValidatesRequests;
}

class RegisterController extends Controller
{
    //
    public function index() {
        return view('auth.register');
    }

    public function store(Request $request)
    {
      $this->validate($request,[
        'name' => 'required|max:20',
        'username' => 'required|unique:users|min:3|max:20',
        'email' => 'required|unique:users|email|max:60',
        'password' => 'required|confirmed|min:6',
      ]);

      User::create([
        'name' => $request->name,
        'username' => Str::slug($request->username),
        'email' => $request->email,
        'password' => Hash::make($request->password)

      ]);

      //autenticar un usuario 
      Auth::attempt($request->only('email','password'));

      /*auth()->Auth::attempt([
        'email' => $request->email,
         'password' => $request->password
      ]);*/

      return redirect()->route('posts.index', ['user' => $request->user()->username]);
      
      
    }
}
