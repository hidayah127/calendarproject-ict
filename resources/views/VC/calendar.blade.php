@extends('layouts.app')

@section('page-title','Programs Calendar — Vice Chancellor')

@push('styles')
<style>
@keyframes fadeUp {
    from{opacity:0;transform:translateY(16px);}
    to{opacity:1;transform:translateY(0);}
}
.fu{animation:fadeUp .45s ease both;}
.d1{animation-delay:.06s;}.d2{animation-delay:.14s;}.d3{animation-delay:.22s;}

/* ── Hero ── */
.vc-hero{background:linear-gradient(128deg,#0a1f52 0%,#0f2d6e 50%,#1e40af 100%);border-radius:20px;padding:28px 32px;margin-bottom:24px;position:relative;overflow:hidden;box-shadow:0 12px 40px rgba(15,45,110,.22);}
.vc-hero::before{content:'';position:absolute;width:300px;height:300px;border-radius:50%;background:rgba(245,158,11,.10);top:-90px;right:-60px;pointer-events:none;}
.vc-hero h1{font-size:1.55rem;font-weight:800;color:#fff;margin:0 0 5px;}
.vc-hero p{font-size:13.5px;color:rgba(255,255,255,.62);margin:0;}
.hero-bottom{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:14px;margin-top:20px;}
.hero-chips{display:flex;gap:8px;flex-wrap:wrap;}
.hero-chip{background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);border-radius:10px;padding:6px 13px;font-size:12px;font-weight:600;color:rgba(255,255,255,.88);display:inline-flex;align-items:center;gap:7px;}
.hero-chip i{color:#f59e0b;}
.view-switcher{display:flex;gap:8px;}
.vs-btn{background:rgba(255,255,255,.13);border:1.5px solid rgba(255,255,255,.22);border-radius:11px;padding:9px 18px;color:rgba(255,255,255,.85);font-size:13px;font-weight:700;display:inline-flex;align-items:center;gap:8px;text-decoration:none;transition:all .22s;}
.vs-btn:hover{background:rgba(255,255,255,.22);color:#fff;text-decoration:none;transform:translateY(-1px);}
.vs-btn.active{background:#f59e0b;border-color:#f59e0b;color:#fff;box-shadow:0 4px 16px rgba(245,158,11,.38);}

/* ── Layout ── */
.cal-layout{display:grid;grid-template-columns:260px 1fr;gap:20px;align-items:start;}
@media(max-width:1100px){.cal-layout{grid-template-columns:1fr;}}

/* ── Sidebar ── */
.cal-sidebar{display:flex;flex-direction:column;gap:16px;position:sticky;top:84px;}
.side-panel{background:#fff;border:1.5px solid #e2e8f0;border-radius:16px;overflow:hidden;box-shadow:0 2px 14px rgba(15,45,110,.06);}
.side-panel-hdr{padding:14px 18px 12px;border-bottom:1px solid #f1f5f9;font-size:13px;font-weight:800;color:#0f172a;display:flex;align-items:center;gap:8px;}
.side-panel-hdr i{width:26px;height:26px;border-radius:7px;display:inline-flex;align-items:center;justify-content:center;font-size:12px;}

.leg-item{display:flex;align-items:center;gap:10px;padding:9px 18px;border-bottom:1px solid #f8faff;font-size:13px;font-weight:600;color:#334155;cursor:pointer;transition:background .15s,opacity .2s;user-select:none;}
.leg-item:last-child{border-bottom:none;}
.leg-item:hover{background:#f8faff;}
.leg-item.dim{opacity:.35;}
.leg-dot{width:11px;height:11px;border-radius:50%;flex-shrink:0;}
.leg-count{margin-left:auto;background:#f1f5f9;color:#64748b;font-size:11px;font-weight:700;padding:2px 8px;border-radius:20px;}

.dept-row{display:flex;align-items:center;gap:10px;padding:9px 18px;border-bottom:1px solid #f8faff;font-size:13px;font-weight:600;color:#334155;cursor:pointer;transition:background .15s;user-select:none;}
.dept-row:last-child{border-bottom:none;}
.dept-row:hover{background:#f8faff;}
.dept-row.active{background:#eff6ff;color:#1d4ed8;}
.dept-chk{width:16px;height:16px;border-radius:5px;border:2px solid #e2e8f0;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;font-size:9px;color:transparent;transition:all .18s;}
.dept-row.active .dept-chk{background:#1a56db;border-color:#1a56db;color:#fff;}

.up-item{display:flex;align-items:flex-start;gap:10px;padding:11px 18px;border-bottom:1px solid #f8faff;transition:background .15s;}
.up-item:last-child{border-bottom:none;}
.up-item:hover{background:#f8faff;}
.up-dot{width:9px;height:9px;border-radius:50%;flex-shrink:0;margin-top:4px;}
.up-title{font-size:13px;font-weight:700;color:#1e293b;}
.up-date{font-size:11.5px;color:#94a3b8;margin-top:1px;}
.up-dept-text{font-size:11px;color:#b0bec5;}

/* ── Calendar card ── */
.cal-card{background:#fff;border:1.5px solid #e2e8f0;border-radius:18px;overflow:hidden;box-shadow:0 4px 24px rgba(15,45,110,.07);}
.cal-stripe{height:5px;background:linear-gradient(90deg,#0f2d6e,#1a56db,#3b82f6);}
.cal-body{padding:20px;}

/* FullCalendar overrides */
.fc{font-family:inherit!important;}
.fc .fc-toolbar-title{font-size:1.1rem!important;font-weight:800!important;color:#0f172a!important;}
.fc .fc-button{background:linear-gradient(135deg,#0f2d6e,#1a56db)!important;border:none!important;border-radius:9px!important;font-size:12.5px!important;font-weight:700!important;padding:6px 14px!important;box-shadow:none!important;}
.fc .fc-button:hover{filter:brightness(1.15)!important;}
.fc .fc-button:focus,.fc .fc-button-active{box-shadow:none!important;outline:none!important;}
.fc .fc-daygrid-day-number,.fc .fc-col-header-cell-cushion{color:#475569!important;font-weight:700!important;font-size:12.5px!important;}
.fc .fc-day-today{background:#f0f7ff!important;}
.fc .fc-day-today .fc-daygrid-day-number{background:#1a56db!important;color:#fff!important;border-radius:50%!important;width:26px!important;height:26px!important;display:inline-flex!important;align-items:center!important;justify-content:center!important;}
.fc-event{border:none!important;border-radius:6px!important;font-size:12px!important;font-weight:600!important;padding:2px 6px!important;cursor:pointer!important;}
.fc .fc-popover{border-radius:12px!important;border:1.5px solid #e2e8f0!important;box-shadow:0 8px 32px rgba(15,45,110,.14)!important;}

/* ── Event popup ── */
.ev-popup{position:fixed;background:#fff;border:1.5px solid #e2e8f0;border-radius:16px;box-shadow:0 16px 48px rgba(15,45,110,.18);width:298px;z-index:9999;overflow:hidden;animation:popIn .18s ease;display:none;}
@keyframes popIn{from{opacity:0;transform:scale(.94);}to{opacity:1;transform:scale(1);}}
.ev-stripe{height:4px;}
.ev-body{padding:16px 16px 14px;position:relative;}
.ev-close{position:absolute;top:8px;right:8px;background:rgba(0,0,0,.06);border:none;border-radius:6px;width:24px;height:24px;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:11px;color:#64748b;transition:background .18s;}
.ev-close:hover{background:rgba(0,0,0,.12);}
.ev-title{font-size:14.5px;font-weight:800;color:#0f172a;margin:0 0 12px;padding-right:22px;}
.ev-row{display:flex;align-items:flex-start;gap:8px;font-size:12.5px;color:#475569;margin-bottom:6px;}
.ev-row i{color:#94a3b8;width:14px;flex-shrink:0;margin-top:2px;}

.sb{font-size:11px;font-weight:700;padding:3px 9px;border-radius:20px;display:inline-flex;align-items:center;gap:4px;}
.sb-upcoming{background:#dbeafe;color:#1d4ed8;}
.sb-ongoing{background:#dcfce7;color:#15803d;}
.sb-completed{background:#e0e7ff;color:#3730a3;}
.sb-cancelled{background:#fee2e2;color:#b91c1c;}
.sb-rescheduled{background:#fef9c3;color:#b45309;}
</style>
@endpush

@section('content')
@php
    $programs    = $programs    ?? collect();
    $departments = $departments ?? collect();
    $active      = $programs->whereIn('status',['upcoming','ongoing'])->count();

    $dotColor = ['upcoming'=>'#3b82f6','ongoing'=>'#16a34a','completed'=>'#6366f1','rescheduled'=>'#f59e0b','cancelled'=>'#ef4444'];
    $statusCounts = [
        'upcoming'    => $programs->where('status','upcoming')->count(),
        'ongoing'     => $programs->where('status','ongoing')->count(),
        'completed'   => $programs->where('status','completed')->count(),
        'rescheduled' => $programs->where('status','rescheduled')->count(),
        'cancelled'   => $programs->where('status','cancelled')->count(),
    ];
    $nearest    = $programs->whereIn('status',['upcoming','ongoing'])->sortBy('start_date')->take(5);
    $calEvents  = $programs->map(fn($p) => [
        'id'              => $p->id,
        'title'           => $p->title,
        'start'           => $p->start_date->toIso8601String(),
        'end'             => $p->end_date->toIso8601String(),
        'backgroundColor' => $dotColor[$p->status] ?? '#3b82f6',
        'borderColor'     => $dotColor[$p->status] ?? '#3b82f6',
        'textColor'       => '#ffffff',
        'extendedProps'   => [
            'status'  => $p->status,
            'venue'   => $p->venue,
            'dept'    => $p->department->name  ?? '—',
            'dept_id' => $p->department_id,
            'sic'     => $p->staffInCharge->name ?? '—',
            'start_f' => $p->start_date->format('d M Y, h:i A'),
            'end_f'   => $p->end_date->format('d M Y, h:i A'),
        ],
    ]);
@endphp

{{-- Hero --}}
<div class="vc-hero fu">
    <h1><i class="fa fa-calendar-days me-2" style="color:#f59e0b;"></i>Programs Calendar</h1>
    <p>Visual overview of all programs — filter by status or department.</p>
    <div class="hero-bottom">
        <div class="hero-chips">
            <span class="hero-chip"><i class="fa fa-calendar-days"></i>{{ now()->format('F Y') }}</span>
            <span class="hero-chip"><i class="fa fa-circle-play"></i>{{ $active }} active</span>
            <span class="hero-chip"><i class="fa fa-building"></i>{{ $departments->count() }} departments</span>
        </div>
        <div class="view-switcher">
            <a href="{{ route('vc.programs') }}"    class="vs-btn"><i class="fa fa-list"></i> List</a>
            <a href="{{ route('vc.calendar') }}" class="vs-btn active"><i class="fa fa-calendar-days"></i> Calendar</a>
        </div>
    </div>
</div>

{{-- Layout --}}
<div class="cal-layout">

    {{-- Sidebar --}}
    <div class="cal-sidebar fu d1">

        {{-- Status legend --}}
        <div class="side-panel">
            <div class="side-panel-hdr">
                <i class="fa fa-circle-half-stroke" style="background:#f1f5f9;color:#475569;"></i>
                Status Filter
            </div>
            @foreach([['upcoming','#3b82f6','Upcoming'],['ongoing','#16a34a','Ongoing'],['completed','#6366f1','Completed'],['rescheduled','#f59e0b','Rescheduled'],['cancelled','#ef4444','Cancelled']] as [$k,$c,$l])
            <div class="leg-item" data-s="{{ $k }}">
                <div class="leg-dot" style="background:{{ $c }};box-shadow:0 0 0 2px {{ $c }}33;"></div>
                {{ $l }}
                <span class="leg-count">{{ $statusCounts[$k] }}</span>
            </div>
            @endforeach
        </div>

        {{-- Dept filter --}}
        <div class="side-panel">
            <div class="side-panel-hdr">
                <i class="fa fa-building" style="background:#e0e7ff;color:#4338ca;"></i>
                Department
            </div>
            <div class="dept-row active" data-d="all">
                <span class="dept-chk"><i class="fa fa-check"></i></span>All Departments
            </div>
            @foreach($departments as $dept)
            <div class="dept-row" data-d="{{ $dept->id }}">
                <span class="dept-chk"><i class="fa fa-check"></i></span>{{ $dept->name }}
            </div>
            @endforeach
        </div>

        {{-- Coming up --}}
        <div class="side-panel">
            <div class="side-panel-hdr">
                <i class="fa fa-clock" style="background:#dbeafe;color:#1d4ed8;"></i>
                Coming Up
            </div>
            @forelse($nearest as $np)
            <div class="up-item">
                <div class="up-dot" style="background:{{ $np->status==='ongoing'?'#16a34a':'#3b82f6' }};"></div>
                <div>
                    <div class="up-title">{{ Str::limit($np->title,28) }}</div>
                    <div class="up-date">{{ $np->start_date->format('d M Y') }}</div>
                    <div class="up-dept-text">{{ $np->department->name ?? '—' }}</div>
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:20px;color:#94a3b8;font-size:13px;">No upcoming programs.</div>
            @endforelse
        </div>

    </div>

    {{-- Calendar --}}
    <div class="cal-card fu d2">
        <div class="cal-stripe"></div>
        <div class="cal-body">
            <div id="vcCal"></div>
        </div>
    </div>

</div>

{{-- Event popup --}}
<div class="ev-popup" id="evPopup">
    <div class="ev-stripe" id="evStripe"></div>
    <div class="ev-body">
        <button class="ev-close" id="evClose"><i class="fa fa-xmark"></i></button>
        <p class="ev-title" id="evTitle"></p>
        <div class="ev-row"><i class="fa fa-building"></i><span id="evDept"></span></div>
        <div class="ev-row"><i class="fa fa-location-dot"></i><span id="evVenue"></span></div>
        <div class="ev-row"><i class="fa fa-calendar-days"></i><span id="evDates"></span></div>
        <div class="ev-row"><i class="fa fa-user"></i><span id="evSic"></span></div>
        <div style="margin-top:10px;" id="evStatus"></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded',function(){
    var ALL=@json($calEvents);
    var vis=['upcoming','ongoing','completed','rescheduled','cancelled'];
    var dept='all';

    var stripes={upcoming:'linear-gradient(90deg,#1d4ed8,#60a5fa)',ongoing:'linear-gradient(90deg,#15803d,#4ade80)',completed:'linear-gradient(90deg,#4338ca,#818cf8)',rescheduled:'linear-gradient(90deg,#b45309,#fbbf24)',cancelled:'linear-gradient(90deg,#b91c1c,#f87171)'};
    var sbHtml={upcoming:'<span class="sb sb-upcoming">Upcoming</span>',ongoing:'<span class="sb sb-ongoing">Ongoing</span>',completed:'<span class="sb sb-completed">Completed</span>',rescheduled:'<span class="sb sb-rescheduled">Rescheduled</span>',cancelled:'<span class="sb sb-cancelled">Cancelled</span>'};

    function getEv(){
        return ALL.filter(function(e){
            return vis.indexOf(e.extendedProps.status)!==-1&&(dept==='all'||String(e.extendedProps.dept_id)===String(dept));
        });
    }

    var cal=new FullCalendar.Calendar(document.getElementById('vcCal'),{
        initialView:'dayGridMonth',
        headerToolbar:{left:'prev,next today',center:'title',right:'dayGridMonth,timeGridWeek,listWeek'},
        buttonText:{today:'Today',month:'Month',week:'Week',list:'List'},
        events:getEv(),height:'auto',
        eventClick:function(info){openPopup(info.event,info.jsEvent);},
    });
    cal.render();

    var popup=document.getElementById('evPopup');
    document.getElementById('evClose').onclick=function(){popup.style.display='none';};
    document.addEventListener('click',function(e){
        if(!popup.contains(e.target)&&!e.target.closest('.fc-event'))popup.style.display='none';
    });

    function openPopup(ev,jsEv){
        var p=ev.extendedProps,s=p.status;
        document.getElementById('evTitle').textContent=ev.title;
        document.getElementById('evStripe').style.background=stripes[s]||'#1a56db';
        document.getElementById('evDept').textContent=p.dept;
        document.getElementById('evVenue').textContent=p.venue;
        document.getElementById('evDates').textContent=p.start_f+' → '+p.end_f;
        document.getElementById('evSic').textContent=p.sic;
        document.getElementById('evStatus').innerHTML=sbHtml[s]||'';
        popup.style.display='block';
        var x=jsEv.clientX+14,y=jsEv.clientY+14;
        if(x+310>window.innerWidth) x=jsEv.clientX-310;
        if(y+280>window.innerHeight)y=jsEv.clientY-280;
        popup.style.left=x+'px';popup.style.top=y+'px';
    }

    document.querySelectorAll('.leg-item').forEach(function(el){
        el.addEventListener('click',function(){
            var s=this.dataset.s,idx=vis.indexOf(s);
            if(idx===-1){vis.push(s);this.classList.remove('dim');}
            else{vis.splice(idx,1);this.classList.add('dim');}
            cal.removeAllEvents();cal.addEventSource(getEv());
        });
    });

    document.querySelectorAll('.dept-row').forEach(function(el){
        el.addEventListener('click',function(){
            document.querySelectorAll('.dept-row').forEach(function(r){r.classList.remove('active');});
            this.classList.add('active');dept=this.dataset.d;
            cal.removeAllEvents();cal.addEventSource(getEv());
        });
    });
});
</script>
@endpush
