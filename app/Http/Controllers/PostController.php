<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    $posts = Post::where('user_id',Auth::user()->id)
                    ->orderBy('titolo')
                    ->get();
    return view('posts.index',compact('posts'));
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'titolo' => 'required|max:255',
            'testo' => 'required',
            'immagine'=>'mimes:jpeg'
           
        ]);
    $post = new Post;
    $post->titolo = $request->titolo;
    $post->testo = $request->testo;
    $post->user_id = Auth::user()->id;
    
    $post->save();
    $request->immagine->move(public_path('images'),$post->id . ".jpg");
  
    return redirect('/posts');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
   $post = Post::find($id);
   return view('posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    $post = Post::find($id);
    
    return view('posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    $post = Post::find($id);
    $post->titolo = $request->titolo;
    $post->testo = $request->testo;
    $post->save();
    return redirect('/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    $post = Post::find($id);
    $post->delete();
    return redirect('/posts');
    }
}
