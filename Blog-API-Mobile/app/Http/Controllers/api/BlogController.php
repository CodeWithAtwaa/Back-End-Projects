<?php

namespace App\Http\Controllers\api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::paginate(5);
        return ApiResponse::response(200, 'Blogs Retrieved Successfully', BlogResource::collection($blogs));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        // dd($request->all());
        // make vlidation
        $data = $request->validated();

        // authenticated user
        $data['user_id'] = auth()->id();

        // 1. get image
        $image = $request->file('image');

        // 2. change its current name
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        // 3. move to public folder
        $image->storeAs('blogs', $imageName, 'public');

        // 4. save new name to DB
        $data['image'] = $imageName;

        // store in DB
        $blog = Blog::create($data);

        if ($blog)
            return ApiResponse::response(201, 'Blog Created Successflly!', new BlogResource($blog));

        return ApiResponse::response(403, "can't be created", []);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        if (!$blog) {
            return ApiResponse::response(404, 'Blog Not Found', []);
        }

        return ApiResponse::response(200, 'Success', new BlogResource($blog));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBlogRequest $request, Blog $blog)
    {
        $data = $request->validated();

        // check if new image uploaded
        if ($request->hasFile('image')) {

            // delete old image if exists
            if ($blog->image && file_exists(storage_path('app/public/blogs/' . $blog->image))) {
                unlink(storage_path('app/public/blogs/' . $blog->image));
            }

            // upload new image
            $image = $request->file('image');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('blogs', $imageName, 'public');

            $data['image'] = $imageName;
        }

        // update blog
        $blog->update($data);

        return ApiResponse::response(
            200,
            'Blog Updated Successfully!',
            new BlogResource($blog)
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        // delete image from storage (if exists)
        if ($blog->image && file_exists(storage_path('app/public/blogs/' . $blog->image))) {
            unlink(storage_path('app/public/blogs/' . $blog->image));
        }

        // delete blog from DB
        $blog->delete();

        return ApiResponse::response(
            200,
            'Blog Deleted Successfully!',
            []
        );
    }
}
