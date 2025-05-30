@extends('layouts.app')

@section('title')
    <title>Neqat &mdash; Attendance</title>
@endsection

@push('styles')
@include('pages.attendance.styles.main-style')
@endpush

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Attendance</h1>
            </div>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Attendance</li>
                </ol>
            </nav>
        </section>
    </div>
@endsection

@push('scripts')
@include('pages.attendance.scripts.main-script')
@endpush
