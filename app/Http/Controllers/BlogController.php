<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::orderBy('created_at','desc')->get();
        return $this->success($blogs);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data  = $request->validate([
            'title'=>'required|unique:blogs,title',
        ]);
        $data['slug'] = Str::slug($data['title']);
        $result = Blog::create($data);
        return $this->success($result,"",201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        $data = [
            'title'=>$blog->title,
            'total_posts'=>$blog->posts->count(),
            'posts'=>$blog->posts
        ];
        return $this->success($data);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $data  = $request->validate([
            'title'=>'required|unique:blogs,title,'.$blog->id,
        ]);
        $data['slug'] = Str::slug($data['title']);
        $blog->update($data);
        $blog->refresh();
        return $this->success($blog);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return $this->success([],"", 204);
    }
}
