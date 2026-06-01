<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComments;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(StoreComments $request)
    {
        $data = $request->validated();
        Comment::create($data);
        return back()->with('Created', 'Your comment was published successfully!');
    }

    
}
