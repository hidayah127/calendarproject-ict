@extends('layouts.app')

@section('title','Dashboard')
@section('page-title','Dashboard')

@section('content')

<div class="row g-4">

    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card shadow card-hover">
            <div class="card-body">
                <h6>Total Programs</h6>
                <h3 class="text-primary">{{ $totalPrograms ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card shadow card-hover">
            <div class="card-body">
                <h6>Upcoming</h6>
                <h3 class="text-warning">{{ $upcoming ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card shadow card-hover">
            <div class="card-body">
                <h6>Ongoing</h6>
                <h3 class="text-success">{{ $ongoing ?? 0 }}</h3>
            </div>
        </div>
    </div>

</div>

@endsection