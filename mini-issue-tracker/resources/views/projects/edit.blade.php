@extends('layouts.app')

@section('title', 'Edit Project')

@section('content')
    <div class="max-w-2xl mx-auto bg-gray-800 border border-gray-700/60 rounded-xl p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-bold text-white">Edit Project</h1>

            <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this project and all its issues?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs text-rose-400 hover:text-rose-300 underline">Delete Project</button>
            </form>
        </div>

        <form action="{{ route('projects.update', $project->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Project Name</label>
                <input type="text" name="name" value="{{ old('name', $project->name) }}" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-indigo-500">
                @error('name') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Description</label>
                <textarea name="description" rows="4" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-indigo-500">{{ old('description', $project->description) }}</textarea>
                @error('description') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date', $project->start_date) }}" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-indigo-500">
                    @error('start_date') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Deadline</label>
                    <input type="date" name="deadline" value="{{ old('deadline', $project->deadline) }}" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-indigo-500">
                    @error('deadline') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-700/50 mt-6">
                <a href="{{ route('projects.show', $project->id) }}" class="px-4 py-2 bg-gray-900 hover:bg-gray-700 text-sm font-medium rounded-lg text-gray-300 transition">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg transition">Update Project</button>
            </div>
        </form>
    </div>
@endsection
