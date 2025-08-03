<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Http\Traits\ApiTraits;
use App\Models\Tag;

class TagController extends Controller
{
    use ApiTraits;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::all();
        return $this->showData($tags);  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagRequest $request)
    {
        $validated = $request->validated();
        $tag = Tag::create($validated);
        return $this->success('Tag created successfully', $tag, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        if ($tag) {
            return $this->showData($tag);
        }else {
            return $this->noData();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagRequest $request, Tag $tag)
    {
        $validated = $request->validated();
        $tag->update($validated);
        return $this->success('Tag updated successfully', $tag);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return $this->success('Tag deleted successfully');
    }
}
