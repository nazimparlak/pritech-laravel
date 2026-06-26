@extends('layouts.app')

@section('title', 'All Issues - Mini Issue Tracker')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">All Issues</h1>
            <p class="text-sm text-gray-400 mt-1">Browse all issues across every project.</p>
        </div>
    </div>

    <div class="mb-6">
        <input type="text" id="searchInput" placeholder="Search issues by title or description..." 
               class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500 text-sm">
    </div>

    <div id="issues-container">
        @if($issues->isEmpty())
        <div class="text-center py-12 bg-gray-800 rounded-xl border border-gray-700/60">
            <span class="text-3xl">🎯</span>
            <p class="text-gray-400 mt-2 text-sm">No issues found across any project.</p>
        </div>
    @else
        <div class="bg-gray-800/40 border border-gray-700/50 rounded-xl divide-y divide-gray-700/50 overflow-hidden">
            @foreach($issues as $issue)
                <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-gray-800/80 transition">
                    <div class="space-y-1.5">
                        <div class="flex items-center flex-wrap gap-2">
                            <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded border
                                {{ $issue->priority === 'high'   ? 'bg-rose-950/60 border-rose-800 text-rose-400'   : '' }}
                                {{ $issue->priority === 'medium' ? 'bg-amber-950/60 border-amber-800 text-amber-400' : '' }}
                                {{ $issue->priority === 'low'    ? 'bg-slate-900 border-slate-700 text-slate-400'     : '' }}">
                                {{ $issue->priority }}
                            </span>
                            <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded
                                {{ $issue->status === 'closed'      ? 'bg-emerald-950 text-emerald-400' : '' }}
                                {{ $issue->status === 'in_progress' ? 'bg-blue-950 text-blue-400'       : '' }}
                                {{ $issue->status === 'open'        ? 'bg-indigo-950 text-indigo-400'   : '' }}">
                                {{ str_replace('_', ' ', $issue->status) }}
                            </span>
                            <h2 class="text-base font-semibold text-white hover:text-indigo-400 transition">
                                <a href="{{ route('issues.show', $issue->id) }}">{{ $issue->title }}</a>
                            </h2>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <a href="{{ route('projects.show', $issue->project_id) }}"
                               class="text-indigo-400 hover:underline">{{ $issue->project->name }}</a>
                            @if($issue->tags->isNotEmpty())
                                <span>·</span>
                                @foreach($issue->tags as $tag)
                                    <span class="px-1.5 py-0.5 rounded text-[10px] font-medium"
                                          style="background-color: {{ $tag->color }}22; color: {{ $tag->color }};">
                                        #{{ $tag->name }}
                                    </span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-4 shrink-0">
                        @if($issue->due_date)
                            <div class="text-right hidden sm:block">
                                <span class="block text-[10px] uppercase text-gray-500 tracking-wider">Due</span>
                                <span class="text-xs font-medium {{ \Carbon\Carbon::parse($issue->due_date)->isPast() ? 'text-rose-400' : 'text-gray-300' }}">
                                    {{ \Carbon\Carbon::parse($issue->due_date)->format('d.m.Y') }}
                                </span>
                            </div>
                        @endif
                        <a href="{{ route('issues.show', $issue->id) }}"
                           class="px-3 py-1.5 bg-gray-900 hover:bg-gray-700 border border-gray-700 text-xs font-medium rounded-md text-gray-300 transition">
                            View →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        @endif
    </div>

    {{-- Pagination (Sadece sayfa ilk yüklendiğinde, search yapılınca gizlenecek) --}}
    @if(method_exists($issues, 'links') && $issues->hasPages())
        <div id="pagination-container" class="mt-4">
            {{ $issues->links() }}
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
let timeout = null;
document.getElementById('searchInput').addEventListener('input', function (e) {
    clearTimeout(timeout);
    
    // Debounce: Kullanıcı yazmayı bitirdikten 300ms sonra tetiklenir
    timeout = setTimeout(function () {
        const keyword = e.target.value;
        
        fetch(`{{ route('issues.index') }}?search=${keyword}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('issues-container');
            const pagination = document.getElementById('pagination-container');
            
            if (pagination) {
                // Arama yapılınca pagination'ı gizle, arama boşsa ve data geldiyse gösterilebilir ama 
                // search'ten gelen data pagination'sız (tüm sonuçlar get() ile) olduğu için genelde gizlemek iyidir.
                pagination.style.display = keyword.trim() !== '' ? 'none' : 'block';
            }

            if (data.issues.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-12 bg-gray-800 rounded-xl border border-gray-700/60">
                        <span class="text-3xl">🎯</span>
                        <p class="text-gray-400 mt-2 text-sm">No issues found matching your search.</p>
                    </div>
                `;
            } else {
                let html = '<div class="bg-gray-800/40 border border-gray-700/50 rounded-xl divide-y divide-gray-700/50 overflow-hidden">';
                
                data.issues.forEach(issue => {
                    let priorityBadge = '';
                    if (issue.priority === 'high') priorityBadge = 'bg-rose-950/60 border-rose-800 text-rose-400';
                    else if (issue.priority === 'medium') priorityBadge = 'bg-amber-950/60 border-amber-800 text-amber-400';
                    else if (issue.priority === 'low') priorityBadge = 'bg-slate-900 border-slate-700 text-slate-400';
                    
                    let statusBadge = '';
                    if (issue.status === 'closed') statusBadge = 'bg-emerald-950 text-emerald-400';
                    else if (issue.status === 'in_progress') statusBadge = 'bg-blue-950 text-blue-400';
                    else if (issue.status === 'open') statusBadge = 'bg-indigo-950 text-indigo-400';
                    let statusText = issue.status.replace('_', ' ');
                    
                    let tagsHtml = '';
                    if (issue.tags && issue.tags.length > 0) {
                        tagsHtml += '<span>·</span>';
                        issue.tags.forEach(tag => {
                            tagsHtml += `<span class="px-1.5 py-0.5 rounded text-[10px] font-medium" style="background-color: ${tag.color}22; color: ${tag.color};">#${tag.name}</span>`;
                        });
                    }
                    
                    let dueDateHtml = '';
                    if (issue.due_date) {
                        let dateObj = new Date(issue.due_date);
                        let day = String(dateObj.getDate()).padStart(2, '0');
                        let month = String(dateObj.getMonth() + 1).padStart(2, '0');
                        let year = dateObj.getFullYear();
                        
                        let isPast = dateObj < new Date(new Date().setHours(0,0,0,0));
                        let colorClass = isPast ? 'text-rose-400' : 'text-gray-300';
                        
                        dueDateHtml = `
                            <div class="text-right hidden sm:block">
                                <span class="block text-[10px] uppercase text-gray-500 tracking-wider">Due</span>
                                <span class="text-xs font-medium ${colorClass}">${day}.${month}.${year}</span>
                            </div>
                        `;
                    }

                    let projectName = issue.project ? issue.project.name : '';
                    
                    html += `
                        <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-gray-800/80 transition">
                            <div class="space-y-1.5">
                                <div class="flex items-center flex-wrap gap-2">
                                    <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded border ${priorityBadge}">${issue.priority}</span>
                                    <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded ${statusBadge}">${statusText}</span>
                                    <h2 class="text-base font-semibold text-white hover:text-indigo-400 transition">
                                        <a href="/issues/${issue.id}">${issue.title}</a>
                                    </h2>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                    <a href="/projects/${issue.project_id}" class="text-indigo-400 hover:underline">${projectName}</a>
                                    ${tagsHtml}
                                </div>
                            </div>
                            <div class="flex items-center gap-4 shrink-0">
                                ${dueDateHtml}
                                <a href="/issues/${issue.id}" class="px-3 py-1.5 bg-gray-900 hover:bg-gray-700 border border-gray-700 text-xs font-medium rounded-md text-gray-300 transition">
                                    View →
                                </a>
                            </div>
                        </div>
                    `;
                });
                
                html += '</div>';
                container.innerHTML = html;
            }
        });
    }, 300);
});
</script>
@endsection
