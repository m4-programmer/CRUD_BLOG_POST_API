<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Blog;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Service\ImageService;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public ImageService $imageService;
    public function __construct(){
        $this->imageService = ImageService::getInstance();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $blog_id = $request->query('blog_id');
        if ($blog_id){
            $blog = Blog::find($blog_id);
            $posts =  $blog?->posts ? PostResource::collection($blog->posts) : [];
            return $this->success($posts);
        }
        $posts = Post::orderBy('created_at','desc')->get();
        return $this->success(PostResource::collection($posts));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data  = $request->validate([
            'title'=>'required|unique:posts,title',
            'description'=>'string',
            'blog_id'=>'required|exists:blogs,id',
            'logo'=>'required|image',
        ]);
        $data['slug'] = Str::slug($data['title']);
        $data['logo'] =  $this->imageService->uploadImage($this->imageService->getImage($request, 'logo'), '');
        $result = new PostResource(Post::create($data));
        return $this->success($result,"",201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return $this->success(new PostResource($post));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $data  = $request->validate([
            'title'=>'required|unique:posts,title,'.$post->id,
            'description'=>'string',
            'blog_id'=>'required|exists:blogs,id',
            'logo'=>'nullable'
        ]);
        $data['slug'] = Str::slug($data['title']);
        if ($request->logo){
            $data['logo'] =  $this->imageService->uploadImage($this->imageService->getImage($request, 'logo'), $post->logo);
        }
        $post->update($data);
        $post->refresh();
        return $this->success(new PostResource($post),"",201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return $this->success([],"", 204);
    }

    public function likePost(Request  $request, Post $post)
    {
        $data = $request->validate([
            'user_id'=>'required|exists:users,id',
        ]);
        try {
            $data['post_id'] =  $post->id;
            $post->likes()->create($data);
            return $this->success([], "Post Liked Successfully");
        }catch (UniqueConstraintViolationException $e)
        {
            return $this->success([],"You have liked this already", 200);
        }catch (\Exception $e){
            logger()->error($e->getMessage());
            return $this->error();
        }
    }

    public function comment(Request  $request, Post $post)
    {
        $data = $request->validate([
            'user_id'=>'required|exists:users,id',
            'comment'=>'required|min:3',
        ]);
        $data['post_id'] =  $post->id;
        $result = $post->comments()->create($data);
        return $this->success($result);
    }
}
