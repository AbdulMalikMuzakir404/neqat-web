@extends('layouts.app')

@push('styles')

@endpush

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Email Verification</h1>
            </div>
        </section>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Verifikasi Alamat Email Anda') }}</div>

                        <div class="card-body">
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                                </div>
                            @endif

                            {{ __('Sebelum melanjutkan, silakan periksa email Anda untuk tautan verifikasi.') }}
                            {{ __('Jika Anda tidak menerima email') }},
                            <form class="d-inline" method="POST" action="{{ route('custome.verification.resend') }}">
                                @csrf
                                <button type="submit"
                                    class="btn btn-link p-0 m-0 align-baseline">{{ __('klik di sini untuk mengirim ulang email') }}</button>.
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush



<!doctype html>
<html>
