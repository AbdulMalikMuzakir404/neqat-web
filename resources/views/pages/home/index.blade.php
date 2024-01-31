@extends('layouts.app')

@push('styles')

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
                        <div class="card-icon bg-primary">
                            <i class="far fa-user"></i>
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
                        <div class="card-icon bg-danger">
                            <i class="far fa-newspaper"></i>
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
                        <div class="card-icon bg-warning">
                            <i class="far fa-file"></i>
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
                        <div class="card-icon bg-success">
                            <i class="fas fa-circle"></i>
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

    {{-- COUNT UP --}}
    <script>
        // Siswa Hadir
        const hadirCounters = document.querySelectorAll('.hadirCounter');
        for (let n of hadirCounters) {
            const updateCount = () => {
                const target = +n.getAttribute('data-target');
                const count = +n.innerText;
                const speed = 5000; // change animation speed here
                const inc = target / speed;
                if (count < target) {
                    n.innerText = Math.ceil(count + inc);
                    setTimeout(updateCount, 1);
                } else {
                    n.innerText = target;
                }
            }
            updateCount();
        }

        // Siswa Sakit
        const sakitCounters = document.querySelectorAll('.sakitCounter');
        for (let n of sakitCounters) {
            const updateCount = () => {
                const target = +n.getAttribute('data-target');
                const count = +n.innerText;
                const speed = 5000; // change animation speed here
                const inc = target / speed;
                if (count < target) {
                    n.innerText = Math.ceil(count + inc);
                    setTimeout(updateCount, 1);
                } else {
                    n.innerText = target;
                }
            }
            updateCount();
        }

        // Siswa Izin
        const izinCounters = document.querySelectorAll('.izinCounter');
        for (let n of izinCounters) {
            const updateCount = () => {
                const target = +n.getAttribute('data-target');
                const count = +n.innerText;
                const speed = 5000; // change animation speed here
                const inc = target / speed;
                if (count < target) {
                    n.innerText = Math.ceil(count + inc);
                    setTimeout(updateCount, 1);
                } else {
                    n.innerText = target;
                }
            }
            updateCount();
        }

        // Siswa Alpa
        const alpaCounters = document.querySelectorAll('.alpaCounter');
        for (let n of alpaCounters) {
            const updateCount = () => {
                const target = +n.getAttribute('data-target');
                const count = +n.innerText;
                const speed = 5000; // change animation speed here
                const inc = target / speed;
                if (count < target) {
                    n.innerText = Math.ceil(count + inc);
                    setTimeout(updateCount, 1);
                } else {
                    n.innerText = target;
                }
            }
            updateCount();
        }
    </script>

    {{-- CHART --}}
    <script>
        let absenOptions = {
            series: [{
                name: 'Hadir',
                data: [44, 55, 57, 56, 61, 58, 63, 60, 66, 63, 60, 66]
            }, {
                name: 'Sakit',
                data: [76, 85, 101, 98, 87, 105, 91, 114, 94, 98, 87, 105, ]
            }, {
                name: 'Izin',
                data: [35, 41, 36, 26, 45, 48, 52, 53, 41, 48, 52, 53]
            }, {
                name: 'Alpa',
                data: [76, 85, 101, 98, 87, 105, 91, 114, 94, 76, 85, 101]
            }, ],
            chart: {
                type: 'bar',
                height: 450,
                toolbar: {
                    show: false,
                },
            },
            title: {
                text: "Chart Absensi",
                align: "left",
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September",
                    "Oktober", "November", "Desember"
                ],
            },
            yaxis: {
                show: false,
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "$ " + val + " thousands"
                    }
                }
            }
        };

        let hapaOptions = {
            series: [44, 55],
            chart: {
                width: 400,
                type: 'pie',
            },
            title: {
                text: "Chart Perbandingan Antara Hadir Alpa",
                align: "left",
                margin: 40,
            },
            legend: {
                position: "bottom",
            },
            labels: ["Siswa Hadir", "Siswa Alpa"],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        let sainOptions = {
            series: [44, 55],
            chart: {
                width: 400,
                type: 'pie',
            },
            title: {
                text: "Chart Perbandingan Antara Sakit Izin",
                align: "left",
                margin: 40,
            },
            legend: {
                position: "bottom",
            },
            labels: ["Siswa Sakit", "Siswa Izin"],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };


        let absenChart = new ApexCharts(document.querySelector("#absenChart"), absenOptions);
        absenChart.render();

        let hapaChart = new ApexCharts(document.querySelector("#hapaChart"), hapaOptions);
        hapaChart.render();

        let sainChart = new ApexCharts(document.querySelector("#sainChart"), sainOptions);
        sainChart.render();
    </script>
@endpush
