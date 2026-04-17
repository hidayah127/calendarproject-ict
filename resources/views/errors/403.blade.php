@extends('layouts.app')

@section('title','403 Forbidden')

@push('styles')
<style>

.error-page{
    min-height:70vh;
    display:flex;
    align-items:center;
    justify-content:center;
}

.error-card{
    max-width:520px;
    text-align:center;
    padding:40px;
}

.error-code{
    font-size:90px;
    font-weight:800;
    color:#ef4444;
    line-height:1;
}

.error-title{
    font-size:22px;
    font-weight:700;
    margin-top:10px;
    color:#1e293b;
}

.error-text{
    font-size:14px;
    color:#64748b;
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
            403
        </div>

        <div class="error-title">
            Access Forbidden
        </div>

        <div class="error-text">
            Unauthorized. You do not have access to this area.
        </div>

        <div class="error-btn">

            <a href="{{ url()->previous() }}" class="btn btn-primary">
                <i class="fa fa-arrow-left"></i>
                Go Back
            </a>

        </div>

    </div>

</div>

@endsection