<?php

namespace App\Http\Controllers;

use App\Models\TransferRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Show all transfer requests
    public function dashboard()
    {
        $requests = TransferRequest::with(['student', 'fromDepartment', 'toDepartment'])->latest()->get();
        return view('admin.dashboard', compact('requests'));
    }

    // Update request status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $transfer = TransferRequest::findOrFail($id);
        $transfer->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Request status updated successfully.');
    }



    // Show admin user management page
    public function manageUsers()
    {
        $users = User::all();
        return view('admin.manage_users', compact('users'));
    }

    // Store new user
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:student,reviewer,admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'User has been created successfully.');
    }

public function deleteUser($id)
{
    $user = User::findOrFail($id);

    // Prevent deleting self or any other admin
    if ($user->id == auth()->id() || $user->role === 'admin') {
        return redirect()->back()->with('error', 'You cannot delete this user!');
    }

    $user->delete();

    return redirect()->back()->with('success', 'User deleted successfully.');
}


}
