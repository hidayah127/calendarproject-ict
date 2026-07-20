{{-- Rendered as an HTML fragment and injected into #viewProgramBody by the
     viewProgram() JS in leader/dashboard.blade.php — this is NOT a full page,
     it deliberately has no @extends/@section wrapper. --}}

<div class="d-flex justify-content-between align-items-start mb-3">
    <div>
        <h5 class="mb-1">{{ $program->title }}</h5>
        <span class="text-muted small">{{ optional($program->department)->name }}</span>
    </div>
    <span class="badge status-badge-{{ $program->status }}">{{ ucfirst($program->status) }}</span>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <div class="text-muted small fw-semibold text-uppercase mb-1">Venue</div>
        <div>{{ $program->venue }}</div>
    </div>
    <div class="col-md-6">
        <div class="text-muted small fw-semibold text-uppercase mb-1">Category</div>
        <div><span class="badge category-badge">{{ ucfirst($program->category ?? '—') }}</span></div>
    </div>
    <div class="col-md-6">
        <div class="text-muted small fw-semibold text-uppercase mb-1">Start</div>
        <div>{{ \Carbon\Carbon::parse($program->start_date)->format('d M Y, h:i A') }}</div>
    </div>
    <div class="col-md-6">
        <div class="text-muted small fw-semibold text-uppercase mb-1">End</div>
        <div>{{ \Carbon\Carbon::parse($program->end_date)->format('d M Y, h:i A') }}</div>
    </div>
    <div class="col-md-6">
        <div class="text-muted small fw-semibold text-uppercase mb-1">Staff In Charge</div>
        <div>{{ optional($program->staffInCharge)->name ?? '—' }}</div>
    </div>
</div>

<div class="mb-3">
    <div class="text-muted small fw-semibold text-uppercase mb-1">Description</div>
    <p class="mb-0">{{ $program->description }}</p>
</div>

<div>
    <div class="text-muted small fw-semibold text-uppercase mb-2">Committee</div>
    {{-- Program::committee() is a belongsToMany(Staff::class, 'program_staff') with
         role/responsibility/is_lead as pivot columns, so each item here is a Staff
         model and its program_staff row is reached via ->pivot, not a ProgramStaff
         model with ->staff. --}}
    @if($program->committee && $program->committee->count())
        <div class="table-responsive">
            <table class="table table-sm align-middle mb-0">
                <thead>
                    <tr>
                        <th>Staff</th>
                        <th>Position</th>
                        <th>Role</th>
                        <th>Responsibility</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($program->committee as $member)
                    <tr>
                        <td>
                            {{ $member->name }}
                            @if($member->pivot->is_lead)
                                <span class="badge weekend-badge-sat ms-1">Lead</span>
                            @endif
                        </td>
                        <td>{{ $member->position ?? '—' }}</td>
                        <td><span class="badge category-badge">{{ str_replace('_', ' ', ucfirst($member->pivot->role)) }}</span></td>
                        <td>{{ $member->pivot->responsibility ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-muted small mb-0">No committee members assigned to this program yet.</p>
    @endif
</div>
