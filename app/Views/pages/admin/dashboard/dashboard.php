<?= $this->extend('template/layout'); ?>

<?= $this->section('content'); ?>
<div class="sticky-toolbar" style="width: 110px;border-radius: 10px 0 0 10px; background-color: rgba(108, 117, 125, 0.3);">
    <span class="badge badge-primary">Filter</span>
    <label class="form-label">Tahun :</label>
    <select id="yearFilter" class="form-select"></select>
    <label class="form-label">Bulan :</label>
    <select id="monthFilter" class="form-select">
    </select>
</div>
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <div class="row align-items-end">
                <div class="col-xl-12 col-12">
                    <div class="box bg-primary-light pull-up">
                        <div class="box-body p-xl-0">
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-3">
                                    <img src="<?= base_url() ?>assets/images/custom-14.svg" />
                                </div>
                                <div class="col-12 col-lg-9">
                                    <h2>Hello <?= $adminName ?>, Selamat Datang!</h2>
                                    <p class="text-dark mb-0 fs-16">
                                        Kelola Mold Terbaik CBI Dengan Semangat!
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-md-6 col-12"></div>
                <div class="col-xl-3 col-md-6 col-12">
                    <a href="<?= base_url('products/mold') ?>">
                        <div class="box bg-secondary-light pull-up">
                            <div class="box-body" style="height: 150px;">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center pe-2 justify-content-between">
                                        <div class="d-flex">
                                            <span class="badge badge-primary me-15">Active</span>
                                            <span class="badge badge-primary me-5"><i class="fa fa-lock"></i></span>
                                            <span class="badge badge-primary"><i class="fa fa-clock-o"></i></span>
                                        </div>
                                        <div class="dropdown">

                                        </div>
                                    </div>
                                    <h4 class="mt-25 mb-5"><?= $totalItem ?> Mold</h4>
                                    <p class="text-fade mb-0 fs-12">Total Mold CBI</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-6 col-12">
                    <a href="<?= base_url('suplier/cbi') ?>">
                        <div class="box bg-secondary-light pull-up">
                            <div class="box-body" style="height: 150px;">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center pe-2 justify-content-between">
                                        <div class="d-flex">
                                            <span class="badge badge-dark me-15">User</span>
                                        </div>
                                    </div>
                                    <h4 class="mt-25 mb-5"><?= $totalUser ?> Supplier</h4>
                                    <p class="text-fade mb-0 fs-12">Total Supplier</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>


            </div>

    </div>
    <!-- Highcharts Section -->

    <div class="row" style="margin: 20px;">
        <div class="col-xl-12">
            <div class="box">
                <div class="box-header" id="box-header">
                    <h4 class="box-title">Akumulasi Shot Mold</h4>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="col-lg-1">
                                <form action="">
                                    <select class="form-select" name="filter_ambang_batas" id="filter_ambang_batas">
                                        <option value="above-1.5m">Shot mold > 1,5 juta</option>
                                        <option value="under-1.5m">Shot mold < 1,5 juta</option>
                                    </select>
                                </form>
                            </div>

                            <div id="container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-1 col-md-6 col-12"></div>

        <div class="col-12">
            <div id="container2" style="width: 100%; height: 400px; margin-top: 20px; "></div>
        </div>
        <div class="col-12">
            <div id="container3" style="width: 100%; height: 400px; margin-top: 20px; "></div>
        </div>
        <div class="col-12">
            <div id="container4" style="width: 100%; height: 400px; margin-top: 20px; "></div>
        </div>
        <div class="col-12">
            <div id="container5" style="width: 100%; height: 400px; margin-top: 20px; "></div>
        </div>
    </div>
    </section>
</div>
<div id="loading" style="display: none;">
    <img src="https://i.gifer.com/ZZ5H.gif" alt="Loading..." />
</div>

