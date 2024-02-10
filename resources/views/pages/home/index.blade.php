@extends('layouts.app')

@section('title')
    <title>Neqat &mdash; Home</title>
@endsection

@push('styles')
@include('pages.home.styles.main-style')
@endpush

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Home</h1>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon" style="background-color: rgb(156, 156, 228)">
                            <i class="bi bi-box-arrow-in-right" style="color: #fff; font-size: 25px;"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Siswa Hadir</h4>
                            </div>
                            <div class="card-body">
                                <div class="hadirCounter" data-target="100">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon" style="background-color: rgb(225, 137, 152)">
                            <i class="bi bi-heart-pulse" style="color: #fff; font-size: 25px;"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Siswa Sakit</h4>
                            </div>
                            <div class="card-body">
                                <div class="sakitCounter" data-target="42">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon" style="background-color: rgb(170, 184, 170)">
                            <i class="bi bi-file-earmark-font" style="color: #fff; font-size: 25px;"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Siswa Izin</h4>
                            </div>
                            <div class="card-body">
                                <div class="izinCounter" data-target="94">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon" style="background-color: rgb(246, 91, 91)">
                            <i class="bi bi-x-circle" style="color: #fff; font-size: 25px;"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Siswa Alpa</h4>
                            </div>
                            <div class="card-body">
                                <div class="alpaCounter" data-target="47">0</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                {{-- CHART ABSEN --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="" id="absenChart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                {{-- CHART PERBANDINGAN HADIR ALPA --}}
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="" id="hapaChart"></div>
                        </div>
                    </div>
                </div>

                {{-- CHART PERBANDINGAN SAKIT IZIN --}}
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="" id="sainChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    @include('pages.home.scripts.main-script')
@endpush
