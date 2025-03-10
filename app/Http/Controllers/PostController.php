<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request; 

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
 
 
 
abstract class Controller
{
    use AuthorizesRequests;
    use ValidatesRequests;
}

class PostController extends Controller
{
    

    public function index(User $user) 
    {
        $posts = Post::where('user_id', $user->id)->get();



        return view('dashboard',[
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return view(('posts.create'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required',

        ]);

       /* Post::create([
            'titulo' => $request->titulo,
            'descripcion'=> $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => $request->user()->id,

        ]);*/

        //Otro forma de registrar 
        /*
        $post = new Post; 
        $post->titulo = $request->titulo;
        $post->descripcion = $request->descripcion;
        $post->imagen = $request->imagen;
        $post->user_id = $request->user()->id;
        $post->save();
        */

        //GUARDAR EN BASE YA OCUPANDO LAS RELACIONES ELOQUENT


        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion'=> $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => $request->user()->id
        ]);


        return redirect()->route('posts.index',['user' => $request->user()->username]);

    }

}

