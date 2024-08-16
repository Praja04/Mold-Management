<?= $this->extend('template/layout'); ?>

<?= $this->section('content'); ?>
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
                </div>
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="box bg-secondary-light pull-up">
                        <div class="box-body" style="height: 150px;">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center pe-2 justify-content-between">
                                    <div class="d-flex">
                                        <span class="badge badge-dark me-15">User</span>
                                    </div>
                                    <!-- <div class="dropdown">
                                        <form>
                                            <select class="form-select" id="suplier">
                                                <option value="">Pilih Item</option>
                                            </select>
                                        </form>
                                    </div> -->
                                </div>
                                <h4 class="mt-25 mb-5"><?= $totalUser ?> Supplier</h4>
                                <p class="text-fade mb-0 fs-12">Total Supplier</p>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

    </div>
    <!-- Highcharts Section -->
    <div class="row" style="margin-top: 60px;">
        <div class="col-xl-1 col-md-6 col-12"></div>
        <div class="col-xl-3 col-md-6 col-12">
            <h5>Grafik Data Shot Mold</h5>
        </div>
        <div class="col-xl-3 col-md-6 col-12"></div>
        <div class="col-xl-3 col-md-6 col-12">

        </div>
        <div class="col-12">
            <div id="container" style="width: 100%; height: 400px; margin-top: 20px; "></div>
        </div>
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
</div>
<script src="<?= base_url() ?>assets/js/jquery-3.7.1.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/js/highcharts/highcharts.js" type="text/javascript"></script>
<script>
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
</script>


<?= $this->endSection() ?>