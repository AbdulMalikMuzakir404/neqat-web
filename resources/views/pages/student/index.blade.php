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
        </section>
    </div>
@endsection

@push('scripts')
@include('pages.student.scripts.main-script')
@endpush
