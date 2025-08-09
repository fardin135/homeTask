<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiTraits;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    use ApiTraits;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        // dd($user->projects->load('tasks'));
        // dd($user->projects->tasks);
        if ($user->projects()->exists()) {
            return $this->showData($user->projects->load('tasks'));
        }
        
        return $this->error('Unauthorized', 403);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'status' => 'in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
        ]);

        $project = Auth::user()->projects()->findOrFail($request->project_id);

        $task = $project->tasks()->create([
            'title' => $request->title,
            'status' => $request->status ?? 'pending',
            'due_date' => $request->due_date,
        ]);

        return $this->showData($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        // dd($task->project->user_id , Auth::id());
        if ($task->project->user_id == Auth::id() ) {
            return $this->showData($task);
        } else {
            return $this->error('Unauthorized', 403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        if ($task->project->user_id == Auth::id()) {
            $validated = $request->validate([
                'title' => 'nullable|string|max:255',
                'status' => 'in:pending,in_progress,completed',
                'due_date' => 'nullable|date',
            ]);
    
            $task->update($validated);
            return $this->success('Task updated', $task);
        } 
        return $this->error('Unauthorized', 403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if ($task->project->user_id == Auth::id()) {
            $task->delete();
            return $this->success('Task deleted');
        }
        return $this->error('Unauthorized', 403);
    }
}
