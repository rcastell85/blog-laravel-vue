<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostEditRequest;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Http\Resources\PostCollection;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 2)
                    ->orderBy('id', 'DESC')
                    ->paginate(6);
        return PostCollection::make($posts);
    }

    
    public function store(PostRequest $request)
    {
        try {
            $post = DB::transaction(function () use($request) {
                $post = Post::create(  $request->all() );

                if($request->hasFile('image')){
                   // $url = Storage::put('posts', $request->file('image'));
                    $url = $request->file('image')->store('posts', 'public');
                    $post->image()->create([
                        'url' => $url
                    ]);
                }

                return $post;
            });
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $post;
    }

    public function show($id)
    {
        //
    }

    public function update(PostEditRequest $request, Post $post)
    {
        try {
            $post = DB::transaction(function () use($request, $post) {

                $post->update( $request->all() );

                if($request->hasFile('image')){
                    $url = $request->file('image')->store('posts', 'public');

                    if($post->image){
                        Storage::disk('public')->delete($post->image->url);
                        $post->image->update([
                            'url' => $url
                        ]);
                    }
                }

                return $post;
            });
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $post;
    }

    public function destroy(Post $post)
    {
        $post->delete();
    }

    public function myPosts($id){
        $posts = Post::orderBy('id', 'DESC')
                    ->where('user_id', $id)
                    ->paginate(10);
        
        return PostCollection::make($posts);    
    }
}
