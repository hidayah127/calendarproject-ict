@extends('layouts.app')

@section('title', 'Notifications - AmazingTrack')

@push('styles')
<style>
    .notif-item {
        display: flex;
        gap: 14px;
        padding: 14px 16px;
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        background: var(--surface);
        margin-bottom: 10px;
        transition: var(--transition);
        text-decoration: none;
        color: inherit;
    }
    .notif-item:hover { box-shadow: var(--shadow-sm); transform: translateY(-1px); color: inherit; }
    .notif-item.unread { border-left: 3px solid var(--sidebar-to); background: #f8faff; }
    .notif-icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }
    .notif-body { flex: 1; min-width: 0; }
    .notif-msg { font-size: 14px; font-weight: 600; margin-bottom: 2px; }
    .notif-time { font-size: 12px; color: var(--text-muted); }
    .notif-dot {
        width: 8px; height: 8px; border-radius: 50%;
        background: var(--sidebar-to);
        flex-shrink: 0;
        margin-top: 6px;
    }
    .filter-pill {
        border: 1px solid var(--border);
        border-radius: 30px;
        padding: 6px 16px;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
        text-decoration: none;
    }
    .filter-pill.active {
        background: linear-gradient(135deg, var(--sidebar-from), var(--sidebar-to));
        color: #fff;
        border-color: transparent;
    }
    .empty-state { text-align: center; padding: 50px 20px; color: var(--text-muted); }
    .empty-state i { font-size: 42px; color: #c7d5f8; margin-bottom: 14px; display:block; }
</style>
@endpush

@section('content')

<div class="page-header">
    <div>
        <h2><i class="fa-solid fa-bell me-2" style="color:var(--sidebar-to)"></i>Notifications</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('leader.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Notifications</li>
            </ol>
        </nav>
    </div>
    <form method="POST" action="{{ route('leader.notifications.readAll') }}">
        @csrf
        <button type="submit" class="btn btn-outline-secondary btn-sm" @disabled($unreadCount === 0)>
            <i class="fa-solid fa-check-double me-1"></i>Mark all as read
        </button>
    </form>
</div>

<div class="mb-3">
    <a href="{{ route('leader.notifications.index') }}" class="filter-pill {{ request('filter') !== 'unread' ? 'active' : '' }}">All</a>
    <a href="{{ route('leader.notifications.index', ['filter' => 'unread']) }}" class="filter-pill {{ request('filter') === 'unread' ? 'active' : '' }}">
        Unread @if($unreadCount) <span class="badge status-badge-cancelled ms-1">{{ $unreadCount }}</span> @endif
    </a>
</div>

@forelse($notifications as $n)
    <a href="{{ route('leader.notifications.read', $n->id) }}" class="notif-item {{ $n->read_at ? '' : 'unread' }}"
       onclick="event.preventDefault(); document.getElementById('read-form-{{ $n->id }}').submit();">
        <div class="notif-icon" style="background: {{ $n->icon_bg }}; color: {{ $n->icon_color }};">
            <i class="fa-solid {{ $n->icon }}"></i>
        </div>
        <div class="notif-body">
            <div class="notif-msg">{{ $n->message }}</div>
            <div class="notif-time">{{ \Carbon\Carbon::parse($n->created_at)->diffForHumans() }}</div>
        </div>
        @if(! $n->read_at)
            <span class="notif-dot"></span>
        @endif
    </a>
    <form id="read-form-{{ $n->id }}" method="POST" action="{{ route('leader.notifications.read', $n->id) }}" class="d-none">
        @csrf
    </form>
@empty
    <div class="card">
        <div class="empty-state">
            <i class="fa-solid fa-bell-slash"></i>
            You're all caught up — no notifications {{ request('filter') === 'unread' ? 'unread' : 'yet' }}.
        </div>
    </div>
@endforelse

@if(method_exists($notifications, 'links'))
<div class="mt-4">
    {{ $notifications->links() }}
</div>
@endif

@endsection
