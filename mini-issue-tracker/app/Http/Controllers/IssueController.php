<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $issues = Issue::with(['project', 'tags'])->latest()->paginate(20);
        return view('issues.index', compact('issues'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $projects = Project::orderBy('name')->get();
        $tags     = Tag::orderBy('name')->get();
        $selectedProjectId = $request->query('project_id');

        return view('issues.create', compact('projects', 'tags', 'selectedProjectId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id'  => 'required|exists:projects,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:open,in_progress,closed',
            'priority'    => 'required|in:low,medium,high',
            'due_date'    => 'nullable|date',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
        ]);

        $issue = Issue::create($validated);

        if (!empty($validated['tags'])) {
            $issue->tags()->sync($validated['tags']);
        }

        return redirect()
            ->route('projects.show', $validated['project_id'])
            ->with('success', 'Issue created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $issue = Issue::with(['project', 'tags', 'comments'])->findOrFail($id);
        $tags  = Tag::orderBy('name')->get();

        return view('issues.show', compact('issue', 'tags'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $issue    = Issue::with('tags')->findOrFail($id);
        $projects = Project::orderBy('name')->get();
        $tags     = Tag::orderBy('name')->get();

        return view('issues.edit', compact('issue', 'projects', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $issue = Issue::findOrFail($id);

        $validated = $request->validate([
            'project_id'  => 'required|exists:projects,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:open,in_progress,closed',
            'priority'    => 'required|in:low,medium,high',
            'due_date'    => 'nullable|date',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
        ]);

        $issue->update($validated);
        $issue->tags()->sync($validated['tags'] ?? []);

        return redirect()
            ->route('issues.show', $issue->id)
            ->with('success', 'Issue updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $issue = Issue::findOrFail($id);
        $projectId = $issue->project_id;
        $issue->delete();

        return redirect()
            ->route('projects.show', $projectId)
            ->with('success', 'Issue deleted successfully.');
    }
}
