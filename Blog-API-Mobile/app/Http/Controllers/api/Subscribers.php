<?php

namespace App\Http\Controllers\api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubscriberRequest;
use App\Http\Resources\SubscribersResource;
use App\Models\Subscriber;

class Subscribers extends Controller
{

    // create new subscriber
    public function store(StoreSubscriberRequest $request)
    {

        // make validation
        $data = $request->validated();

        // create new subscriber
        $subscriber =  Subscriber::create($data);

        // return
        return ApiResponse::response(201, 'Subscriber created successfully', []);
    }


    // display all subscriber

    public function index() {
        $subscribers = Subscriber::all();
        return ApiResponse::response(200, 'Subscribers', SubscribersResource::collection($subscribers));
    }
}