<script src="<?= base_url() ?>assets/js/jquery-3.7.1.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/js/highcharts/highcharts.js" type="text/javascript"></script>
<!-- <script>
    $(document).ready(async function() {
        // Declare unique variables for storing data
        let accumulatedShotsData = [];
        let reportData = [];
        let perbaikanData = [];
        let rejectionData = [];
        let quantityData = {};

        // Define an async function to fetch and process data
        async function fetchData() {
            try {
                // Fetch data in parallel
                const [shotResponse, reportResponse, perbaikanResponse, rejectionResponse, quantityResponse] = await Promise.all([
                    $.ajax({
                        url: '<?= base_url('akumulasi/shot') ?>',
                        method: 'GET',
                        dataType: 'json'
                    }),
                    $.ajax({
                        url: '<?= base_url('akumulasi/report') ?>',
                        method: 'GET',
                        dataType: 'json'
                    }),
                    $.ajax({
                        url: '<?= base_url('akumulasi/perbaikan') ?>',
                        method: 'GET',
                        dataType: 'json'
                    }),
                    $.ajax({
                        url: '<?= base_url('akumulasi/rejection') ?>',
                        method: 'GET',
                        dataType: 'json'
                    }),
                    $.ajax({
                        url: '<?= base_url('get/quantity') ?>',
                        method: 'GET',
                        dataType: 'json'
                    })
                ]);

                // Process the responses
                accumulatedShotsData = shotResponse.accumulatedShots;
                reportData = reportResponse.jumlah_report;
                perbaikanData = perbaikanResponse.jumlah_perbaikan;
                rejectionData = rejectionResponse.reject;
                quantityData = quantityResponse.data;

                // Call the functions to render charts after data is fetched
                renderCharts();
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        function renderCharts() {
            // Render Akumulasi Shot per Mold chart
            accumulatedShotsData.sort((a, b) => b.total - a.total);
            const categoriesShot = accumulatedShotsData.map(item => item.nama_mold);
            const akumulasiShotData = accumulatedShotsData.map(item => item.total);

            Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Akumulasi Shot per-mold'
                },
                xAxis: {
                    categories: categoriesShot,
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Jumlah Akumulasi Shot'
                    },
                    labels: {
                        formatter: function() {
                            return Highcharts.numberFormat(this.value, 0, '.', ',');
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:,.0f}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Akumulasi Shot',
                    data: akumulasiShotData.map(value => ({
                        y: value,
                        dataLabels: {
                            enabled: true,
                            formatter: function() {
                                return Highcharts.numberFormat(this.y, 0, '.', ',');
                            }
                        }
                    }))
                }]
            });

            // Render Total Jumlah Report Problem Harian per Mold chart
            reportData.sort((a, b) => b.total_reports - a.total_reports);
            const categoriesReport = reportData.map(item => item.mold_name);
            const totalReportsData = reportData.map(item => item.total_reports);

            Highcharts.chart('container2', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Total Jumlah Report Problem Harian per Mold'
                },
                xAxis: {
                    categories: categoriesReport,
                    title: {
                        text: 'Nama Mold'
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Total Report'
                    }
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b>'
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Total Report',
                    data: totalReportsData
                }]
            });

            // Render Total Jumlah Perbaikan Besar per Mold chart
            perbaikanData.sort((a, b) => b.total_perbaikan - a.total_perbaikan);
            const categoriesPerbaikan = perbaikanData.map(item => item.mold_name);
            const totalPerbaikanData = perbaikanData.map(item => item.total_perbaikan);

            Highcharts.chart('container3', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Total Jumlah Perbaikan Besar per Mold'
                },
                xAxis: {
                    categories: categoriesPerbaikan,
                    title: {
                        text: 'Nama Mold'
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Total Perbaikan'
                    }
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b>'
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Total Perbaikan',
                    data: totalPerbaikanData
                }]
            });

            // Render Akumulasi Rejection Mold chart

            const categoriesQuantity = [
                'Setup Mesin', 'Cuci Barel', 'Cuci Mold', 'Unfil', 'Bubble',
                'Crack', 'Blackdot', 'Undercut', 'Belang', 'Scratch',
                'Ejector Mark', 'Flashing', 'Bending', 'Weldline',
                'Sinkmark', 'Silver', 'Flow Material', 'Bushing'
            ];

            const akumulasiRejectionData = [
                quantityData.total_setup_mesin,
                quantityData.total_cuci_barel,
                quantityData.total_cuci_mold,
                quantityData.total_unfil,
                quantityData.total_bubble,
                quantityData.total_crack,
                quantityData.total_blackdot,
                quantityData.total_undercut,
                quantityData.total_belang,
                quantityData.total_scratch,
                quantityData.total_ejector_mark,
                quantityData.total_flashing,
                quantityData.total_bending,
                quantityData.total_weldline,
                quantityData.total_sinkmark,
                quantityData.total_silver,
                quantityData.total_flow_material,
                quantityData.total_bushing
            ];

            Highcharts.chart('container4', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Akumulasi Rejection Mold'
                },
                xAxis: {
                    categories: categoriesQuantity,
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Jumlah Akumulasi Rejection'
                    },
                    labels: {
                        formatter: function() {
                            return Highcharts.numberFormat(this.value, 0, '.', ',');
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:,.0f}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Akumulasi Rejection',
                    data: akumulasiRejectionData.map(value => ({
                        y: value,
                        dataLabels: {
                            enabled: true,
                            formatter: function() {
                                return Highcharts.numberFormat(this.y, 0, '.', ',');
                            }
                        }
                    }))
                }]
            });

            // Render Total Jumlah Rejection per Supplier chart
            rejectionData.sort((a, b) => b.total_jumlah_ng - a.total_jumlah_ng);
            const suppliers = rejectionData.map(item => item.suplier);
            const totalJumlahNgData = rejectionData.map(item => item.total_jumlah_ng);
            Highcharts.chart('container5', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Total Jumlah Rejection per Supplier'
                },
                xAxis: {
                    categories: suppliers,
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Jumlah Rejection'
                    },
                    labels: {
                        formatter: function() {
                            return Highcharts.numberFormat(this.value, 0, '.', ',');
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:,.0f}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Jumlah Reject',
                    data: totalJumlahNgData.map(value => ({
                        y: value,
                        dataLabels: {
                            enabled: true,
                            formatter: function() {
                                return Highcharts.numberFormat(this.y, 0, '.', ',');
                            }
                        }
                    }))
                }]
            });
        }

        // Call the async function to fetch data and render charts
        fetchData();
    });
