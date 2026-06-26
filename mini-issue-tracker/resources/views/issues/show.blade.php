@extends('layouts.app')

@section('title', $issue->title . ' - Issue Detail')

@section('content')
<div class="space-y-8">

    {{-- Breadcrumb & Header --}}
    <div class="border-b border-gray-800 pb-6">
        <div class="text-xs text-gray-500 mb-2 flex items-center gap-1.5">
            <a href="{{ route('projects.index') }}" class="hover:text-indigo-400 transition">Projects</a>
            <span>/</span>
            <a href="{{ route('projects.show', $issue->project_id) }}" class="hover:text-indigo-400 transition">{{ $issue->project->name }}</a>
            <span>/</span>
            <span class="text-gray-400">Issue #{{ $issue->id }}</span>
        </div>
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
            <div class="flex-1">
                <div class="flex flex-wrap items-center gap-2 mb-2">
                    {{-- Priority Badge --}}
                    <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded border
                        {{ $issue->priority === 'high'   ? 'bg-rose-950/60 border-rose-800 text-rose-400'     : '' }}
                        {{ $issue->priority === 'medium' ? 'bg-amber-950/60 border-amber-800 text-amber-400'   : '' }}
                        {{ $issue->priority === 'low'    ? 'bg-slate-900 border-slate-700 text-slate-400'       : '' }}">
                        {{ $issue->priority }}
                    </span>
                    {{-- Status Badge --}}
                    <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded
                        {{ $issue->status === 'closed'      ? 'bg-emerald-950 text-emerald-400' : '' }}
                        {{ $issue->status === 'in_progress' ? 'bg-blue-950 text-blue-400'       : '' }}
                        {{ $issue->status === 'open'        ? 'bg-indigo-950 text-indigo-400'   : '' }}">
                        {{ str_replace('_', ' ', $issue->status) }}
                    </span>
                </div>
                <h1 class="text-2xl font-extrabold text-white">{{ $issue->title }}</h1>
                @if($issue->due_date)
                    <p class="text-xs text-gray-500 mt-1">
                        Due: <span class="text-gray-300 font-medium">{{ \Carbon\Carbon::parse($issue->due_date)->format('d.m.Y') }}</span>
                    </p>
                @endif
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('issues.edit', $issue->id) }}"
                   class="px-3.5 py-2 bg-gray-800 hover:bg-gray-700 border border-gray-700 text-sm font-medium rounded-lg text-gray-300 transition">
                    Edit Issue
                </a>
                <form action="{{ route('issues.destroy', $issue->id) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this issue?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-3.5 py-2 bg-rose-950 hover:bg-rose-900 border border-rose-800 text-sm font-medium rounded-lg text-rose-400 transition">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Description --}}
            <div class="bg-gray-800/50 border border-gray-700/50 rounded-xl p-6">
                <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-3">Description</h2>
                <p class="text-gray-200 text-sm leading-relaxed whitespace-pre-line">
                    {{ $issue->description ?? 'No description provided.' }}
                </p>
            </div>

            {{-- Tags --}}
            <div class="bg-gray-800/50 border border-gray-700/50 rounded-xl p-6">
                <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-3">Tags</h2>
                <div id="tags-container" class="flex flex-wrap gap-2 mb-4">
                    @forelse($issue->tags as $tag)
                        <span class="tag-badge inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium border cursor-pointer select-none"
                              style="background-color: {{ $tag->color }}22; border-color: {{ $tag->color }}; color: {{ $tag->color }};"
                              data-tag-id="{{ $tag->id }}"
                              title="Click to remove">
                            #{{ $tag->name }}
                            <svg class="w-3 h-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </span>
                    @empty
                        <span class="text-sm text-gray-500">No tags assigned yet.</span>
                    @endforelse
                </div>

                {{-- Add Tag --}}
                <div class="flex flex-wrap gap-2 mt-2 pt-3 border-t border-gray-700/50">
                    <select id="tag-select"
                            class="bg-gray-900 border border-gray-700 text-gray-300 text-sm rounded-lg px-3 py-1.5 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                        <option value="">— Select a tag to add —</option>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" data-color="{{ $tag->color }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                    <button id="add-tag-btn"
                            class="px-3.5 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg transition">
                        Add Tag
                    </button>
                </div>
            </div>

            {{-- Comments --}}
            <div class="bg-gray-800/50 border border-gray-700/50 rounded-xl p-6">
                <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">
                    Comments (<span id="comment-count">{{ $issue->comments->count() }}</span>)
                </h2>

                <div id="comments-list" class="space-y-4 mb-6">
                    @forelse($issue->comments as $comment)
                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded-full bg-indigo-700 flex items-center justify-center text-xs font-bold text-white shrink-0">
                                {{ strtoupper(substr($comment->author_name, 0, 1)) }}
                            </div>
                            <div class="flex-1 bg-gray-900/60 border border-gray-700/50 rounded-xl p-4">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm font-semibold text-gray-200">{{ $comment->author_name }}</span>
                                    <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-300 leading-relaxed">{{ $comment->body }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500" id="no-comments-msg">No comments yet. Be the first!</p>
                    @endforelse
                </div>

                {{-- Add Comment Form --}}
                <form id="comment-form" class="space-y-3 pt-4 border-t border-gray-700/50">
                    @csrf
                    <input type="text" id="comment-author" placeholder="Your name"
                           class="w-full bg-gray-900 border border-gray-700 text-gray-200 text-sm rounded-lg px-4 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 outline-none placeholder-gray-500">
                    <textarea id="comment-body" rows="3" placeholder="Write a comment..."
                              class="w-full bg-gray-900 border border-gray-700 text-gray-200 text-sm rounded-lg px-4 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 outline-none placeholder-gray-500 resize-none"></textarea>
                    <button type="submit"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold rounded-lg transition">
                        Post Comment
                    </button>
                    <p id="comment-error" class="text-rose-400 text-xs hidden"></p>
                </form>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-4">
            <div class="bg-gray-800/50 border border-gray-700/50 rounded-xl p-5 space-y-4">
                <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Details</h2>

                <div>
                    <span class="block text-[10px] uppercase text-gray-500 tracking-wider mb-1">Project</span>
                    <a href="{{ route('projects.show', $issue->project_id) }}"
                       class="text-sm text-indigo-400 hover:underline font-medium">
                        {{ $issue->project->name }}
                    </a>
                </div>

                <div>
                    <span class="block text-[10px] uppercase text-gray-500 tracking-wider mb-1">Status</span>
                    <span class="text-sm text-gray-200 font-medium capitalize">{{ str_replace('_', ' ', $issue->status) }}</span>
                </div>

                <div>
                    <span class="block text-[10px] uppercase text-gray-500 tracking-wider mb-1">Priority</span>
                    <span class="text-sm text-gray-200 font-medium capitalize">{{ $issue->priority }}</span>
                </div>

                @if($issue->due_date)
                <div>
                    <span class="block text-[10px] uppercase text-gray-500 tracking-wider mb-1">Due Date</span>
                    <span class="text-sm font-medium
                        {{ \Carbon\Carbon::parse($issue->due_date)->isPast() ? 'text-rose-400' : 'text-gray-200' }}">
                        {{ \Carbon\Carbon::parse($issue->due_date)->format('d M Y') }}
                    </span>
                </div>
                @endif

                <div>
                    <span class="block text-[10px] uppercase text-gray-500 tracking-wider mb-1">Created</span>
                    <span class="text-sm text-gray-300">{{ \Carbon\Carbon::parse($issue->created_at)->format('d M Y') }}</span>
                </div>
            </div>

            <a href="{{ route('projects.show', $issue->project_id) }}"
               class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-gray-800 hover:bg-gray-700 border border-gray-700 text-sm font-medium rounded-lg text-gray-300 transition">
                ← Back to Project
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const issueId = {{ $issue->id }};
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

