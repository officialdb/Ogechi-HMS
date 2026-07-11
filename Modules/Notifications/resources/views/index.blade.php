<x-admin-layout title="Notifications Inbox">
<div class="space-y-6 max-w-5xl mx-auto">
    
    {{-- ── HEADER ─────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                Notifications
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 rounded-full">{{ auth()->user()->unreadNotifications->count() }}</span>
                @endif
            </h1>
            <p class="text-sm text-slate-500 mt-1">System alerts, updates, and messages.</p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Test Button — Admins only --}}
            @can('settings.manage')
            <form action="{{ route('modules.notifications.test') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 text-xs font-bold text-slate-500 bg-white border border-slate-200 hover:bg-slate-50 rounded-xl transition-colors">
                    Send Test Alert
                </button>
            </form>
            @endcan

            @if(auth()->user()->unreadNotifications->count() > 0)
            <form action="{{ route('modules.notifications.readAll') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 rounded-xl shadow-sm transition-colors">
                    <x-fas-eye class="w-4 h-4 text-emerald-500" />
                    Mark All Read
                </button>
            </form>
            @endif
        </div>
    </div>

    {{-- ── INBOX LIST ─────────────────────────────────── --}}
    <div class="bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden">
        
        @if($notifications->count() > 0)
            <ul class="divide-y divide-slate-100">
                @foreach($notifications as $notification)
                    @php 
                        $isRead = $notification->read_at !== null; 
                        $data = $notification->data;
                        $iconType = $data['icon'] ?? 'info';
                    @endphp
                    <li class="p-4 sm:p-6 transition-colors hover:bg-slate-50/50 flex flex-col sm:flex-row sm:items-start gap-4 sm:gap-6 {{ $isRead ? 'opacity-70' : 'bg-blue-50/20' }}">
                        
                        {{-- Icon --}}
                        <div class="shrink-0 pt-1">
                            @if($iconType === 'warning')
                                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $isRead ? 'bg-slate-100 text-slate-400' : 'bg-amber-100 text-amber-600' }}">
                                    <x-fas-eye class="w-5 h-5" />
                                </div>
                            @elseif($iconType === 'success')
                                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $isRead ? 'bg-slate-100 text-slate-400' : 'bg-emerald-100 text-emerald-600' }}">
                                    <x-fas-eye class="w-5 h-5" />
                                </div>
                            @elseif($iconType === 'error')
                                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $isRead ? 'bg-slate-100 text-slate-400' : 'bg-red-100 text-red-600' }}">
                                    <x-fas-eye class="w-5 h-5" />
                                </div>
                            @else
                                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $isRead ? 'bg-slate-100 text-slate-400' : 'bg-blue-100 text-blue-600' }}">
                                    <x-fas-eye class="w-5 h-5" />
                                </div>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="flex-1">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-1">
                                <h3 class="text-sm {{ $isRead ? 'font-semibold text-slate-700' : 'font-black text-slate-900' }}">
                                    {{ $data['title'] ?? 'Notification' }}
                                </h3>
                                <span class="text-xs font-semibold text-slate-400 flex items-center gap-1.5">
                                    <x-fas-chart-bar class="w-3.5 h-3.5" />
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-sm {{ $isRead ? 'text-slate-500' : 'text-slate-600 font-medium' }} mb-3">
                                {{ $data['message'] ?? '' }}
                            </p>
                            
                            @if(isset($data['url']))
                                <a href="{{ $data['url'] }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:text-blue-700 transition-colors">
                                    View Details
                                    <x-fas-eye class="w-3.5 h-3.5" />
                                </a>
                            @endif
                        </div>

                        {{-- Actions --}}
                        <div class="shrink-0 flex items-center gap-2 mt-4 sm:mt-0 pt-4 sm:pt-0 border-t border-slate-100 sm:border-0 justify-end sm:justify-start">
                            @if(!$isRead)
                                <form action="{{ route('modules.notifications.read', $notification->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors" title="Mark as Read">
                                        <x-fas-eye class="w-4 h-4" />
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('modules.notifications.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('Delete this notification?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-500 flex items-center justify-center hover:bg-red-50 hover:text-red-600 transition-colors" title="Delete">
                                    <x-fas-plus class="w-4 h-4" />
                                </button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
            
            {{-- Pagination --}}
            @if($notifications->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $notifications->links() }}
                </div>
            @endif
        @else
            <div class="py-20 px-6 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-5 border border-slate-100">
                    <x-fas-eye class="w-10 h-10 text-slate-300" />
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-1">All Caught Up!</h3>
                <p class="text-sm text-slate-500 max-w-sm mx-auto">You have no new notifications. We'll alert you when something needs your attention.</p>
            </div>
        @endif
    </div>

</div>
</x-admin-layout>
