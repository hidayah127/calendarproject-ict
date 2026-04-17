@extends('layouts.app')

@section('title','404 Page Not Found')

@push('styles')
<style>

.error-page{
    min-height:70vh;
    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;
}

.error-card{
    max-width:520px;
    padding:40px;
}

.error-code{
    font-size:90px;
    font-weight:800;
    color:#1a56db;
    line-height:1;
}

.error-title{
    font-size:22px;
    font-weight:700;
    margin-top:10px;
    color:#1e293b;
}

.error-text{
    color:#64748b;
    font-size:14px;
    margin-top:10px;
}

.error-btn{
    margin-top:25px;
}

</style>
@endpush


@section('content')

<div class="error-page">

    <div class="card shadow error-card">

        <div class="error-code">
            404
        </div>

        <div class="error-title">
            Page Not Found
        </div>

        <div class="error-text">
            The page you are looking for does not exist or may have been moved.
        </div>

        <div class="error-btn">

            <a href="{{ route('login') }}" class="btn btn-primary">
                <i class="fa fa-home"></i>
                Back to Login
            </a>

        </div>

    </div>

</div>

@endsection