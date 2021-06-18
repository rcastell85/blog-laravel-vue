<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(isset($this->image)){
            $url = Storage::url($this->image->url);
        } else {
            $url = 'https://cdn.pixabay.com/photo/2020/12/15/13/44/children-5833685_960_720.jpg';
        }

        return [
            'id' => $this->getRouteKey(),
            'title' => $this->title,
            'extract' => Str::limit($this->content, 50),
            'content' => $this->content,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'updated_at' => $this->updated_at,
            'image' => [
                'url' => $url
            ]
        ];
    }
}
