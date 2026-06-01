<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlog;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::check()) {
            $categories = Category::get();
            return view('theme.blog.create', ['categories' => $categories]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        $data = $request->validated();
        //1- image get
        $image = $request->image;
        // 2- change the name
        $nameImage = time() . '-' . $image->getClientOriginalName();  //20255465-index.png
        //3- move in project
        //               folder   name new     in storage
        $image->storeAs('blogs', $nameImage, 'public');
        // 4- save
        $data['image'] = $nameImage;

        $data['user_id'] = Auth::user()->id;

        // Create new blog
        Blog::create($data);


        return back()->with('success', 'Created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return view('theme.single-blog', ['blog' => $blog]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {

        if ($blog->user_id == Auth::user()->id) {
            $categories = Category::get();
            return view('theme.blog.edit', ['categories' => $categories, 'blog' => $blog]);
        }
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateBlog $request, Blog $blog)
    {

        if ($blog->user_id == Auth::user()->id) {
            $data = $request->validated();
            // Check if a new image was uploaded
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $nameImage = time() . '-' . $image->getClientOriginalName();

                // Save new image
                $image->storeAs('blogs', $nameImage, 'public');

                // Delete old image if it exists
                if ($blog->image && Storage::disk('public')->exists('blogs/' . $blog->image)) {
                    Storage::disk('public')->delete('blogs/' . $blog->image);
                }

                // Save new image name
                $data['image'] = $nameImage;
            }
            // Update user_id (optional)
            $data['user_id'] = Auth::id();
            // Update existing blog
            $blog->update($data);
            return back()->with('success', 'Updated successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if ($blog->user_id == Auth::user()->id) {
            Storage::delete("public/blogs/$blog->image");
            $blog->delete();
            return back()->with('success', 'Deleted successfully!');
        }
        abort(403);
    }

    // Dispaly al user blog
    public function myBlogs()
    {

        if (Auth::check()) {
            $blogs = Blog::where('user_id', Auth::user()->id)->paginate(10);
            return view('theme.blog.my-blogs', ['blogs' => $blogs]);
        }
        abort(403);
    }
}
