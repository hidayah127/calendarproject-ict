@extends('layouts.app')

@section('page-title','Create Program')

@push('styles')
<style>
/* ── Form card ── */
.create-card {
    border: 1.5px solid #e2e8f0 !important;
    border-radius: 18px !important;
    box-shadow: 0 4px 24px rgba(15,45,110,0.07) !important;
    overflow: hidden;
}

.create-card .card-top {
    height: 5px;
    background: linear-gradient(90deg, #0f2d6e, #1a56db, #3b82f6);
}

.create-card .card-header-custom {
    padding: 22px 28px 0;
    background: transparent;
}

.create-card .card-body {
    padding: 24px 28px 28px !important;
}

/* ── Section label ── */
.section-label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: #94a3b8;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.section-label::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #e2e8f0;
}

/* ── Inputs ── */
.form-label {
    font-size: 13.5px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 6px;
}

.form-label .req {
    color: #ef4444;
    margin-left: 2px;
}

.form-control,
.form-select {
    border-radius: 10px !important;
    border: 1.5px solid #e2e8f0 !important;
    font-size: 14.5px !important;
    padding: 11px 14px !important;
    background: #f8faff !important;
    font-family: inherit;
    color: #1e293b;
    transition: border-color .2s, box-shadow .2s;
}

.form-control:focus,
.form-select:focus {
    border-color: #1a56db !important;
    box-shadow: 0 0 0 3px rgba(26,86,219,0.10) !important;
    background: #fff !important;
    outline: none;
}

textarea.form-control {
    resize: vertical;
    min-height: 100px;
}


/* validation errors */
.form-control.is-invalid,
.form-select.is-invalid {
    border-color: #ef4444 !important;
    background-image: none !important;
}

.invalid-feedback {
    font-size: 12.5px !important;
    color: #b91c1c !important;
}

/* Customizing Select2 to match your theme */
.select2-container--default .select2-selection--single {
    border: 1.5px solid #e2e8f0 !important;
    border-radius: 10px !important;
    height: 48px !important;
    background: #f8faff !important;
    display: flex;
    align-items: center;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 46px !important;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #1e293b !important;
    padding-left: 14px !important;
}
.select2-dropdown {
    border: 1.5px solid #e2e8f0 !important;
    border-radius: 10px !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    overflow: hidden;
}

/* ── Date range visual connector ── */
.date-range-wrap {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    gap: 10px;
    align-items: end;
}

.date-range-arrow {
    display: flex;
    align-items: center;
    justify-content: center;
    padding-bottom: 11px;
    color: #94a3b8;
    font-size: 18px;
}

