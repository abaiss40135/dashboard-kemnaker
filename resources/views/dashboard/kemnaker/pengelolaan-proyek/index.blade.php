@extends('templates.dashboard.admin')

@section('content')
    <div class="grid max-[991px]:grid-cols-1 max-[1280px]:grid-cols-2 grid-cols-4 gap-x-4">
        <div class="col-md-6 col-lg-3">
            <x-card-link
                title="Sistem Informasi Tenaga Kerja Nasional (SITKN)"
                desc="Proyek pengembangan platform digital untuk mendata tenaga kerja secara nasional, termasuk pencari kerja, perusahaan, dan pelatihan yang tersedia. Sistem ini akan mempermudah penyelarasan kebutuhan tenaga kerja dengan peluang kerja di seluruh Indonesia."
                action="data-modal-target='proyek-modal' data-modal-toggle='proyek-modal'"
                img-src="https://placehold.co/600x400/png"
            />
        </div>
        <div class="col-md-6 col-lg-3">
            <x-card-link
                title="Program Digitalisasi Pelatihan Kerja"
                desc="Pembuatan modul pelatihan kerja berbasis digital untuk meningkatkan keterampilan tenaga kerja. Program ini bertujuan menyediakan akses pelatihan secara daring bagi pekerja dan calon pekerja di berbagai daerah, khususnya yang berada di wilayah terpencil."
                action="data-modal-target='proyek-modal' data-modal-toggle='proyek-modal'"
                img-src="https://placehold.co/600x400/png"
            />
        </div>
        <div class="col-md-6 col-lg-3">
            <x-card-link
                title="Revitalisasi Balai Latihan Kerja (BLK)"
                desc="Proyek peningkatan infrastruktur dan fasilitas di Balai Latihan Kerja (BLK) untuk mendukung pelatihan berbasis teknologi terkini, seperti otomasi industri, pengelolaan data, dan keterampilan digital."
                action="data-modal-target='proyek-modal' data-modal-toggle='proyek-modal'"
                img-src="https://placehold.co/600x400/png"
            />
        </div>
        <div class="col-md-6 col-lg-3">
            <x-card-link
                title="Pusat Informasi dan Layanan Pengaduan Pekerja Migran"
                desc="    Proyek pengembangan pusat informasi dan layanan pengaduan yang terintegrasi untuk pekerja migran Indonesia. Sistem ini mencakup saluran komunikasi berbasis aplikasi dan layanan daring untuk menangani permasalahan hukum, pembayaran, atau keselamatan pekerja migran."
                action="data-modal-target='proyek-modal' data-modal-toggle='proyek-modal'"
                img-src="https://placehold.co/600x400/png"
            />
        </div>
        <div class="col-md-6 col-lg-3">
            <x-card-link
                title="Program Ketenagakerjaan Inklusif"
                desc="I    nisiatif untuk meningkatkan akses pekerjaan bagi penyandang disabilitas dengan melibatkan perusahaan-perusahaan mitra. Proyek ini mencakup pelatihan kerja khusus, kemitraan dengan sektor swasta, dan advokasi kebijakan proyek inklusif."
                action="data-modal-target='proyek-modal' data-modal-toggle='proyek-modal'"
                img-src="https://placehold.co/600x400/png"
            />
        </div>
    </div>
@endsection

