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
<?=$PASSWORD?>
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
                                    <div class="dropdown">
                                        <form>
                                            <select class="form-select" id="suplier">
                                                <option value="">Pilih Item</option>
                                            </select>
                                        </form>
                                    </div>
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
            <form>
                <div class="input-group">

                    <select name="nama_mold" id="nama_mold" class="form-select">
                        <option value="">Pilih Item</option>
                    </select>
                    <div class="input-group-append">

                        <button class="btn bg-primary" id="submit" type="button"><i class="ti-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12">
            <div id="container" style="width: 100%; height: 400px; margin-top: 20px; "></div>
        </div>
        <div class="col-12">
            <div id="container2" style="width: 100%; height: 400px; margin-top: 20px; "></div>
        </div>
    </div>
    </section>
</div>
</div>
<script src="<?= base_url() ?>assets/js/jquery-3.7.1.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/js/highcharts/highcharts.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        loadSuppliers();
        handleSupplierChange();



        $.ajax({
            url: '<?= base_url('akumulasi/shot') ?>',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                const accumulatedShots = data.accumulatedShots;

                const categories = accumulatedShots.map(item => item.nama_mold);
                const akumulasiShotData = accumulatedShots.map(item => item.akumulasi_shot);

                Highcharts.chart('container', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Accumulated Shots'
                    },
                    xAxis: {
                        categories: categories,
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Jumlah Akumulasi Shot'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
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
                        data: akumulasiShotData
                    }]
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error:', textStatus, errorThrown);
            }
        });

        $.ajax({
            url: '<?= base_url('get/quantity') ?>', // URL to fetch data
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                // Initialize Highcharts
                Highcharts.chart('container2', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Total Jumlah Reject per Category'
                    },
                    xAxis: {
                        categories: [
                            'Setup Mesin',
                            'Cuci Barel',
                            'Cuci Mold',
                            'Unfil',
                            'Bubble',
                            'Crack',
                            'Blackdot',
                            'Undercut',
                            'Belang',
                            'Scratch',
                            'Ejector Mark',
                            'Flashing',
                            'Bending',
                            'Weldline',
                            'Sinkmark',
                            'Silver',
                            'Flow Material',
                            'Bushing'
                        ],
                        title: {
                            text: 'Categories'
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Total Reject Category'
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
                        name: 'Total Reject Category',
                        data: [
                            data.data.total_setup_mesin,
                            data.data.total_cuci_barel,
                            data.data.total_cuci_mold,
                            data.data.total_unfil,
                            data.data.total_bubble,
                            data.data.total_crack,
                            data.data.total_blackdot,
                            data.data.total_undercut,
                            data.data.total_belang,
                            data.data.total_scratch,
                            data.data.total_ejector_mark,
                            data.data.total_flashing,
                            data.data.total_bending,
                            data.data.total_weldline,
                            data.data.total_sinkmark,
                            data.data.total_silver,
                            data.data.total_flow_material,
                            data.data.total_bushing
                        ]
                    }]
                });
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });

    });



    function loadSuppliers() {

        $.ajax({
            url: '<?= base_url('/usermold') ?>',
            type: 'GET',
            success: function(response) {
                const suppliers = response;
                const supplierSelect = $('#suplier');

                suppliers.forEach(function(supplier) {
                    const option = $('<option></option>')
                        .val(supplier.suplier)
                        .text(supplier.suplier)
                        .attr('data-id', supplier.id);
                    supplierSelect.append(option);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error loading suppliers:', status, error);
            }
        });
    }

    function updateItemsDropdown(selectedSupplier) {
        if (!selectedSupplier) return;

        $.ajax({
            url: '<?= base_url('/supplier/items') ?>',
            type: 'GET',
            data: {
                supplier: selectedSupplier
            },
            success: function(response) {
                console.log(response);
                const itemsSelect = $('#nama_mold_reject');
                const namaMoldSelect = $('#nama_mold');
                itemsSelect.empty();
                namaMoldSelect.empty();
                itemsSelect.append('<option value="">Pilih Item</option>');
                namaMoldSelect.append('<option value="">Pilih Item</option>');

                if (response.error) {
                    console.error(response.error);
                    return;
                }

                response.data.forEach(function(item) {
                    const option = $('<option></option>')
                        .val(item.ITEM)
                        .text(item.ITEM)
                        .data('made-in', item.MADE_IN)
                        .data('status', item.STATUS)
                        .data('material', item.MATERIAL)
                        .data('id', item.NO)
                        .data('dimensi', item.DIMENSI_MOLD);
                    itemsSelect.append(option);
                });

                response.data.forEach(function(item) {
                    const option = $('<option></option>')
                        .val(item.ITEM)
                        .text(item.ITEM)
                        .data('made-in', item.MADE_IN)
                        .data('status', item.STATUS)
                        .data('material', item.MATERIAL)
                        .data('id', item.NO)
                        .data('dimensi', item.DIMENSI_MOLD);
                    namaMoldSelect.append(option);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error in AJAX request:', status, error);
            }
        });
    }

    function handleSupplierChange() {
        $('#suplier').on('change', function() {
            const selectedSupplier = $(this).val();
            var selectedOption = $(this).find('option:selected');
            suplierId = selectedOption.data('id');
            $('#suplier2').val(selectedSupplier);
            $('#suplier3').val(selectedSupplier);
            $('#subcount').val(selectedSupplier);
            console.log('Selected Supplier ID:', suplierId);
            updateItemsDropdown(selectedSupplier);
        });
    }
</script>
<?= $this->endSection() ?>