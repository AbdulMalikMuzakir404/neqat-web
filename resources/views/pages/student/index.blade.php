@extends('layouts.app')

@section('title')
    <title>Neqat &mdash; Student</title>
@endsection

@push('styles')
@include('pages.student.styles.main-style')
@endpush

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Student</h1>
            </div>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Student</li>
                </ol>
            </nav>
        </section>
    </div>
@endsection

@push('scripts')
@include('pages.student.scripts.main-script')
@endpush
