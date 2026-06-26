@extends('layouts.app')

@section('title', 'Create Project')

@section('content')
    <div class="max-w-2xl mx-auto bg-gray-800 border border-gray-700/60 rounded-xl p-6 shadow-sm">
        <h1 class="text-xl font-bold text-white mb-6">Create New Project</h1>

        <form action="{{ route('projects.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Project Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-indigo-500">
                @error('name') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Description</label>
                <textarea name="description" rows="4" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-indigo-500">{{ old('description') }}</textarea>
                @error('description') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-indigo-500">
                    @error('start_date') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Deadline</label>
                    <input type="date" name="deadline" value="{{ old('deadline') }}" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-indigo-500">
                    @error('deadline') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-700/50 mt-6">
                <a href="{{ route('projects.index') }}" class="px-4 py-2 bg-gray-900 hover:bg-gray-700 text-sm font-medium rounded-lg text-gray-300 transition">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg transition">Save Project</button>
            </div>
        </form>
    </div>
@endsection
