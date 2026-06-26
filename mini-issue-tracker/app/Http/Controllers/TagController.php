<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Issue;

class TagController extends Controller
{
    /**
     * Return all tags as JSON (for AJAX).
     */
    public function index()
    {
        $tags = Tag::orderBy('name')->get();
        return response()->json($tags);
    }

    /**
     * Create a new tag (AJAX).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:50|unique:tags,name',
            'color' => 'required|string|max:7',
        ]);

        $tag = Tag::create($validated);

        return response()->json($tag, 201);
    }

    /**
     * Attach or detach a tag from an issue (toggle via AJAX).
     */
    public function toggleTag(Request $request, Issue $issue)
    {
        $request->validate([
            'tag_id' => 'required|exists:tags,id',
        ]);

        $issue->tags()->toggle($request->tag_id);

        return response()->json([
            'attached' => $issue->tags()->where('tag_id', $request->tag_id)->exists(),
            'tags'     => $issue->tags()->get(),
        ]);
    }
}