@push('modals')
    <div
        id="proyek-modal"
        data-modal-backdrop="static"
        tabindex="-1"
        aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[1000] justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full "
    >
        <div class="relative p-4 w-full max-w-7xl max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Detail Proyek
                    </h3>
                    <button
                        type="button"
                        class="waves-effect waves-light btn btn-flat btn-light"
                        data-modal-hide="proyek-modal"
                    >
                        <i class="fa-solid fa-times me-0 fs-24 rounded-3"></i>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4 md:p-5 grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div id="proyek-pie-chart" class="bg-slate-50 rounded-lg w-full h-[400px]"></div>
                    <div id="proyek-s-curve-chart" class="bg-slate-50 rounded-lg w-full h-[400px]"></div>
                    <div id="proyek-bar-chart" class="bg-slate-50 rounded-lg w-full h-[400px] col-span-2"></div>
                </div>
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                    <button
                        data-modal-hide="proyek-modal"
                        type="button"
                        class="ms-auto waves-effect waves-light btn btn-secondary"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script src="{{ asset('assets/vendor_components/echarts/dist/echarts-en.min.js') }}"></script>
    <script>
        const pieChartData = [
            { status: "Todo", count: 45 },
            { status: "Doing", count: 35 },
            { status: "Done", count: 60 },
        ];

        const sCurveData = [
            { date: "2024-12-01", progress: 5, expectation: 10 },
            { date: "2024-12-03", progress: 15, expectation: 15 },
            { date: "2024-12-05", progress: 30, expectation: 30 },
            { date: "2024-12-08", progress: 50, expectation: 55 },
            { date: "2024-12-12", progress: 65, expectation: 70 },
            { date: "2024-12-16", progress: 80, expectation: 85 },
            { date: "2024-12-20", progress: 90, expectation: 92 },
            { date: "2024-12-25", progress: 100, expectation: 100 },
        ];

        const barChartData = [
            { group: "Mockup Design", todo: 20, doing: 15, done: 25 },
            { group: "Insfrastruktur", todo: 15, doing: 10, done: 20 },
            { group: "Code Implementation", todo: 10, doing: 5, done: 15 },
            { group: "Testing", todo: 25, doing: 20, done: 30 },
            { group: "Documentation", todo: 30, doing: 25, done: 35 },
        ];

        const pieChart = echarts.init(document.querySelector("#proyek-pie-chart"));
        pieChart.setOption({
            title: {
                text: 'Task Distribution',
                top: 10,
                left: 10,
            },
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b}: {c} ({d}%)",
            },
            legend: {
                orient: 'vertical',
                right: 10,
                top: 10
            },
            series: [
                {
                    name: 'Task Status',
                    type: 'pie',
                    data: pieChartData.map((data) => ({ value: data.count, name: data.status })),
                },
            ],
        });

        const sCurveChart = echarts.init(document.querySelector("#proyek-s-curve-chart"));
        sCurveChart.setOption({
            title: {
                text: 'Project Progress',
                top: 10,
                left: 10,
            },
            tooltip: {
                trigger: 'axis',
                formatter: "{a} <br/>{b}: {c}%",
            },
            legend: {
                orient: 'vertical',
                top: 10,
                right: 10
            },
            xAxis: {
                type: 'category',
                data: sCurveData.map((data) => data.date),
            },
            yAxis: {
                type: 'value',
                max: 100,
            },
            series: [
                {
                    name: 'Progress',
                    type: 'line',
                    data: sCurveData.map((data) => data.progress),
                },
                {
                    name: 'Expectation',
                    type: 'line',
                    data: sCurveData.map((data) => data.expectation),
                },
            ],
        });

        const barChart = echarts.init(document.querySelector("#proyek-bar-chart"));
        barChart.setOption({
            title: {
                text: 'Group Task Status',
                top: 10,
                left: 10,
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow',
                },
            },
            legend: {
                orient: 'vertical',
                right: 10,
                top: 10
            },
            xAxis: {
                type: 'category',
                data: barChartData.map((data) => data.group),
            },
            yAxis: {
                type: 'value',
            },
            series: [
                {
                    name: 'Todo',
                    type: 'bar',
                    data: barChartData.map((data) => data.todo),
                },
                {
                    name: 'Doing',
                    type: 'bar',
                    data: barChartData.map((data) => data.doing),
                },
                {
                    name: 'Done',
                    type: 'bar',
                    data: barChartData.map((data) => data.done),
                },
            ],
        });

        const resizeCharts = () => {
            pieChart.resize();
            sCurveChart.resize();
            barChart.resize();
        };

        window.addEventListener('resize', resizeCharts);

        const observer = new ResizeObserver(resizeCharts);
        observer.observe(document.querySelector("#proyek-pie-chart").parentElement);
    </script>
@endpush