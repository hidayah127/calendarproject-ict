<style>
/* ── Navbar ── */
.top-navbar {
    background: #fff;
    border-bottom: 1.5px solid #e2e8f0;
    padding: 0 24px;
    height: 64px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 1px 8px rgba(15,45,110,0.06);
    position: sticky;
    top: 0;
    z-index: 200;
}

.nav-menu-btn {
    background: #eff6ff;
    border: 1.5px solid #dbeafe;
    border-radius: 10px;
    width: 38px; height: 38px;
    display: flex; align-items: center; justify-content: center;
    color: #1d4ed8;
    cursor: pointer;
    transition: all .2s;
    flex-shrink: 0;
}
.nav-menu-btn:hover { background: #dbeafe; }

.nav-page-title {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    letter-spacing: .2px;
}

.nav-right {
    margin-left: auto;
    display: flex;
    align-items: center;
    gap: 6px;
}

.nav-icon-btn {
    background: none;
    border: none;
    width: 40px; height: 40px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    color: #64748b;
    position: relative;
    transition: background .2s, color .2s;
    font-size: 16px;
}
.nav-icon-btn:hover { background: #f1f5f9; color: #1e293b; }

.notif-badge {
    position: absolute;
    top: 3px; right: 3px;
    min-width: 17px; height: 17px;
    background: #ef4444;
    border-radius: 10px;
    font-size: 9px;
    font-weight: 800;
    color: #fff;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 0 4px;
    border: 1.5px solid #fff;
    pointer-events: none;
}

.nav-divider {
    width: 1px;
    height: 28px;
    background: #e2e8f0;
    margin: 0 4px;
}

/* ── Dropdown wrapper — must be relative so dropdowns position correctly ── */
.nav-dropdown-wrap {
    position: relative;
}

/* ── Notification Dropdown ── */
.notif-dropdown {
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    width: 360px;
    background: #fff;
    border: 1.5px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 16px 48px rgba(15,45,110,0.16);
    z-index: 9999;
    display: none;
    overflow: hidden;
}

.notif-dropdown.open {
    display: block;
    animation: dropIn .18s ease;
}

@keyframes dropIn {
    from { opacity:0; transform:translateY(8px); }
    to   { opacity:1; transform:translateY(0); }
}

.notif-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 18px 12px;
    border-bottom: 1px solid #f1f5f9;
}

.notif-header h6 {
    font-size: 14px;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 7px;
}

.notif-count-pill {
    background: #eff6ff;
    color: #1d4ed8;
    font-size: 11px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 20px;
}

.mark-all-btn {
    background: none;
    border: none;
    font-size: 12px;
    font-weight: 600;
    color: #1a56db;
    cursor: pointer;
    padding: 0;
    font-family: inherit;
    transition: color .2s;
}
.mark-all-btn:hover { color: #0f2d6e; }

#notifList {
    max-height: 320px;
    overflow-y: auto;
}

.notif-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 13px 18px;
    border-bottom: 1px solid #f8faff;
    cursor: pointer;
    transition: background .18s;
    position: relative;
    text-decoration: none;
    color: inherit;
}

