<?php

namespace App\Http\Controllers;

use App\Models\TransferRequest;
use Illuminate\Http\Request;

class ReviewerController extends Controller
{
    // Show all transfer requests for review
    public function dashboard()
    {
        $requests = TransferRequest::with(['student', 'fromDepartment', 'toDepartment'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('reviewer.dashboard', compact('requests'));
    }

    // Approve request
    public function approve($id)
    {
        $request = TransferRequest::findOrFail($id);
        $request->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Request has been approved.');
    }

    // Reject request
    public function reject($id)
    {
        $request = TransferRequest::findOrFail($id);
        $request->update(['status' => 'rejected']);

        return redirect()->back()->with('error', 'Request has been rejected.');
    }
}
