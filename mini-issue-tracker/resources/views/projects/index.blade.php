@extends('layouts.app')

@section('title', 'Projects - Mini Issue Tracker')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-white">Projects</h1>
                <p class="text-sm text-gray-400 mt-1">Manage your team's active projects and track progress.</p>
            </div>
            <a href="{{ route('projects.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold rounded-lg shadow transition">
                + New Project
            </a>
        </div>

        @if($projects->isEmpty())
            <div class="text-center py-12 bg-gray-800 rounded-xl border border-gray-700/60">
                <span class="text-3xl">📁</span>
                <p class="text-gray-400 mt-2 text-sm">No projects found. Create one to get started!</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($projects as $project)
                    <div class="bg-gray-800 border border-gray-700/60 rounded-xl p-6 flex flex-col justify-between hover:border-gray-600 transition shadow-sm">
                        <div>
                            <div class="flex items-start justify-between gap-4">
                                <h2 class="text-lg font-bold text-white line-clamp-1 hover:text-indigo-400 transition">
                                    <a href="{{ route('projects.show', $project->id) }}">{{ $project->name }}</a>
                                </h2>
                                <span class="px-2.5 py-1 bg-gray-900 border border-gray-700 text-xs font-medium rounded-full text-gray-300 whitespace-nowrap">
                                {{ $project->issues_count }} Issues
                            </span>
                            </div>
                            <p class="text-sm text-gray-400 mt-2 line-clamp-3">
                                {{ $project->description ?? 'No description provided.' }}
                            </p>
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-700/50 grid grid-cols-2 gap-2 text-xs text-gray-400">
                            <div>
                                <span class="block text-[10px] uppercase tracking-wider text-gray-500">Start Date</span>
                                <span class="font-medium text-gray-300">{{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d.m.Y') : '-' }}</span>
                            </div>
                            <div>
                                <span class="block text-[10px] uppercase tracking-wider text-gray-500">Deadline</span>
                                <span class="font-medium text-gray-300 {{ $project->deadline && \Carbon\Carbon::parse($project->deadline)->isPast() ? 'text-rose-400' : '' }}">
                                {{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('d.m.Y') : '-' }}
                            </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