/* ── Buttons ── */
.btn-submit {
    background: linear-gradient(135deg, #0f2d6e, #1a56db);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 12px 28px;
    font-size: 15px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    box-shadow: 0 6px 20px rgba(26,86,219,0.28);
    transition: all .2s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 28px rgba(26,86,219,0.36);
}

.btn-back {
    background: #f1f5f9;
    color: #475569;
    border: none;
    border-radius: 10px;
    padding: 12px 22px;
    font-size: 15px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    transition: background .2s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
}

.btn-back:hover {
    background: #e2e8f0;
    color: #334155;
}

/* ── Tips panel ── */
.tips-card {
    border: 1.5px solid #dbeafe !important;
    border-radius: 14px !important;
    background: #eff6ff !important;
    padding: 20px;
}

.tips-card h6 {
    font-size: 13px;
    font-weight: 700;
    color: #1e40af;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 7px;
}

.tips-card li {
    font-size: 13px;
    color: #1d4ed8;
    margin-bottom: 7px;
    line-height: 1.5;
}

/* ── Alert ── */
.alert-error {
    background: #fef2f2;
    border: 1.5px solid #fecaca;
    border-radius: 12px;
    color: #b91c1c;
    padding: 12px 16px;
    font-size: 13.5px;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 20px;
}
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <h2><i class="fa fa-circle-plus me-2 text-primary"></i>Create Program</h2>
        <nav aria-label="breadcrumb" class="mt-1">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('head.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('head.programs.index') }}">My Programs</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </nav>
    </div>

    <a href="{{ route('head.programs.index') }}" class="btn-back">
        <i class="fa fa-arrow-left"></i> Back
    </a>
</div>


<div class="row g-4">

    {{-- ── Main Form ── --}}
    <div class="col-12 col-xl-8">
        <div class="card create-card">
            <div class="card-top"></div>

            <div class="card-header-custom pt-4">
                <h5 style="font-weight:700;font-size:1.05rem;color:#0f172a;margin:0;">
                    Program Details
                </h5>
                <p style="font-size:13px;color:#64748b;margin-top:4px;">
                    Fill in all required fields to create a new program for your department.
                </p>
            </div>

            <div class="card-body">

                {{-- Validation errors --}}
                @if($errors->any())
                <div class="alert-error">
                    <i class="fa fa-circle-exclamation" style="flex-shrink:0;margin-top:2px;"></i>
                    <div>
                        <strong>Please fix the following:</strong>
                        <ul style="margin:6px 0 0;padding-left:18px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('head.programs.store') }}">
                    @csrf

                    {{-- ── Basic Info ── --}}
                    <p class="section-label"><i class="fa fa-circle-info" style="color:#1a56db;"></i> Basic Information</p>

                    <div class="mb-3">
                        <label class="form-label">Program Title <span class="req">*</span></label>
                        <input type="text"
                               name="title"
                               class="form-control @error('title') is-invalid @enderror"
                               placeholder="e.g. Annual Department Symposium 2025"
                               value="{{ old('title') }}"
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Description<span class="req">*</span></label>
                        <textarea name="description"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Briefly describe the program objectives, audience, or agenda...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>  

                    <div class="mb-4">
                        <label class="form-label">Venue <span class="req">*</span></label>
                        <div style="position:relative;">
                            <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#94a3b8;">
                                <i class="fa fa-location-dot"></i>
                            </span>
                            <input type="text"
                                   name="venue"
                                   class="form-control @error('venue') is-invalid @enderror"
                                   style="padding-left:36px !important;"
                                   placeholder="e.g. Dewan Kuliah A, Block C"
                                   value="{{ old('venue') }}"
                                   required>
                        </div>
                        @error('venue')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ── Schedule ── --}}
                    <p class="section-label"><i class="fa fa-calendar" style="color:#1a56db;"></i> Schedule</p>

                    <div class="date-range-wrap mb-4">
                        <div>
                            <label class="form-label">Start Date & Time <span class="req">*</span></label>
                            <input type="datetime-local"
                                   id="start_date"
                                   name="start_date"
                                   class="form-control @error('start_date') is-invalid @enderror"
                                   value="{{ old('start_date') }}"
                                   required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="date-range-arrow">
                            <i class="fa fa-arrow-right"></i>
                        </div>

                        <div>
                            <label class="form-label">End Date & Time <span class="req">*</span></label>
                            <input type="datetime-local"
                                   id="end_date"
                                   name="end_date"
                                   class="form-control @error('end_date') is-invalid @enderror"
                                   value="{{ old('end_date') }}"
                                   required>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- ── Staff ── --}}
                    <p class="section-label"><i class="fa fa-user-tie" style="color:#1a56db;"></i> Staff Assignment</p>

                    <div class="mb-4">
                        <label class="form-label">Staff in Charge</label>
                        <select name="staff_in_charge_id"
                                class="form-select select-search @error('staff_in_charge_id') is-invalid @enderror">
                            <option value="">— Select staff member (optional) —</option>
                            @foreach($staffList as $staff)
                                <option value="{{ $staff->id }}"
                                    {{ old('staff_in_charge_id') == $staff->id ? 'selected' : '' }}>
                                    {{ $staff->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('staff_in_charge_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div style="font-size:12.5px;color:#94a3b8;margin-top:6px;">
                            <i class="fa fa-circle-info me-1"></i>
                            You can assign a staff member now or update this later.
                        </div>
                    </div>

                    {{-- ── Actions ── --}}
                    <hr style="border-color:#f1f5f9;margin:4px 0 20px;">

                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <button type="submit" class="btn-submit">
                            <i class="fa fa-circle-plus"></i> Create Program
                        </button>
                        <a href="{{ route('head.programs.index') }}" class="btn-back">
                            <i class="fa fa-xmark"></i> Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- ── Tips Panel ── --}}
    <div class="col-12 col-xl-4">

        {{-- Tips --}}
        <div class="tips-card mb-3">
            <h6><i class="fa fa-lightbulb"></i> Tips for a great program</h6>
            <ul style="margin:0;padding-left:18px;">
                <li>Use a clear, descriptive title so staff can identify the program quickly.</li>
                <li>Include the full venue address or room number to avoid confusion.</li>
                <li>Make sure the end date is after the start date.</li>
                <li>Assign a staff in charge so there's a clear point of contact.</li>
                <li>You can reschedule or edit the program later if plans change.</li>
            </ul>
        </div>

        {{-- Status info --}}
        <div class="card" style="border:1.5px solid #e2e8f0 !important;border-radius:14px !important;padding:20px;">
            <h6 style="font-size:13px;font-weight:700;color:#374151;margin-bottom:12px;display:flex;align-items:center;gap:7px;">
                <i class="fa fa-circle-half-stroke" style="color:#1a56db;"></i> Program Statuses
            </h6>
            <div style="display:flex;flex-direction:column;gap:8px;">
                @foreach([
                    ['Upcoming',      '#dbeafe','#1d4ed8', 'Program will be upcoming.'],
                    ['Ongoing',      '#f0fdf4','#15803d', 'Program is live and upcoming.'],
                    ['Rescheduled', '#fefce8','#b45309', 'Dates have been moved.'],
                    ['Cancelled',   '#fef2f2','#b91c1c', 'Program will not proceed.'],
                    ['Completed',   '#e0e7ff','#3730a3', 'Program has concluded.'],
                ] as [$label,$bg,$color,$desc])
                <div style="display:flex;align-items:center;gap:10px;">
                    <span style="background:{{ $bg }};color:{{ $color }};font-size:11px;font-weight:700;padding:3px 9px;border-radius:20px;flex-shrink:0;">
                        {{ $label }}
                    </span>
                    <span style="font-size:12.5px;color:#64748b;">{{ $desc }}</span>
                </div>
                @endforeach
            </div>
        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>

    $(document).ready(function() {
        $('.select-search').select2({
            placeholder: "— Search for a staff member —",
            allowClear: true,
            width: '100%'
        });
    });

    
    document.addEventListener('DOMContentLoaded', function() {
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        // 1. Get current date and time in YYYY-MM-DDTHH:MM format
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        
        const currentDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;

        // 2. Set min attribute for Start Date to "now"
        startDateInput.setAttribute('min', currentDateTime);

        // 3. When Start Date changes, update the min attribute for End Date
        startDateInput.addEventListener('change', function() {
            if (startDateInput.value) {
                // Set the minimum end date to match the start date
                endDateInput.setAttribute('min', startDateInput.value);
                
                // If the current end date value is now invalid (earlier than new start), clear it
                if (endDateInput.value && endDateInput.value < startDateInput.value) {
                    endDateInput.value = startDateInput.value;
                }
            }
        });
        
        // Handle case where old() values exist (validation failed)
        if (startDateInput.value) {
            endDateInput.setAttribute('min', startDateInput.value);
        }
    });
</script>
@endpush