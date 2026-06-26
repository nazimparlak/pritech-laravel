<?php
<nav class="bg-gray-800 border-b border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center gap-8">
                <a href="{{ route('projects.index') }}" class="flex items-center gap-2 font-bold text-lg text-white tracking-tight">
                    <span class="text-indigo-500">⚡</span> IssueTracker
                </a>

                <div class="flex items-center gap-4">
                    <a href="{{ route('projects.index') }}"
                       class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('projects.*') ? 'bg-gray-900 text-white border border-gray-700' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
Projects
                    </a>
                    <a href="{{ route('issues.index') }}"
                       class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('issues.*') ? 'bg-gray-900 text-white border border-gray-700' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
Issues
                    </a>
                </div>
            </div>

            <div class="text-xs text-gray-400 bg-gray-900/50 px-3 py-1.5 rounded border border-gray-700/50">
Workspace: Team Dev
</div>
        </div>
    </div>
</nav>
