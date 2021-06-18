<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostObserver
{
    public function deleting(Post $post)
    {
        try {
            if($post->image){
                //Storage::delete($post->image->url);
                Storage::disk('public')->delete($post->image->url);
                $post->image->delete();
            }
        } catch (\Exception $e) {
           return $e->getMessage();
       }
    }
}
