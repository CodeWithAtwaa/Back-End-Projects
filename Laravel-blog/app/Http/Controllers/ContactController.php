<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactStoreREq;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(ContactStoreREq $request)
    {
        $data = $request->validated();
        Contact::create($data);
        return redirect()->back()->with('success', 'Your Message Send successfully!');
    }
}
