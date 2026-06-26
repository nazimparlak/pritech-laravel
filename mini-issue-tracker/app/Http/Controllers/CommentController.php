<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Issue;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Return comments for an issue as JSON (AJAX).
     */
    public function index(Issue $issue)
    {
        $comments = $issue->comments()->latest()->get();
        return response()->json($comments);
    }

    /**
     * Store a new comment for an issue (AJAX).
     */
    public function store(Request $request, Issue $issue)
    {
        $validated = $request->validate([
            'author_name' => 'required|string|max:100',
            'body'        => 'required|string|max:2000',
        ]);

        $comment = $issue->comments()->create($validated);

        return response()->json($comment, 201);
    }
}
