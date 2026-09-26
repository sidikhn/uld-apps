@extends('layout.sideBar')

@section('title', 'Dashboard | Mahasiswa Disabilitas')

@section('content')

<main
    id="dashboard-main"
    class="flex-1 min-h-0 overflow-y-auto overscroll-contain
           bg-slate-50 flex flex-col font-sans"
>

    {{-- =========================================================
         TOP HEADER BAR
    ========================================================== --}}
    <div
        id="header-dashboard"
        class="header-dashboard flex shrink-0 items-center justify-between
               w-full bg-[#1B4E71] text-white px-8 py-4 shadow-md
               z-30 sticky top-0 transition-all duration-300"
    >

        {{-- Kiri --}}
        <div class="flex items-center space-x-3">

            <div
                class="p-2.5 bg-white/10 rounded-xl backdrop-blur-sm
                       border border-white/5"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 text-sky-100"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"
                    />
                    <polyline
                        points="9 22 9 12 15 12 15 22"
                    />
                </svg>
            </div>

            <span class="font-bold text-2xl tracking-wide">
                Dashboard
            </span>

        </div>


        {{-- Kanan --}}
        <a
            href="https://wa.me/6282227021332"
            target="_blank"
            rel="noopener noreferrer"
            class="flex items-center space-x-2
                   bg-white/10 hover:bg-white/20
                   px-5 py-2.5 rounded-xl
                   transition-all duration-300
                   backdrop-blur-sm text-sm font-semibold
                   border border-white/10 hover:shadow-lg"
        >

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2.5"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3 21l1.2-4.2A8.959 8.959 0 015 4a8.959 8.959 0 0112.728 12.728A8.959 8.959 0 018.8 19.8L4.2 21z"
                />
            </svg>

            <span>Hubungi Kami</span>

        </a>

    </div>


    {{-- =========================================================
         HERO & STATISTIK
    ========================================================== --}}
    <section
        class="relative shrink-0 bg-cover bg-center
               py-12 md:py-16 px-6
               flex items-center justify-center
               overflow-hidden"
        style="background-image: url('{{ asset('images/fotoKantorULD.jpg') }}');"
    >

        {{-- Overlay --}}
        <div
            class="absolute inset-0
                   bg-gradient-to-br
                   from-[#0a2d44]/95
                   via-[#113854]/90
                   to-[#1B4E71]/85"
        ></div>


        {{-- Konten --}}
        <div
            class="relative text-center text-white
                   max-w-7xl w-full mx-auto z-10"
        >

            <span
                class="inline-block
                       px-4 py-1.5
                       bg-sky-900/40
                       backdrop-blur-md
                       rounded-full
                       text-xs font-bold
                       tracking-widest
                       text-sky-200
                       uppercase
                       mb-4
                       border border-sky-300/20
                       shadow-sm"
            >
                Layanan Inklusi & Disabilitas
            </span>


            <h1
                class="text-3xl md:text-5xl
                       font-extrabold
                       tracking-tight
                       drop-shadow-md"
            >
                DATA MAHASISWA DISABILITAS UGM
            </h1>


            <p
                class="mt-4
                       text-sm md:text-lg
                       text-sky-100/90
                       max-w-3xl mx-auto
                       leading-relaxed
                       font-medium"
            >
                Menyediakan dukungan layanan terbaik bagi mahasiswa
                disabilitas untuk mendukung proses belajar yang inklusif
                dan setara.
            </p>


            {{-- =====================================================
                 STATISTIC CARDS
            ====================================================== --}}
            <div
                class="grid grid-cols-2 md:grid-cols-4
                       gap-4 md:gap-6 mt-10"
            >

                {{-- Card 1 --}}
                <div
                    class="bg-white/10
                           backdrop-blur-md
                           border border-white/20
                           p-6 rounded-3xl
                           shadow-[0_8px_30px_rgb(0,0,0,0.12)]
                           hover:bg-white/20
                           transition-all duration-300
                           group
                           flex flex-col
                           items-center justify-center
                           relative overflow-hidden"
                >

                    <div
                        class="absolute -right-4 -top-4
                               opacity-10
                               group-hover:opacity-20
                               transition-opacity"
                    >
                        <svg
                            class="w-24 h-24"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                d="M9 6a3 3 0 11-6 0 3 3 0 016 0z
                                   M17 6a3 3 0 11-6 0 3 3 0 016 0z
                                   M12.93 17c.046-.327.07-.66.07-1
                                   a6.97 6.97 0 00-1.5-4.33
                                   A5 5 0 0119 16v1h-6.07z
                                   M6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"
                            />
                        </svg>
                    </div>

                    <p
                        class="text-xs md:text-sm
                               font-semibold
                               text-sky-200
                               uppercase tracking-wider"
                    >
                        Mahasiswa Terdata
                    </p>

                    <h2
                        class="text-4xl md:text-5xl
                               font-extrabold mt-2
                               text-white
                               group-hover:scale-110
                               transition-transform duration-300
                               drop-shadow-md"
                    >
                        {{ $totalMahasiswa ?? 0 }}
                    </h2>

                </div>


                {{-- Card 2 --}}
                <div
                    class="bg-white/10
                           backdrop-blur-md
                           border border-white/20
                           p-6 rounded-3xl
                           shadow-[0_8px_30px_rgb(0,0,0,0.12)]
                           hover:bg-white/20
                           transition-all duration-300
                           group
                           flex flex-col
                           items-center justify-center
                           relative overflow-hidden"
                >

                    <div
                        class="absolute -right-4 -top-4
                               opacity-10
                               group-hover:opacity-20
                               transition-opacity"
                    >
                        <svg
                            class="w-24 h-24"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171
                                   a4 4 0 115.656 5.656L10 17.657l-6.828-6.829
                                   a4 4 0 010-5.656z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>

                    <p
                        class="text-xs md:text-sm
                               font-semibold
                               text-sky-200
                               uppercase tracking-wider"
                    >
                        Jenis Disabilitas
                    </p>

                    <h2
                        class="text-4xl md:text-5xl
                               font-extrabold mt-2
                               text-white
                               group-hover:scale-110
                               transition-transform duration-300
                               drop-shadow-md"
                    >
                        {{ $totalJenis ?? 0 }}
                    </h2>

                </div>


                {{-- Card 3 --}}
                <div
                    class="bg-white/10
                           backdrop-blur-md
                           border border-white/20
                           p-6 rounded-3xl
                           shadow-[0_8px_30px_rgb(0,0,0,0.12)]
                           hover:bg-white/20
                           transition-all duration-300
                           group
                           flex flex-col
                           items-center justify-center
                           relative overflow-hidden"
                >

                    <div
                        class="absolute -right-4 -top-4
                               opacity-10
                               group-hover:opacity-20
                               transition-opacity"
                    >
                        <svg
                            class="w-24 h-24"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12
                                   a1 1 0 110 2h-3a1 1 0 01-1-1v-2
                                   a1 1 0 00-1-1H9a1 1 0 00-1 1v2
                                   a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>

                    <p
                        class="text-xs md:text-sm
                               font-semibold
                               text-sky-200
                               uppercase tracking-wider"
                    >
                        Sebaran Fakultas
                    </p>

                    <h2
                        class="text-4xl md:text-5xl
                               font-extrabold mt-2
                               text-white
                               group-hover:scale-110
                               transition-transform duration-300
                               drop-shadow-md"
                    >
                        {{ $totalFakultas ?? 0 }}
                    </h2>

                </div>


                {{-- Card 4 --}}
                <div
                    class="bg-white/10
                           backdrop-blur-md
                           border border-white/20
                           p-6 rounded-3xl
                           shadow-[0_8px_30px_rgb(0,0,0,0.12)]
                           hover:bg-white/20
                           transition-all duration-300
                           group
                           flex flex-col
                           items-center justify-center
                           relative overflow-hidden"
                >

                    <div
                        class="absolute -right-4 -top-4
                               opacity-10
                               group-hover:opacity-20
                               transition-opacity"
                    >
                        <svg
                            class="w-24 h-24"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                d="M10.394 2.08a1 1 0 00-.788 0l-7 3
                                   a1 1 0 000 1.84L5.25 8.051a.999.999
                                   0 01.356-.257l4-1.714a1 1 0 11.788
                                   1.838L7.667 9.088l1.94.831a1 1 0
                                   00.787 0l7-3a1 1 0 000-1.838l-7-3z
                                   M3.31 9.397L5 10.12v4.102a8.969
                                   8.969 0 00-1.05-.174 1 1 0 01-.89-.89
                                   11.115 11.115 0 01.25-3.762z
                                   M9.3 16.573A9.026 9.026 0 007 14.935v-3.957
                                   l1.818.78a3 3 0 002.364 0l5.508-2.361
                                   a11.026 11.026 0 01.22 4.624 1 1 0 01-.868.805
                                   10.852 10.852 0 00-6.742 2.746.5.5 0 01-.7 0z"
                            />
                        </svg>
                    </div>

                    <p
                        class="text-xs md:text-sm
                               font-semibold
                               text-sky-200
                               uppercase tracking-wider"
                    >
                        Jumlah Lulusan
                    </p>

                    <h2
                        class="text-4xl md:text-5xl
                               font-extrabold mt-2
                               text-white
                               group-hover:scale-110
                               transition-transform duration-300
                               drop-shadow-md"
                    >
                        {{ $totalAlumni ?? 0 }}
                    </h2>

                </div>

            </div>
        </div>
    </section>


    {{-- =========================================================
         CHARTS
    ========================================================== --}}
    <div
        class="grid grid-cols-1 lg:grid-cols-2
               gap-8 p-6 md:p-10
               max-w-7xl mx-auto w-full"
    >

        {{-- Chart 1 --}}
        <div
            class="bg-white rounded-3xl
                   shadow-lg
                   border border-slate-100
                   p-6 md:p-8
                   flex flex-col
                   hover:shadow-xl
                   transition-all duration-300"
        >

            <div
                class="flex items-center justify-between
                       mb-6 pb-4
                       border-b border-slate-100"
            >
                <h3
                    class="font-extrabold
                           text-slate-800
                           text-base md:text-xl
                           flex items-center gap-3"
                >
                    <span
                        class="w-3 h-3 rounded-full
                               bg-[#1B4E71] shadow-sm"
                    ></span>

                    Sebaran Mahasiswa di Fakultas
                </h3>
            </div>

            <div class="relative w-full h-[320px]">
                <canvas id="chartFakultas"></canvas>
            </div>

        </div>


        {{-- Chart 2 --}}
        <div
            class="bg-white rounded-3xl
                   shadow-lg
                   border border-slate-100
                   p-6 md:p-8
                   flex flex-col
                   hover:shadow-xl
                   transition-all duration-300"
        >

            <div
                class="flex items-center justify-between
                       mb-6 pb-4
                       border-b border-slate-100"
            >
                <h3
                    class="font-extrabold
                           text-slate-800
                           text-base md:text-xl
                           flex items-center gap-3"
                >
                    <span
                        class="w-3 h-3 rounded-full
                               bg-[#1B4E71] shadow-sm"
                    ></span>

                    Mahasiswa Disabilitas per Tahun Asesmen
                </h3>
            </div>

            <div class="relative w-full h-[320px]">
                <canvas id="chartTahun"></canvas>
            </div>

        </div>


        {{-- Chart 3 --}}
        <div
            class="bg-white rounded-3xl
                   shadow-lg
                   border border-slate-100
                   p-6 md:p-8
                   flex flex-col
                   hover:shadow-xl
                   transition-all duration-300"
        >

            <div
                class="flex items-center justify-between
                       mb-6 pb-4
                       border-b border-slate-100"
            >
                <h3
                    class="font-extrabold
                           text-slate-800
                           text-base md:text-xl
                           flex items-center gap-3"
                >
                    <span
                        class="w-3 h-3 rounded-full
                               bg-[#1B4E71] shadow-sm"
                    ></span>

                    Ragam Disabilitas
                </h3>
            </div>

            <div class="relative w-full h-[320px]">
                <canvas id="chartPie"></canvas>
            </div>

        </div>


        {{-- Chart 4 --}}
        <div
            class="bg-white rounded-3xl
                   shadow-lg
                   border border-slate-100
                   p-6 md:p-8
                   flex flex-col
                   hover:shadow-xl
                   transition-all duration-300"
        >

            <div
                class="flex items-center justify-between
                       mb-6 pb-4
                       border-b border-slate-100"
            >
                <h3
                    class="font-extrabold
                           text-slate-800
                           text-base md:text-xl
                           flex items-center gap-3"
                >
                    <span
                        class="w-3 h-3 rounded-full
                               bg-[#1B4E71] shadow-sm"
                    ></span>

                    Ragam Disabilitas per Tahun Asesmen
                </h3>
            </div>

            <div class="relative w-full h-[320px]">
                <canvas id="chartStacked"></canvas>
            </div>

        </div>

    </div>

</main>


{{-- =============================================================
     CHART.JS
============================================================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* =========================================================
       HEADER SCROLL
       Scroll terjadi pada #dashboard-main, bukan window.
    ========================================================== */

    const dashboardMain = document.getElementById('dashboard-main');
    const headerDashboard = document.getElementById('header-dashboard');

    function updateHeaderStyle() {

        if (!dashboardMain || !headerDashboard) return;

        if (dashboardMain.scrollTop > 10) {

            headerDashboard.classList.add(
                'bg-[#1B4E71]/90',
                'backdrop-blur-lg',
                'border-b',
                'border-white/10'
            );

            headerDashboard.classList.remove(
                'bg-[#1B4E71]'
            );

        } else {

            headerDashboard.classList.add(
                'bg-[#1B4E71]'
            );

            headerDashboard.classList.remove(
                'bg-[#1B4E71]/90',
                'backdrop-blur-lg',
                'border-b',
                'border-white/10'
            );
        }
    }

    updateHeaderStyle();

    if (dashboardMain) {
        dashboardMain.addEventListener(
            'scroll',
            updateHeaderStyle,
            { passive: true }
        );
    }


    /* =========================================================
       CHART GLOBAL CONFIGURATION
    ========================================================== */

    Chart.defaults.font.family =
        "'Inter', 'Segoe UI', Roboto, Helvetica, Arial, sans-serif";

    Chart.defaults.color = '#64748b';

    Chart.defaults.scale.grid.color = '#f1f5f9';


    /* =========================================================
       DATA NORMALIZATION
       Semua null/undefined diamankan sebelum masuk Chart.js.
    ========================================================== */

    const safeArray = (value) => {
        return Array.isArray(value) ? value : [];
    };

    const safeNumber = (value) => {

        const number = Number(value);

        return Number.isFinite(number) ? number : 0;
    };

    const safeLabel = (value, fallback = 'Tidak diketahui') => {

        if (
            value === null ||
            value === undefined ||
            String(value).trim() === ''
        ) {
            return fallback;
        }

        return String(value);
    };


    /* =========================================================
       WARNA DISABILITAS
    ========================================================== */

    const disabilitasColors = {

        netra: '#f59e0b',

        rungu: '#06b6d4',

        mental: '#ec4899',

        fisik: '#1D4ED8',

        'disabilitas ganda': '#10b981',

        ganda: '#10b981',

        lainnya: '#8b5cf6'
    };


    /* =========================================================
       CHART 1 — SEBARAN FAKULTAS
    ========================================================== */

    const fakultasLabelsRaw =
        {!! json_encode($dataFakultas?->pluck('fakultas') ?? []) !!};

    const jumlahPerFakultasRaw =
        {!! json_encode($dataFakultas?->pluck('jumlah') ?? []) !!};


    const fakultasLabels = safeArray(fakultasLabelsRaw)
        .map(label => safeLabel(label));

    const jumlahPerFakultas = safeArray(jumlahPerFakultasRaw)
        .map(value => safeNumber(value));


    const chartFakultasElement =
        document.getElementById('chartFakultas');

    if (chartFakultasElement) {

        new Chart(chartFakultasElement, {

            type: 'bar',

            data: {

                labels: fakultasLabels,

                datasets: [{

                    label: 'Jumlah Mahasiswa',

                    data: jumlahPerFakultas,

                    backgroundColor: 'rgba(27, 78, 113, 0.85)',

                    hoverBackgroundColor: 'rgba(27, 78, 113, 1)',

                    borderRadius: 6,

                    barThickness: 'flex',

                    maxBarThickness: 45
                }]
            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                scales: {

                    x: {
                        grid: {
                            display: false
                        }
                    },

                    y: {

                        beginAtZero: true,

                        border: {
                            display: false
                        },

                        ticks: {
                            precision: 0,
                            padding: 10
                        }
                    }
                },

                plugins: {

                    legend: {
                        display: false
                    },

                    tooltip: {

                        backgroundColor:
                            'rgba(15, 23, 42, 0.9)',

                        padding: 12,

                        cornerRadius: 8
                    }
                }
            }
        });
    }


    /* =========================================================
       CHART 2 — TAHUN ASESMEN
    ========================================================== */

    const tahunLabelsRaw =
        {!! json_encode($tahunData?->pluck('tahun_asesmen') ?? []) !!};

    const jumlahPerTahunRaw =
        {!! json_encode($tahunData?->pluck('jumlah') ?? []) !!};


    const tahunLabels = safeArray(tahunLabelsRaw)
        .map(label => safeLabel(label));

    const jumlahPerTahun = safeArray(jumlahPerTahunRaw)
        .map(value => safeNumber(value));


    const chartTahunElement =
        document.getElementById('chartTahun');

    if (chartTahunElement) {

        new Chart(chartTahunElement, {

            type: 'line',

            data: {

                labels: tahunLabels,

                datasets: [{

                    label: 'Jumlah Mahasiswa (Asesmen)',

                    data: jumlahPerTahun,

                    borderColor: '#1D4ED8',

                    backgroundColor:
                        'rgba(14, 165, 233, 0.15)',

                    borderWidth: 3,

                    tension: 0.4,

                    fill: true,

                    pointRadius: 4,

                    pointBackgroundColor: '#ffffff',

                    pointBorderColor: '#1D4ED8',

                    pointBorderWidth: 2,

                    pointHoverRadius: 6,

                    pointHoverBackgroundColor: '#1D4ED8'
                }]
            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                scales: {

                    x: {
                        grid: {
                            display: false
                        }
                    },

                    y: {

                        beginAtZero: true,

                        border: {
                            display: false
                        },

                        ticks: {
                            precision: 0,
                            padding: 10
                        }
                    }
                },

                plugins: {

                    legend: {
                        display: false
                    },

                    tooltip: {

                        backgroundColor:
                            'rgba(15, 23, 42, 0.9)',

                        padding: 12,

                        cornerRadius: 8,

                        mode: 'index',

                        intersect: false
                    }
                },

                interaction: {

                    mode: 'nearest',

                    axis: 'x',

                    intersect: false
                }
            }
        });
    }


    /* =========================================================
       CHART 3 — DOUGHNUT RAGAM DISABILITAS
    ========================================================== */

    const pieLabelsRaw =
        {!! json_encode($disabilitasData?->pluck('ragam_disabilitas') ?? []) !!};

    const pieDataRaw =
        {!! json_encode($disabilitasData?->pluck('jumlah') ?? []) !!};


    const pieLabels = safeArray(pieLabelsRaw)
        .map(label => safeLabel(label));


    const pieData = safeArray(pieDataRaw)
        .map(value => safeNumber(value));


    const pieColors = pieLabels.map(label => {

        const text = String(label).toLowerCase();

        if (text.includes('ganda')) {
            return disabilitasColors['disabilitas ganda'];
        }

        if (text.includes('netra')) {
            return disabilitasColors.netra;
        }

        if (text.includes('rungu')) {
            return disabilitasColors.rungu;
        }

        if (text.includes('mental')) {
            return disabilitasColors.mental;
        }

        if (text.includes('fisik')) {
            return disabilitasColors.fisik;
        }

        return disabilitasColors.lainnya;
    });


    const chartPieElement =
        document.getElementById('chartPie');

    if (chartPieElement) {

        new Chart(chartPieElement, {

            type: 'doughnut',

            data: {

                labels: pieLabels,

                datasets: [{

                    data: pieData,

                    backgroundColor: pieColors,

                    borderWidth: 0,

                    hoverOffset: 6
                }]
            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                cutout: '65%',

                plugins: {

                    legend: {

                        position: 'right',

                        labels: {

                            usePointStyle: true,

                            padding: 20,

                            font: {
                                size: 13,
                                weight: '500'
                            }
                        }
                    },

                    tooltip: {

                        backgroundColor:
                            'rgba(15, 23, 42, 0.9)',

                        padding: 12,

                        cornerRadius: 8
                    }
                }
            }
        });
    }


    /* =========================================================
       CHART 4 — STACKED DISABILITAS / TAHUN
    ========================================================== */

    const jenisDataRaw =
        {!! json_encode($jenisData ?? []) !!};


    const jenisData = safeArray(jenisDataRaw);


    const tahunJenis = jenisData.map(item => {

        return safeLabel(
            item?.tahun_asesmen,
            'Tidak diketahui'
        );
    });


    const netra = jenisData.map(item =>
        safeNumber(item?.netra)
    );


    const rungu = jenisData.map(item =>
        safeNumber(item?.rungu)
    );


    const mental = jenisData.map(item =>
        safeNumber(item?.mental)
    );


    const fisik = jenisData.map(item =>
        safeNumber(item?.fisik)
    );


    const ganda = jenisData.map(item =>
        safeNumber(item?.ganda)
    );


    const chartStackedElement =
        document.getElementById('chartStacked');

    if (chartStackedElement) {

        new Chart(chartStackedElement, {

            type: 'bar',

            data: {

                labels: tahunJenis,

                datasets: [

                    {
                        label: 'Netra',
                        data: netra,
                        backgroundColor: disabilitasColors.netra,
                        borderRadius: 4
                    },

                    {
                        label: 'Rungu',
                        data: rungu,
                        backgroundColor: disabilitasColors.rungu,
                        borderRadius: 4
                    },

                    {
                        label: 'Mental',
                        data: mental,
                        backgroundColor: disabilitasColors.mental,
                        borderRadius: 4
                    },

                    {
                        label: 'Fisik',
                        data: fisik,
                        backgroundColor: disabilitasColors.fisik,
                        borderRadius: 4
                    },

                    {
                        label: 'Disabilitas Ganda',
                        data: ganda,
                        backgroundColor:
                            disabilitasColors['disabilitas ganda'],
                        borderRadius: 4
                    }

                ]
            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                scales: {

                    x: {

                        stacked: true,

                        grid: {
                            display: false
                        }
                    },

                    y: {

                        stacked: true,

                        beginAtZero: true,

                        border: {
                            display: false
                        },

                        ticks: {
                            precision: 0,
                            padding: 10
                        }
                    }
                },

                plugins: {

                    legend: {

                        position: 'top',

                        labels: {

                            usePointStyle: true,

                            padding: 20,

                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    },

                    tooltip: {

                        backgroundColor:
                            'rgba(15, 23, 42, 0.9)',

                        padding: 12,

                        cornerRadius: 8,

                        mode: 'index',

                        intersect: false
                    }
                },

                interaction: {

                    mode: 'nearest',

                    axis: 'x',

                    intersect: false
                }
            }
        });
    }


    /* =========================================================
       USER MENU
    ========================================================== */

    window.toggleUserMenu = function () {

        const menu =
            document.getElementById('user-menu');

        if (menu) {
            menu.classList.toggle('hidden');
        }
    };

});
</script>

@endsection
