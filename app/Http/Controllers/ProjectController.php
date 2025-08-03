<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        // $project = Auth::user()->projects()->create($validated);
        // return $this->success('Project created successfully', $project, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
