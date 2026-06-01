<?php

namespace App\Http\Controllers\api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreContactRequest $request)
    {

        // make Validation
        $data = $request->validated();

        // create new contact
        $contact = Contact::create($data);

        // return reponse
        if (!$contact) {
            return ApiResponse::response(500, "Add Contact Failed");
        }
        return ApiResponse::response(200, "Add Contact Success", []);
    }
}
