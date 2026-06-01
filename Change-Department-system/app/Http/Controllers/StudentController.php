<?php

namespace App\Http\Controllers;

use App\Models\TransferRequest;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    // Student Dashboard
    public function dashboard()
    {
        $requests = TransferRequest::where('student_id', Auth::id())->with(['fromDepartment', 'toDepartment'])->get();
        return view('student.dashboard', compact('requests'));
    }

    // Show form
    public function createRequest()
    {
        $departments = Department::all();
        return view('student.request_create', compact('departments'));
    }

    // Save the request
    public function storeRequest(Request $request)
    {
        $request->validate([
            'from_department' => 'required|exists:departments,id',
            'to_department' => 'required|exists:departments,id|different:from_department',
            'reason' => 'required|string|max:500',
        ]);

        TransferRequest::create([
            'student_id' => Auth::id(),
            'from_department_id' => $request->from_department,
            'to_department_id' => $request->to_department,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('student.dashboard')
            ->with('success', 'Your transfer request has been submitted successfully.');
    }




    // Delete the request
    public function destroyRequest($id)
    {
        $request = TransferRequest::where('student_id', auth()->id())
            ->where('status', 'pending')
            ->findOrFail($id);

        $request->delete();

        return redirect()
            ->route('student.dashboard')
            ->with('success', 'Your transfer request has been deleted successfully.');
    }
}
