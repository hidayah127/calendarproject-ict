@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card shadow border-0">

                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-key me-2"></i>
                        Forgot Password
                    </h4>
                </div>

                <div class="card-body">

                    <p class="text-muted">
                        Please complete the information below. The ICT Administrator will verify your account and reset your password.
                    </p>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('forgot-password.send') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">
                                AmazingTrack Username
                            </label>

                            <input
                                type="text"
                                name="username"
                                class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Department
                            </label>

                            <select
                                name="department"
                                class="form-select"
                                required>

                                <option value="">Select Department</option>

                                @foreach($departments as $department)
                                    <option value="{{ $department->department_name }}">
                                        {{ $department->department_name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">
                                UPTM Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                placeholder="username@uptm.edu.my"
                                required>
                        </div>

                        <button class="btn btn-primary w-100">
                            <i class="fas fa-paper-plane me-2"></i>
                            Submit Password Reset Request
                        </button>

                    </form>

                </div>

                <div class="card-footer text-center">

                    <small class="text-muted">
                        Need assistance?<br>
                        ICT Department<br>
                        ict@uptm.edu.my
                    </small>

                </div>

            </div>

        </div>
    </div>

</div>

@endsection