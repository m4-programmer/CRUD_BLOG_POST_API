<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'description'=>$this->description,
            'blog_id'=>$this->blog_id,
            'blog_title'=>$this->blog->title,
            'logo'=>asset($this->logo),
            'slug'=>$this->slug,
            "likes"=> $this->likes->count(),
            "comments"=>$this->comments,
            'created_at'=>$this->created_at,
        ];
    }
}
