@extends('layouts.app')

@section('title', $project->name . ' - Project Details')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-gray-800 pb-6">
            <div>
                <a href="{{ route('projects.index') }}" class="text-xs text-indigo-400 hover:underline">← Back to Projects</a>
                <h1 class="text-3xl font-extrabold text-white mt-2">{{ $project->name }}</h1>
                <p class="text-sm text-gray-400 mt-2 max-w-3xl">{{ $project->description ?? 'No description provided for this project.' }}</p>
            </div>
            <div class="flex items-center gap-3 self-start md:self-auto">
                <a href="{{ route('projects.edit', $project->id) }}" class="px-3.5 py-2 bg-gray-800 hover:bg-gray-700 border border-gray-700 text-sm font-medium rounded-lg text-gray-300 transition">
                    Edit Project
                </a>
            </div>
        </div>

        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-white tracking-tight">Project Issues ({{ $project->issues->count() }})</h2>
                <a href="{{ route('issues.create', ['project_id' => $project->id]) }}" class="inline-flex items-center justify-center px-3.5 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold rounded-lg transition">
                    + Create Issue
                </a>
            </div>

            @if($project->issues->isEmpty())
                <div class="text-center py-12 bg-gray-800/50 rounded-xl border border-gray-700/50">
                    <span class="text-2xl">🎯</span>
                    <p class="text-gray-400 mt-2 text-sm">All clear! No issues found under this project.</p>
                </div>
            @else
                <div class="bg-gray-800/40 border border-gray-700/50 rounded-xl divide-y divide-gray-700/50 overflow-hidden">
                    @foreach($project->issues as $issue)
                        <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-gray-800/80 transition">
                            <div class="space-y-2">
                                <div class="flex items-center flex-wrap gap-2">
                                <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded border
                                    {{ $issue->priority === 'high' ? 'bg-rose-950/60 border-rose-800 text-rose-400' : '' }}
                                    {{ $issue->priority === 'medium' ? 'bg-amber-950/60 border-amber-800 text-amber-400' : '' }}
                                    {{ $issue->priority === 'low' ? 'bg-slate-900 border-slate-700 text-slate-400' : '' }}">
                                    {{ $issue->priority }}
                                </span>

                                    <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded
                                    {{ $issue->status === 'closed' ? 'bg-emerald-950 text-emerald-400' : 'bg-indigo-950 text-indigo-400' }}">
                                    {{ str_replace('_', ' ', $issue->status) }}
                                </span>

                                    <h3 class="text-base font-semibold text-white hover:text-indigo-400 transition ml-1">
                                        <a href="{{ route('issues.show', $issue->id) }}">{{ $issue->title }}</a>
                                    </h3>
                                </div>

                                @if($issue->tags->isNotEmpty())
                                    <div class="flex flex-wrap gap-1.5 pt-1">
                                        @foreach($issue->tags as $tag)
                                            <span class="px-2 py-0.5 rounded text-[11px] font-medium border"
                                                  style="background-color: {{ $tag->color }}15; border-color: {{ $tag->color ?? '#4f46e5' }}; color: {{ $tag->color ?? '#9ca3af' }};">
                                            #{{ $tag->name }}
                                        </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center justify-between sm:justify-end gap-6 border-t border-gray-700/30 sm:border-t-0 pt-3 sm:pt-0">
                                @if($issue->due_date)
                                    <div class="text-right sm:block hidden">
                                        <span class="block text-[10px] uppercase text-gray-500 tracking-wider">Due Date</span>
                                        <span class="text-xs font-medium text-gray-300">{{ \Carbon\Carbon::parse($issue->due_date)->format('d.m.Y') }}</span>
                                    </div>
                                @endif
                                <a href="{{ route('issues.show', $issue->id) }}" class="px-3 py-1.5 bg-gray-900 hover:bg-gray-700 border border-gray-700 text-xs font-medium rounded-md text-gray-300 transition">
                                    View Detail →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
