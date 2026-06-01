<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskCreate;
use App\Http\Requests\TaskUpdate;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $tasks = Auth::user()->tasks;
        return view('home', compact('tasks'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(TaskCreate $request)
    {
        Task::create(array_merge(
            $request->validated(),
            ['user_id' => auth()->id()]
        ));
        return redirect()->route('home')->with('success', 'Created Successfull!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($task->user_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بعرض هذه المهمة');
        }

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */public function update(TaskUpdate $request, Task $task)
{
    $task->update(array_merge(
        $request->validated(),
        ['user_id' => auth()->id()]
    ));

    return redirect()->route('home')->with('success', 'Updated Successfully!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($task->user_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بعرض هذه المهمة');
        }

        $task->delete();
        return redirect()->route('home')->with('sucess', "Deleted Successfully!");
    }



    public function toggleComplete(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

        $task->is_completed = !$task->is_completed;
        $task->save();

        return response()->json([
            'success' => true,
            'completed' => $task->is_completed,
        ]);
    }

}