.notif-item:hover { background: #f8faff; }
.notif-item.unread { background: #fafcff; }

.notif-item.unread::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 3px;
    background: #1a56db;
    border-radius: 0 2px 2px 0;
}

.notif-icon-wrap {
    width: 38px; height: 38px;
    border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px;
    flex-shrink: 0;
}

.notif-body { flex: 1; min-width: 0; }

.notif-body p {
    font-size: 13.5px;
    font-weight: 600;
    color: #1e293b;
    margin: 0 0 3px;
    line-height: 1.4;
}

.notif-body span {
    font-size: 12px;
    color: #94a3b8;
    font-weight: 500;
}

.notif-unread-dot {
    width: 8px; height: 8px;
    background: #1a56db;
    border-radius: 50%;
    flex-shrink: 0;
    margin-top: 5px;
}

.notif-empty {
    text-align: center;
    padding: 36px 20px;
    color: #94a3b8;
}

.notif-empty i {
    font-size: 32px;
    display: block;
    margin-bottom: 10px;
    color: #cbd5e1;
}

.notif-footer {
    padding: 12px 18px;
    text-align: center;
    border-top: 1px solid #f1f5f9;
}

.notif-footer a {
    font-size: 13px;
    font-weight: 600;
    color: #1a56db;
    text-decoration: none;
}
.notif-footer a:hover { color: #0f2d6e; }

/* ── User dropdown ── */
.user-dropdown {
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    width: 220px;
    background: #fff;
    border: 1.5px solid #e2e8f0;
    border-radius: 14px;
    box-shadow: 0 16px 48px rgba(15,45,110,0.14);
    z-index: 9999;
    display: none;
    overflow: hidden;
}

.user-dropdown.open {
    display: block;
    animation: dropIn .18s ease;
}

.user-dropdown-header {
    padding: 16px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    gap: 11px;
}

.user-avatar-lg {
    width: 42px; height: 42px;
    border-radius: 12px;
    background: linear-gradient(135deg, #0f2d6e, #1a56db);
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    font-size: 15px;
    font-weight: 700;
    flex-shrink: 0;
}

.user-dropdown-name {
    font-size: 14px;
    font-weight: 700;
    color: #0f172a;
}

.user-dropdown-role {
    font-size: 12px;
    color: #64748b;
    margin-top: 1px;
}

.user-dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 11px 16px;
    font-size: 13.5px;
    font-weight: 500;
    color: #374151;
    text-decoration: none;
    transition: background .15s;
    cursor: pointer;
    border: none;
    background: none;
    width: 100%;
    font-family: inherit;
    text-align: left;
}

.user-dropdown-item i {
    width: 18px;
    text-align: center;
    color: #64748b;
    font-size: 13px;
}

.user-dropdown-item:hover { background: #f8faff; color: #1e293b; text-decoration: none; }
.user-dropdown-item:hover i { color: #1a56db; }
.user-dropdown-item.danger { color: #b91c1c; }
.user-dropdown-item.danger i { color: #ef4444; }
.user-dropdown-item.danger:hover { background: #fef2f2; }

.user-dropdown-divider {
    height: 1px;
    background: #f1f5f9;
    margin: 4px 0;
}

.user-nav-btn {
    background: #f8faff;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    padding: 6px 12px 6px 8px;
    display: flex;
    align-items: center;
    gap: 9px;
    cursor: pointer;
    transition: all .2s;
    font-family: inherit;
}
.user-nav-btn:hover { border-color: #bfdbfe; background: #eff6ff; }

.user-avatar-sm {
    width: 30px; height: 30px;
    border-radius: 8px;
    background: linear-gradient(135deg, #0f2d6e, #1a56db);
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    flex-shrink: 0;
}

.user-nav-name {
    font-size: 13.5px;
    font-weight: 700;
    color: #1e293b;
    line-height: 1;
}

.user-nav-role {
    font-size: 11.5px;
    color: #64748b;
    margin-top: 2px;
    line-height: 1;
}
</style>

{{-- ══════════════════════════
     NAVBAR
══════════════════════════ --}}
<nav class="top-navbar">

    {{-- User Profile with super admin gurds update --}}
        @php
            $isAdmin = Auth::guard('admin')->check();

            if ($isAdmin) {
                $user = Auth::guard('admin')->user();
                $role = 'super_admin';
            } else {
                $user = auth()->user();
                $role = $user->role ?? 'user';
            }

            $roleNames = [
                'super_admin' => 'Super Admin',
                'vc' => 'Vice Chancellor',
                'hd' => 'Programme Secretariat',
                'ld' => 'Head of Department',
            ];
        @endphp

    {{-- Mobile menu button --}}
    <button class="nav-menu-btn d-lg-none"
            data-bs-toggle="offcanvas"
            data-bs-target="#mobileSidebar">
        <i class="fa fa-bars"></i>
    </button>

    {{-- Page title --}}
    <span class="nav-page-title">@yield('page-title', 'Dashboard')</span>

    {{-- Right section --}}
    <div class="nav-right">

        {{-- ── Notification bell ── --}}
        <div class="nav-dropdown-wrap" id="notifWrap">
            <button class="nav-icon-btn" id="notifBtn" title="Notifications">
                <i class="fa fa-bell"></i>
                <span class="notif-badge" id="notifBadge"></span>
            </button>

            <div class="notif-dropdown" id="notifDropdown">
                <div class="notif-header">
                    <h6>
                        <i class="fa fa-bell" style="color:#1a56db;"></i>
                        Notifications
                        <span class="notif-count-pill" id="notifCountPill">0</span>
                    </h6>
                    <div style="display:flex;gap:10px;align-items:center;">
                        <button class="mark-all-btn" id="markAllBtn">Mark all read</button>
                        <button class="mark-all-btn" id="clearAllBtn" style="color:#ef4444;">Clear all</button>
                    </div>
                </div>

                <div id="notifList"></div>

                <div class="notif-footer">
                    {{-- @if(auth()->user()->role == 'vc')
                        <a href="{{ route('vc.programs') }}">View all programs →</a>
                    @elseif(auth()->user()->role == 'hd')
                        <a href="{{ route('head.programs.index') }}">View all programs →</a>
                    @endif --}}

                    @if(!$isAdmin && $role == 'vc')
                        <a href="{{ route('vc.programs') }}">View all programs →</a>

                    @elseif(!$isAdmin && $role == 'hd')
                        <a href="{{ route('head.programs.index') }}">View all programs →</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="nav-divider d-none d-md-block"></div>

        {{-- ── User profile ── --}}
        {{-- @php
                    $role = auth()->user()->role ?? 'user';

                    $roleNames = [
                        'admin' => 'Admin',
                        'vc' => 'Vice Chancellor',
                        'hd' => 'Programme Secretariat',
                        'ld'=> 'Head of Department',
                    ];
        @endphp --}}

        

        <div class="nav-dropdown-wrap" id="userWrap">
            <button class="user-nav-btn" id="userBtn">
                <div class="user-avatar-sm">
                    {{-- {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }} --}}
                    {{ strtoupper(substr($user->name ?? $user->username ?? 'U', 0, 2)) }}
                </div>
                <div class="d-none d-md-block text-start">
                    <div class="user-nav-name">{{ $user->name ?? $user->username ?? 'User' }}</div>
                    {{-- <div class="user-nav-role">{{ ucfirst(auth()->user()->role ?? 'User') }}</div> --}}
                    <div class="user-nav-role">{{ $roleNames[$role] ?? 'User' }}</div>
                </div>
                <i class="fa fa-chevron-down d-none d-md-inline"
                   style="font-size:11px;color:#94a3b8;margin-left:2px;"></i>
            </button>

            <div class="user-dropdown" id="userDropdown">
                <div class="user-dropdown-header">
                    <div class="user-avatar-lg">
                        {{-- {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }} --}}
                        {{ strtoupper(substr($user->name ?? $user->username ?? 'U', 0, 2)) }}
                    </div>
                    <div>
                        <div class="user-dropdown-name">{{ $user->name ?? $user->username ?? 'User' }}</div>
                        <div class="user-dropdown-role">{{ $roleNames[$role] ?? 'User' }}</div>
                    </div>
                </div>
                {{-- <div class="user-dropdown-header">
                    <div class="user-avatar-lg">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                    </div>
                    <div>
                        <div class="user-dropdown-name">{{ auth()->user()->name ?? 'User' }}</div>
                        <div class="user-dropdown-role">{{ ucfirst(auth()->user()->role ?? 'User') }}</div>
                    </div>
                </div> --}}


                {{-- change password --}}
                <div style="padding:6px 0;">
                    {{-- <a href="#" class="user-dropdown-item">
                        <i class="fa fa-user"></i> Profile
                    </a> --}}
                    {{-- <a href="{{ route('change.password') }}" class="user-dropdown-item">
                        <i class="fa fa-key"></i> Change Password
                    </a> --}}
                </div>

                <div class="user-dropdown-divider"></div>

                <div style="padding:6px 0 8px;">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="user-dropdown-item danger">
                            <i class="fa fa-right-from-bracket"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</nav>

{{-- NO overlay div — we use document click instead --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Elements ── */
    var notifBtn      = document.getElementById('notifBtn');
    var notifDropdown = document.getElementById('notifDropdown');
    var notifWrap     = document.getElementById('notifWrap');
    var userBtn       = document.getElementById('userBtn');
    var userDropdown  = document.getElementById('userDropdown');
    var userWrap      = document.getElementById('userWrap');
    var markAllBtn    = document.getElementById('markAllBtn');
    var clearAllBtn   = document.getElementById('clearAllBtn');
    var notifList     = document.getElementById('notifList');
    var badge         = document.getElementById('notifBadge');
    var pill          = document.getElementById('notifCountPill');

    /* ── URLs ── */
    var FETCH_URL     = "{{ route('notifications.index') }}";
    var READ_ALL_URL  = "{{ route('notifications.readAll') }}";
    var CLEAR_ALL_URL = "{{ route('notifications.clearAll') }}";
    var READ_BASE_URL = "{{ url('notifications') }}";

    /* ── CSRF ── */
    var csrfMeta = document.querySelector('meta[name="csrf-token"]');
    var CSRF     = csrfMeta ? csrfMeta.getAttribute('content') : '';

    /* ══════════════════════════════════════
       RENDER
    ══════════════════════════════════════ */
    function render(items, unreadCount) {
        /* Badge */
        if (unreadCount > 0) {
            badge.textContent   = unreadCount > 9 ? '9+' : unreadCount;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }
        pill.textContent = unreadCount;

        /* Empty state */
        if (!items || items.length === 0) {
            notifList.innerHTML =
                '<div class="notif-empty">' +
                    '<i class="fa fa-bell-slash"></i>' +
                    '<p style="font-size:13.5px;margin:0;">You\'re all caught up!</p>' +
                '</div>';
            return;
        }

        /* Items */
        notifList.innerHTML = items.map(function (n) {
            return '<div class="notif-item ' + (n.unread ? 'unread' : '') + '" ' +
                       'data-id="' + n.id + '" ' +
                       'data-url="' + (n.url || '#') + '">' +
                        '<div class="notif-icon-wrap" style="background:' + n.icon_bg + ';">' +
                            '<i class="fa ' + n.icon + '" style="color:' + n.icon_color + ';"></i>' +
                        '</div>' +
                        '<div class="notif-body">' +
                            '<p>' + n.message + '</p>' +
                            '<span><i class="fa fa-clock" style="margin-right:4px;"></i>' + n.time + '</span>' +
                        '</div>' +
                        (n.unread ? '<div class="notif-unread-dot"></div>' : '') +
                    '</div>';
        }).join('');

        /* Click listeners on items */
        notifList.querySelectorAll('.notif-item').forEach(function (item) {
            item.addEventListener('click', function () {
                markOneRead(this.dataset.id, this.dataset.url);
            });
        });
    }

    /* ══════════════════════════════════════
       FETCH
    ══════════════════════════════════════ */
    function fetchNotifications() {
        fetch(FETCH_URL, {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
        })
        .then(function (r) { return r.json(); })
        .then(function (data) { render(data.notifications, data.unread_count); })
        .catch(function () {});
    }

    /* ══════════════════════════════════════
       MARK ONE READ
    ══════════════════════════════════════ */
    function markOneRead(id, url) {
        fetch(READ_BASE_URL + '/' + id + '/read', {
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        })
        .then(function () {
            fetchNotifications();
            if (url && url !== '#') window.location.href = url;
        })
        .catch(function () {});
    }

    /* ══════════════════════════════════════
       MARK ALL READ
    ══════════════════════════════════════ */
    function markAllRead(callback) {
        fetch(READ_ALL_URL, {
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        })
        .then(function () {
            if (typeof callback === 'function') callback();
            else fetchNotifications();
        })
        .catch(function () {});
    }

    markAllBtn.addEventListener('click', function () { markAllRead(); });

    /* ══════════════════════════════════════
       CLEAR ALL
    ══════════════════════════════════════ */
    clearAllBtn.addEventListener('click', function () {
        markAllRead(function () {
            fetch(CLEAR_ALL_URL, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
            })
            .then(function () { fetchNotifications(); })
            .catch(function () {});
        });
    });

    /* ══════════════════════════════════════
       DROPDOWN TOGGLES
       — NO overlay div. Close by listening
         to document clicks instead.
    ══════════════════════════════════════ */
    function closeAll() {
        notifDropdown.classList.remove('open');
        userDropdown.classList.remove('open');
    }

    /* Notif button */
    notifBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        var isOpen = notifDropdown.classList.contains('open');
        closeAll();
        if (!isOpen) {
            notifDropdown.classList.add('open');
            /* Auto mark all read when panel opens */
            markAllRead();
        }
    });

    /* User button */
    userBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        var isOpen = userDropdown.classList.contains('open');
        closeAll();
        if (!isOpen) {
            userDropdown.classList.add('open');
        }
    });

    /* Stop clicks INSIDE dropdowns from bubbling to document */
    notifDropdown.addEventListener('click', function (e) { e.stopPropagation(); });
    userDropdown.addEventListener('click',  function (e) { e.stopPropagation(); });

    /* Click anywhere outside → close all */
    document.addEventListener('click', function () { closeAll(); });

    /* Escape key → close all */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeAll();
    });

    /* ══════════════════════════════════════
       INIT
    ══════════════════════════════════════ */
    fetchNotifications();
    setInterval(fetchNotifications, 30000);

});
</script>
