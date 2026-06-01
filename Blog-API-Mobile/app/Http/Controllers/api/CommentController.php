<?php

namespace App\Http\Controllers\api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comments;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comments::paginate(5);
        if (!$comments)
            return ApiResponse::response(402, "Ther is no Comments ", []);
        return ApiResponse::response(200, " Show All Comments", CommentResource::collection($comments));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        // make validation
        $data = $request->validated();

        // store in DB
        $comment = Comments::create($data);

        if (! $comment)
            return ApiResponse::response(402, "cann't create your comment", []);
        return ApiResponse::response(201, "Created Comments Successfully!", new CommentResource($comment));
    }
}
