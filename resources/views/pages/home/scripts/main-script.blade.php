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