// ─── Tag Toggle ─────────────────────────────────────────────────────────────
document.getElementById('add-tag-btn').addEventListener('click', async () => {
    const select = document.getElementById('tag-select');
    const tagId  = select.value;
    if (!tagId) return;

    const res  = await fetch(`/api/issues/${issueId}/tags`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({ tag_id: tagId }),
    });
    const data = await res.json();

    // Re-render tags
    renderTags(data.tags);
    select.value = '';
});

document.getElementById('tags-container').addEventListener('click', async (e) => {
    const badge = e.target.closest('.tag-badge');
    if (!badge) return;

    const tagId = badge.dataset.tagId;
    const res   = await fetch(`/api/issues/${issueId}/tags`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({ tag_id: tagId }),
    });
    const data = await res.json();
    renderTags(data.tags);
});

function renderTags(tags) {
    const container = document.getElementById('tags-container');
    if (!tags.length) {
        container.innerHTML = '<span class="text-sm text-gray-500">No tags assigned yet.</span>';
        return;
    }
    container.innerHTML = tags.map(tag => `
        <span class="tag-badge inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium border cursor-pointer select-none"
              style="background-color: ${tag.color}22; border-color: ${tag.color}; color: ${tag.color};"
              data-tag-id="${tag.id}" title="Click to remove">
            #${tag.name}
            <svg class="w-3 h-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </span>
    `).join('');
}

// ─── Comments ────────────────────────────────────────────────────────────────
document.getElementById('comment-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const authorInput = document.getElementById('comment-author');
    const bodyInput   = document.getElementById('comment-body');
    const errorEl     = document.getElementById('comment-error');

    errorEl.classList.add('hidden');

    if (!authorInput.value.trim() || !bodyInput.value.trim()) {
        errorEl.textContent = 'Please fill in both name and comment fields.';
        errorEl.classList.remove('hidden');
        return;
    }

    const res = await fetch(`/api/issues/${issueId}/comments`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({ author_name: authorInput.value.trim(), body: bodyInput.value.trim() }),
    });

    if (!res.ok) {
        errorEl.textContent = 'Failed to post comment. Please try again.';
        errorEl.classList.remove('hidden');
        return;
    }

    const comment = await res.json();

    // Remove "no comments" message if present
    const noMsg = document.getElementById('no-comments-msg');
    if (noMsg) noMsg.remove();

    // Prepend new comment
    const list = document.getElementById('comments-list');
    const div  = document.createElement('div');
    div.className = 'flex gap-3';
    div.innerHTML = `
        <div class="w-8 h-8 rounded-full bg-indigo-700 flex items-center justify-center text-xs font-bold text-white shrink-0">
            ${comment.author_name.charAt(0).toUpperCase()}
        </div>
        <div class="flex-1 bg-gray-900/60 border border-gray-700/50 rounded-xl p-4">
            <div class="flex items-center justify-between mb-1">
                <span class="text-sm font-semibold text-gray-200">${comment.author_name}</span>
                <span class="text-xs text-gray-500">Just now</span>
            </div>
            <p class="text-sm text-gray-300 leading-relaxed">${comment.body}</p>
        </div>`;
    list.prepend(div);

    // Update count
    const countEl = document.getElementById('comment-count');
    countEl.textContent = parseInt(countEl.textContent) + 1;

    // Reset form
    authorInput.value = '';
    bodyInput.value   = '';
});
</script>
@endsection