</script> -->
<script>
    $(document).ready(async function() {
        let accumulatedShotsData = [];
        let reportData = [];
        let perbaikanData = [];
        let rejectionData = [];
        let quantityData = {};

        async function fetchData() {
            try {
                const [shotResponse, reportResponse, perbaikanResponse, rejectionResponse, quantityResponse] = await Promise.all([
                    $.ajax({
                        url: '<?= base_url('akumulasi/shot') ?>',
                        method: 'GET',
                        dataType: 'json'
                    }),
                    $.ajax({
                        url: '<?= base_url('akumulasi/report') ?>',
                        method: 'GET',
                        dataType: 'json'
                    }),
                    $.ajax({
                        url: '<?= base_url('akumulasi/perbaikan') ?>',
                        method: 'GET',
                        dataType: 'json'
                    }),
                    $.ajax({
                        url: '<?= base_url('akumulasi/rejection') ?>',
                        method: 'GET',
                        dataType: 'json'
                    }),
                    $.ajax({
                        url: '<?= base_url('get/quantity') ?>',
                        method: 'GET',
                        dataType: 'json'
                    })
                ]);

                accumulatedShotsData = shotResponse.accumulatedShots;
                reportData = reportResponse.jumlah_report;
                perbaikanData = perbaikanResponse.jumlah_perbaikan;
                rejectionData = rejectionResponse.reject;
                quantityData = quantityResponse.data;
                // Display total shots without filtering
                populateYearFilter();
                populateMonthFilter();
                filterAndRenderCharts();
                renderTotalAkumulasiShots();
                renderTotalAkumulasiRejection();
                $('#filter_ambang_batas').change(function() {
                    var selectedValue = $(this).val();
                    if (selectedValue === 'above-1.5m') {
                        renderFilteredShots(1500000); // Tampilkan mold di atas 1,5 juta
                    } else {
                        renderFilteredShots2(1500000); // Tampilkan semua mold
                    }
                });
                // Populate the filters
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        function populateYearFilter() {
            const now = new Date();
            const currentYear = now.getFullYear();
            const yearFilter = $('#yearFilter');
            yearFilter.empty();

            // Add "All" option
            yearFilter.append('<option value="0">All</option>');

            for (let year = currentYear - 5; year <= currentYear; year++) {
                yearFilter.append(`<option value="${year}">${year}</option>`);
            }

            yearFilter.change(function() {
                const selectedYear = parseInt($(this).val(), 10);
                const selectedMonth = parseInt($('#monthFilter').val(), 10);
                if (selectedYear === 0) {
                    $('#monthFilter').hide(); // Hide month filter
                } else {
                    $('#monthFilter').show(); // Show month filter
                }

                filterAndRenderCharts(selectedYear, selectedMonth);
            });

            // yearFilter.val(currentYear);

        }

        function populateMonthFilter() {
            const now = new Date();
            const months = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            const monthFilter = $('#monthFilter');
            monthFilter.empty();
            months.forEach((month, index) => {
                const monthNumber = index + 1;
                monthFilter.append(`<option value="${monthNumber}">${month}</option>`);
            });

            monthFilter.change(function() {
                const selectedMonth = parseInt($(this).val(), 10);
                const selectedYear = parseInt($('#yearFilter').val(), 10);
                filterAndRenderCharts(selectedYear, selectedMonth);
            });

            const currentMonth = now.getMonth() + 1;
            //monthFilter.val(currentMonth).trigger('change');
        }


        function renderFilteredShots(ambangBatas) {
            const totalShotsByMold = accumulatedShotsData.reduce((acc, shot) => {
                if (!acc[shot.nama_mold]) {
                    acc[shot.nama_mold] = 0;
                }
                acc[shot.nama_mold] += shot.total;
                return acc;
            }, {});

            // Hanya ambil mold yang total shots-nya di atas ambang batas
            const filteredShots = Object.entries(totalShotsByMold)
                .filter(([nama_mold, total]) => total > ambangBatas) // Filter di sini
                .sort((a, b) => b[1] - a[1]); // Sort berdasarkan total shots descending

            // Extract sorted categories (nama_mold) dan values (totalShots)
            const categoriesShot = filteredShots.map(item => item[0]);
            const akumulasiShotData = filteredShots.map(item => item[1]);

            Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Total Keseluruhan Akumulasi Shot per-mold'
                },
                xAxis: {
                    categories: categoriesShot,
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Jumlah Akumulasi Shot'
                    },
                    labels: {
                        formatter: function() {
                            return Highcharts.numberFormat(this.value, 0, '.', ',');
                        }
                    },
                    plotLines: [{
                        color: 'red',
                        width: 2,
                        value: ambangBatas,
                        label: {
                            text: `Warning ${Highcharts.numberFormat(ambangBatas, 0, '.', ',')} shot`,
                            align: 'right',
                            style: {
                                color: 'red',
                                fontWeight: 'bold'
                            }
                        },
                        zIndex: 5
                    }]
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:,.0f}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Akumulasi Shot',
                    data: akumulasiShotData.map(value => ({
                        y: value,
                        dataLabels: {
                            enabled: true,
                            formatter: function() {
                                return Highcharts.numberFormat(this.y, 0, '.', ',');
                            }
                        }
                    }))
                }]
            });
        }

        function renderFilteredShots2(ambangBatas) {
            const totalShotsByMold = accumulatedShotsData.reduce((acc, shot) => {
                if (!acc[shot.nama_mold]) {
                    acc[shot.nama_mold] = 0;
                }
                acc[shot.nama_mold] += shot.total;
                return acc;
            }, {});

            // Hanya ambil mold yang total shots-nya di atas ambang batas
            const filteredShots = Object.entries(totalShotsByMold)
                .filter(([nama_mold, total]) => total < ambangBatas) // Filter di sini
                .sort((a, b) => b[1] - a[1]); // Sort berdasarkan total shots descending

            // Extract sorted categories (nama_mold) dan values (totalShots)
            const categoriesShot = filteredShots.map(item => item[0]);
            const akumulasiShotData = filteredShots.map(item => item[1]);

            Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Total Keseluruhan Akumulasi Shot per-mold'
                },
                xAxis: {
                    categories: categoriesShot,
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Jumlah Akumulasi Shot'
                    },
                    labels: {
                        formatter: function() {
                            return Highcharts.numberFormat(this.value, 0, '.', ',');
                        }
                    },
                    plotLines: [{
                        color: 'red',
                        width: 2,
                        value: ambangBatas,
                        label: {
                            text: `Warning ${Highcharts.numberFormat(ambangBatas, 0, '.', ',')} shot`,
                            align: 'right',
                            style: {
                                color: 'red',
                                fontWeight: 'bold'
                            }
                        },
                        zIndex: 5
                    }]
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:,.0f}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Akumulasi Shot',
                    data: akumulasiShotData.map(value => ({
                        y: value,
                        dataLabels: {
                            enabled: true,
                            formatter: function() {
                                return Highcharts.numberFormat(this.y, 0, '.', ',');
                            }
                        }
                    }))
                }]
            });
        }


        function renderTotalAkumulasiShots() {
            // Group data by `nama_mold` and calculate total shots per mold
            const totalShotsByMold = accumulatedShotsData.reduce((acc, shot) => {
                if (!acc[shot.nama_mold]) {
                    acc[shot.nama_mold] = 0;
                }
                acc[shot.nama_mold] += shot.total;
                return acc;
            }, {});

            // Convert the object to an array of [nama_mold, totalShots] and sort it by totalShots in descending order
            const sortedShots = Object.entries(totalShotsByMold).sort((a, b) => b[1] - a[1]);

            // Extract sorted categories (nama_mold) and values (totalShots)
            const categoriesShot = sortedShots.map(item => item[0]);
            const akumulasiShotData = sortedShots.map(item => item[1]);

            Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Total Keseluruhan Akumulasi Shot per-mold'
                },
                xAxis: {
                    categories: categoriesShot,
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Jumlah Akumulasi Shot'
                    },
                    labels: {
                        formatter: function() {
                            return Highcharts.numberFormat(this.value, 0, '.', ',');
                        }
                    },
                    plotLines: [{
                        color: 'red',
                        width: 2,
                        value: 1500000,
                        label: {
                            text: 'Warning 1,5 juta shot',
                            align: 'right',
                            style: {
                                color: 'red',
                                fontWeight: 'bold'
                            }
                        },
                        zIndex: 5
                    }]
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:,.0f}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Akumulasi Shot',
                    data: akumulasiShotData.map(value => ({
                        y: value,
                        dataLabels: {
                            enabled: true,
                            formatter: function() {
                                return Highcharts.numberFormat(this.y, 0, '.', ',');
                            }
                        }
                    }))
                }]
            });
        }


        function renderTotalAkumulasiRejection() {
            // Group data by `nama_mold` and calculate total shots per mold
            const totalRejectionByMold = rejectionData.reduce((acc, reject) => {
                if (!acc[reject.suplier]) {
                    acc[reject.suplier] = 0;
                }
                acc[reject.suplier] += reject.total_jumlah_ng;
                return acc;
            }, {});

            // Convert the object to an array of [nama_mold, totalShots] and sort it by totalShots in descending order
            const sortedRejct = Object.entries(totalRejectionByMold).sort((a, b) => b[1] - a[1]);

            // Extract sorted categories (nama_mold) and values (totalShots)
            const categoriesReject = sortedRejct.map(item => item[0]);
            const akumulasiRejectData = sortedRejct.map(item => item[1]);

            Highcharts.chart('container5', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Total Keseluruhan Akumulasi Reject per-Supplier'
                },
                xAxis: {
                    categories: categoriesReject,
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Jumlah Akumulasi Rejection'
                    },
                    labels: {
                        formatter: function() {
                            return Highcharts.numberFormat(this.value, 0, '.', ',');
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:,.0f}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Akumulasi Rejection',
                    data: akumulasiRejectData.map(value => ({
                        y: value,
                        dataLabels: {
                            enabled: true,
                            formatter: function() {
                                return Highcharts.numberFormat(this.y, 0, '.', ',');
                            }
                        }
                    }))
                }]
            });
        }


        function filterAndRenderCharts(selectedYear, selectedMonth) {
            if (selectedYear === 0) {
                renderTotalAkumulasiShots();
                renderTotalAkumulasiRejection();
            } else {
                const filteredShots = accumulatedShotsData.filter(item => item.year === selectedYear && item.month === selectedMonth);
                const filteredReports = reportData.filter(item => item.year === selectedYear && item.month === selectedMonth);
                const filteredPerbaikan = perbaikanData.filter(item => item.year === selectedYear && item.month === selectedMonth);
                const filteredRejection = rejectionData.filter(item => item.tahun === selectedYear && item.bulan === selectedMonth);



                renderCharts(filteredShots, filteredReports, filteredPerbaikan, filteredRejection);
            }


        }

        function renderCharts(filteredShots, filteredReports, filteredPerbaikan, filteredRejection) {
            // Akumulasi Shot per-mold chart
            filteredShots.sort((a, b) => b.total - a.total);
            const categoriesShot = filteredShots.map(item => item.nama_mold);
            const akumulasiShotData = filteredShots.map(item => item.total);

            Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Akumulasi Shot per-mold (filtered)'
                },
                xAxis: {
                    categories: categoriesShot,
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Jumlah Akumulasi Shot'
                    },
                    labels: {
                        formatter: function() {
                            return Highcharts.numberFormat(this.value, 0, '.', ',');
                        }
                    },
                    plotLines: [{
                        color: 'red',
                        width: 2,
                        value: 1500000,
                        label: {
                            text: 'Warning 1,5 juta shot',
                            align: 'right',
                            style: {
                                color: 'red',
                                fontWeight: 'bold'
                            }
                        },
                        zIndex: 5
                    }]
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:,.0f}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Akumulasi Shot',
                    data: akumulasiShotData.map(value => ({
                        y: value,
                        dataLabels: {
                            enabled: true,
                            formatter: function() {
                                return Highcharts.numberFormat(this.y, 0, '.', ',');
                            }
                        }
                    }))
                }]
            });

            // Total Jumlah Report Problem Harian per Mold chart
            reportData.sort((a, b) => b.total_reports - a.total_reports);
            const categoriesReport = reportData.map(item => item.mold_name);
            const totalReportsData = reportData.map(item => item.total_reports);

            Highcharts.chart('container2', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Total Jumlah Report Problem Harian per Mold'
                },
                xAxis: {
                    categories: categoriesReport,
                    title: {
                        text: 'Nama Mold'
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Total Report'
                    }
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b>'
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Total Report',
                    data: totalReportsData
                }]
            });

            // Total Jumlah Perbaikan Besar per Mold chart
            perbaikanData.sort((a, b) => b.total_perbaikan - a.total_perbaikan);
            const categoriesPerbaikan = perbaikanData.map(item => item.mold_name);
            const totalPerbaikanData = perbaikanData.map(item => item.total_perbaikan);

            Highcharts.chart('container3', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Total Jumlah Perbaikan Besar per Mold'
                },
                xAxis: {
                    categories: categoriesPerbaikan,
                    title: {
                        text: 'Nama Mold'
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Total Perbaikan'
                    }
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b>'
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Total Perbaikan',
                    data: totalPerbaikanData
                }]
            });

            // Data Rejection dan Kategori
            const categoriesQuantity = [
                'Setup Mesin', 'Cuci Barel', 'Cuci Mold', 'Unfil', 'Bubble',
                'Crack', 'Blackdot', 'Undercut', 'Belang', 'Scratch',
                'Ejector Mark', 'Flashing', 'Bending', 'Weldline',
                'Sinkmark', 'Silver', 'Flow Material', 'Bushing'
            ];

            const akumulasiRejectionData = [
                quantityData.total_setup_mesin || 0,
                quantityData.total_cuci_barel || 0,
                quantityData.total_cuci_mold || 0,
                quantityData.total_unfil || 0,
                quantityData.total_bubble || 0,
                quantityData.total_crack || 0,
                quantityData.total_blackdot || 0,
                quantityData.total_undercut || 0,
                quantityData.total_belang || 0,
                quantityData.total_scratch || 0,
                quantityData.total_ejector_mark || 0,
                quantityData.total_flashing || 0,
                quantityData.total_bending || 0,
                quantityData.total_weldline || 0,
                quantityData.total_sinkmark || 0,
                quantityData.total_silver || 0,
                quantityData.total_flow_material || 0,
                quantityData.total_bushing || 0
            ];

            // Menggabungkan data dan kategori ke dalam satu array
            const dataWithCategories = categoriesQuantity.map((category, index) => ({
                category: category,
                value: akumulasiRejectionData[index]
            }));

            // Mengurutkan dari besar ke kecil
            dataWithCategories.sort((a, b) => b.value - a.value);

            // Memisahkan kembali kategori dan data setelah pengurutan
            const sortedCategories = dataWithCategories.map(item => item.category);
            const sortedData = dataWithCategories.map(item => item.value);

            // Membuat chart
            Highcharts.chart('container4', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Akumulasi Rejection Mold'
                },
                xAxis: {
                    categories: sortedCategories,
                    title: {
                        text: 'Jenis Rejection'
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Jumlah Rejection'
                    }
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b>'
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Jumlah Rejection',
                    data: sortedData
                }]
            });


            const suppliers = [...new Set(filteredRejection.map(item => item.suplier))]; // Changed 'supplier' to 'suplier' based on your data
            const totalRejectionPerSupplierData = suppliers.map(supplier => {
                return filteredRejection
                    .filter(item => item.suplier === supplier) // Changed 'supplier' to 'suplier'
                    .reduce((acc, item) => acc + item.total_jumlah_ng, 0); // Changed 'total_rejection' to 'total_jumlah_ng'
            });

            Highcharts.chart('container5', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Total Jumlah Rejection per Supplier'
                },
                xAxis: {
                    categories: suppliers,
                    title: {
                        text: 'Supplier'
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Jumlah Rejection'
                    }
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b>'
                },
                series: [{
                    name: 'Jumlah Rejection',
                    data: totalRejectionPerSupplierData
                }]
            });

        }

        await fetchData();
    });
</script>


<?= $this->endSection() ?>