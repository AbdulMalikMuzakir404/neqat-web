@extends('layouts.app')

@section('title')
    <title>Neqat &mdash; Class Room</title>
@endsection

@push('styles')
@include('pages.classroom.styles.main-style')
@endpush

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Class Room</h1>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
@include('pages.classroom.scripts.main-script')
@endpush
