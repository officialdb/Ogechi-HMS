<x-admin-layout title="Blog CMS">
<div class="space-y-6">
    
    {{-- ── HEADER ─────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Blog Content</h1>
            <p class="text-sm text-slate-500 mt-1">Manage health articles and hospital news</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('modules.cms.create') }}" class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white rounded-xl shadow-md transition-all hover:opacity-90" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                <x-fas-calendar-alt class="w-5 h-5" />
                Write New Post
            </a>
        </div>
    </div>

    {{-- ── FILTER / SEARCH BAR ────────────────────────── --}}
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col sm:flex-row gap-4 items-center justify-between">
        <form method="GET" action="{{ route('modules.cms.index') }}" class="flex-1 w-full sm:w-auto relative" id="search-form">
            <x-fas-plus class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Search posts by title, author, or category…" 
                   class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors">
            @if(request('approval_status'))
                <input type="hidden" name="approval_status" value="{{ request('approval_status') }}">
            @endif
        </form>
        <div class="flex items-center gap-2 w-full sm:w-auto overflow-x-auto pb-1 sm:pb-0 hide-scrollbar">
            @foreach(['all'=>'All','approved'=>'Published','submitted'=>'Approval Queue','draft'=>'Drafts', 'rejected'=>'Rejected'] as $val => $label)
                @php $isActive = request('approval_status', 'all') === $val; @endphp
                <a href="{{ request()->fullUrlWithQuery(['approval_status' => $val, 'page' => 1]) }}" 
                   class="whitespace-nowrap px-4 py-2 text-xs font-bold rounded-xl transition-colors border {{ $isActive ? 'bg-blue-50 text-blue-700 border-blue-200' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- ── DATA GRID ──────────────────────────────────── --}}
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden relative">
        
        {{-- Skeleton overlay --}}
        <div x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 800)">
            <div x-show="loading" x-transition.opacity class="absolute inset-0 bg-white z-10 p-5">
                <div class="space-y-4">
                    <div class="skeleton h-10 w-full rounded-xl"></div>
                    @for($i=0; $i<5; $i++)
                        <div class="skeleton h-16 w-full rounded-xl"></div>
                    @endfor
                </div>
            </div>
            
            @if($posts->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-100 text-slate-500 font-semibold text-xs tracking-wide uppercase">
                                <th class="px-6 py-4">Title</th>
                                <th class="px-6 py-4">Category</th>
                                <th class="px-6 py-4">Author</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Date</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-slate-700">
                            @foreach($posts as $post)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-6 py-3.5 whitespace-normal min-w-[250px]">
                                        <div class="flex items-center gap-3">
                                            @if($post->thumbnail)
                                                <img src="{{ Storage::url($post->thumbnail) }}" alt="" class="w-10 h-10 rounded-lg object-cover shadow-sm flex-shrink-0">
                                            @else
                                                <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0">
                                                    <x-fas-plus class="w-5 h-5 text-slate-400" />
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-bold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-1">{{ $post->title }}</p>
                                                <p class="text-[11px] text-slate-500 mt-0.5 line-clamp-1">{{ Str::limit($post->excerpt, 60) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3.5">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700">
                                            {{ $post->category }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3.5">
                                        <div class="text-xs">
                                            <p class="font-medium text-slate-700">{{ $post->author?->name ?? '—' }}</p>
                                            <p class="text-slate-400 mt-0.5">{{ $post->author?->roles->first()->name ?? '—' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3.5">
                                        @if($post->approval_status === 'approved')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100/50">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Published
                                            </span>
                                        @elseif($post->approval_status === 'submitted')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100/50">
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span> In Review
                                            </span>
                                        @elseif($post->approval_status === 'rejected')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-red-50 text-red-700 border border-red-100/50">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Rejected
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100/50">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Draft
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3.5">
                                        <p class="text-xs text-slate-500 font-medium">
                                            {{ $post->published_at ? $post->published_at->format('M d, Y') : '—' }}
                                        </p>
                                    </td>
                                     <td class="px-6 py-3.5 text-right">
                                        <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            @if($post->approval_status === 'submitted')
                                                {{-- Resend Notification to Publishers --}}
                                                <form method="POST" action="{{ route('modules.cms.resend-notification', $post) }}">
                                                    @csrf
                                                    <button type="submit" title="Resend Notification to Publishers"
                                                            class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center hover:bg-amber-500 hover:text-white transition-colors">
                                                        <x-fas-eye class="w-4 h-4" />
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('website.blog.show', $post->slug ?? 'preview') }}" target="_blank" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors" title="View Article">
                                                <x-fas-eye class="w-4 h-4" />
                                            </a>
                                            <a href="{{ route('modules.cms.edit', $post) }}" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center hover:bg-slate-200 transition-colors" title="Edit Article">
                                                <x-fas-tachometer-alt class="w-4 h-4" />
                                            </a>
                                            <form method="POST" action="{{ route('modules.cms.destroy', $post) }}"
                                                  onsubmit="return confirm('Delete this post? This cannot be undone.')">
                                                @csrf @method('DELETE')
                                                <button type="submit" title="Delete Post"
                                                        class="w-8 h-8 rounded-lg bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-colors">
                                                    <x-fas-plus class="w-4 h-4" />
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                @if($posts->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $posts->links() }}
                    </div>
                @endif
            @else
                <div class="py-16 px-6 text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-slate-100">
                        <x-fas-eye class="w-8 h-8 text-slate-300" />
                    </div>
                    <h3 class="text-sm font-bold text-slate-900 mb-1">No Posts Found</h3>
                    <p class="text-xs text-slate-500 mb-4 max-w-sm mx-auto">There are no blog posts matching your criteria. Start writing your first health article!</p>
                    <a href="{{ route('modules.cms.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-bold text-white rounded-xl shadow-md transition-all hover:opacity-90" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                        Write New Post
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
</x-admin-layout>
