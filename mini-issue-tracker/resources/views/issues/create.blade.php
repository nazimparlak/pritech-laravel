@extends('layouts.app')

@section('title', 'Create Issue')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ $selectedProjectId ? route('projects.show', $selectedProjectId) : route('projects.index') }}"
           class="text-xs text-indigo-400 hover:underline">← Back</a>
        <h1 class="text-2xl font-extrabold text-white mt-2">Create New Issue</h1>
    </div>

    <form action="{{ route('issues.store') }}" method="POST"
          class="bg-gray-800/50 border border-gray-700/50 rounded-xl p-6 space-y-5">
        @csrf

        {{-- Project --}}
        <div>
            <label for="project_id" class="block text-sm font-medium text-gray-300 mb-1.5">Project</label>
            <select id="project_id" name="project_id" required
                    class="w-full bg-gray-900 border border-gray-700 text-gray-200 text-sm rounded-lg px-3 py-2.5 outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ (old('project_id', $selectedProjectId) == $project->id) ? 'selected' : '' }}>
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>
            @error('project_id') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Title --}}
        <div>
            <label for="title" class="block text-sm font-medium text-gray-300 mb-1.5">Title</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                   placeholder="Issue title..."
                   class="w-full bg-gray-900 border border-gray-700 text-gray-200 text-sm rounded-lg px-3 py-2.5 outline-none focus:ring-indigo-500 focus:border-indigo-500 placeholder-gray-500">
            @error('title') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="block text-sm font-medium text-gray-300 mb-1.5">Description</label>
            <textarea id="description" name="description" rows="4"
                      placeholder="Describe the issue..."
                      class="w-full bg-gray-900 border border-gray-700 text-gray-200 text-sm rounded-lg px-3 py-2.5 outline-none focus:ring-indigo-500 focus:border-indigo-500 placeholder-gray-500 resize-none">{{ old('description') }}</textarea>
        </div>

        {{-- Status & Priority --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="status" class="block text-sm font-medium text-gray-300 mb-1.5">Status</label>
                <select id="status" name="status"
                        class="w-full bg-gray-900 border border-gray-700 text-gray-200 text-sm rounded-lg px-3 py-2.5 outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="open"        {{ old('status') === 'open'        ? 'selected' : '' }}>Open</option>
                    <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="closed"      {{ old('status') === 'closed'      ? 'selected' : '' }}>Closed</option>
                </select>
            </div>
            <div>
                <label for="priority" class="block text-sm font-medium text-gray-300 mb-1.5">Priority</label>
                <select id="priority" name="priority"
                        class="w-full bg-gray-900 border border-gray-700 text-gray-200 text-sm rounded-lg px-3 py-2.5 outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="low"    {{ old('priority') === 'low'    ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ old('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high"   {{ old('priority') === 'high'   ? 'selected' : '' }}>High</option>
                </select>
            </div>
        </div>

        {{-- Due Date --}}
        <div>
            <label for="due_date" class="block text-sm font-medium text-gray-300 mb-1.5">Due Date <span class="text-gray-500">(optional)</span></label>
            <input type="date" id="due_date" name="due_date" value="{{ old('due_date') }}"
                   class="w-full bg-gray-900 border border-gray-700 text-gray-200 text-sm rounded-lg px-3 py-2.5 outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        {{-- Tags --}}
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Tags <span class="text-gray-500">(optional)</span></label>
            <div class="flex flex-wrap gap-2">
                @foreach($tags as $tag)
                    <label class="inline-flex items-center gap-1.5 cursor-pointer">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                               {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
                               class="accent-indigo-500">
                        <span class="text-xs font-medium px-2 py-0.5 rounded border"
                              style="background-color: {{ $tag->color }}22; border-color: {{ $tag->color }}; color: {{ $tag->color }};">
                            #{{ $tag->name }}
                        </span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-700/50">
            <a href="{{ $selectedProjectId ? route('projects.show', $selectedProjectId) : route('projects.index') }}"
               class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-gray-200 text-sm font-medium rounded-lg transition">
                Cancel
            </a>
            <button type="submit"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold rounded-lg transition">
                Create Issue
            </button>
        </div>
    </form>
</div>
@endsection
