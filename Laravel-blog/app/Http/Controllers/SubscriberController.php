<?php

namespace App\Http\Controllers;

use App\Models\subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|unique:subscribers,email',
        ]);

        Subscriber::create($data);

        return redirect()->back()->with('success', 'Subscribed successfully!');
    }
}
