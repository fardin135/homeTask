<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Traits\ApiTraits;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    use ApiTraits;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allProjects = Auth::user()->projects;
        return $this->showData($allProjects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
        $validated = $request->validated();
        $project = Auth::user()->projects()->create($validated);
        $project->tags()->attach($request->tags);
        return $this->success('Project created successfully', $project->load('tags'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            return $this->error('Unauthorized access to project', 403);
        }
        return $this->showData($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            return $this->error('Unauthorized access to update project', 403);
        }

        $project->update($request->validated());
        return $this->success('Project updated successfully', $project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            return $this->error('Unauthorized access to delete project', 403);
        }

        $project->delete();
        return $this->success('Project deleted successfully');
    }
}
