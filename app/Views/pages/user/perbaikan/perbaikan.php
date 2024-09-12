<?= $this->extend('template/layout'); ?>

<?= $this->section('content') ?>

<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="box bg-gradient-primary overflow-hidden pull-up">
                        <div class="box-body pe-0 ps-lg-50 ps-15 py-0">
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-8">
                                    <h1 class="fs-40 text-white"> Perbaikan Besar Mold</h1>

                                </div>
                                <div class="col-12 col-lg-4"><img src="<?= base_url('assets/images/custom-15.svg') ?>" alt=""></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-12" id="form7" style="width: 90%;padding-left: 7%;">
                    <!-- Basic Forms -->
                    <div class="box">

                        <!-- /.box-header -->
                        <form id="form1-content">
                            <div class="box-body">
                                <h4 class="text-center">Form Perbaikan</h4>
                                <h4 class="box-title text-info mb-0"><i class="ti-info me-15"></i> Informasi</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Nama Mold</label>
                                            <?php if ($item) { ?>
                                                <input class="form-control" id="partname" type="text" value="<?= $item ?>" data-id="<?= $id ?>" disabled>
                                            <?php } else { ?>
                                                <select class="form-select" id="partname">
                                                    <option id="partname2"></option>
                                                </select>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Suplier</label>
                                            <input type="text" class="form-control" id="suplier" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Tanggal Report</label>
                                            <input type="date" id="tanggal_perbaikan" class="form-control">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <!-- requirement -->
                                    <br><br>
                                    <h4 class="box-title text-info mb-0 mt-20"><i class="ti-save me-15"></i> Detail Problem</h4>
                                    <hr class="my-15">
                                    <div class="form-group">
                                        <label class="form-label">Kondisi Sekarang</label>
                                        <input type="text" class="form-control" id="kondisi_perbaikan">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Gambar Kerusakan:</label>
                                        <input class="form-control" type="file" id="gambar_rusak">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Keterangan Tambahan</label>
                                        <input type="text" class="form-control" id="keterangan">
                                    </div>

                                </div>
                                <button type="button" class="btn btn-success" id="submitBtn">Submit</button>
                                <!-- /.box-body -->
                        </form>
                    </div>
                    <!-- /.box -->
                </div>

            </div>
        </section>
    </div>
</div>


<script src="<?= base_url() ?>assets/js/jquery-3.7.1.min.js" type="text/javascript"></script>

<script>
    $(document).ready(function() {
        const baseUrl = '<?= base_url() ?>';
        // const waktuSekarang = new Date();
        // const tahun = waktuSekarang.getFullYear();
        // const bulan = waktuSekarang.getMonth() + 1;
        // const tanggal = waktuSekarang.getDate();
        // $('#tanggal_perbaikan').val(`${tanggal}/${bulan}/${tahun}`);
        $('#partname2').text('Pilih');

        $('#partname').change(function() {
            var partName = $(this).val();
            var id = $(this).find('option:selected').data('id');



            var selectedOption = $(this).find('option:selected');
            moldId = selectedOption.data('id');
            console.log(moldId);
        });
        if ($('#partname').is('input')) {
            var moldId = $('#partname').data('id');
            console.log(moldId);
        }

        function getQueryParams() {
            var params = {};
            var queryString = window.location.search.substring(1);
            var queries = queryString.split("&");
            for (var i = 0; i < queries.length; i++) {
                var pair = queries[i].split("=");
                params[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]);
            }
            return params;
        }

        var params = getQueryParams();

        function showToast(message, isError = false) {
            var submitToast = $('#submitToast');
            if (submitToast.length) {
                if (isError) {
                    submitToast.removeClass('bg-success').addClass('bg-danger');
                } else {
                    submitToast.removeClass('bg-danger').addClass('bg-success');
                }
                submitToast.find('.toast-body').html(message);
                submitToast.toast('show');
            } else {
                console.error('Element for toast not found!');
            }
        }

        $('#submitBtn').click(function() {
            submitForm();
        });

        $.ajax({
            url: baseUrl + 'user/getsuplier',
            type: 'GET',
            success: function(response) {
                const data2 = response.data;
                const select = $('#partname');
                const suplier = $('#suplier');
                data2.forEach(function(item) {
                    const option = $('<option></option>')
                        .val(item.ITEM)
                        .text(item.ITEM)
                        .data('id', item.NO);
                    select.append(option);
                    const nama_suplier = item.suplier
                    suplier.val(nama_suplier);
                });

            },
            error: function(error) {
                console.log('Error fetching data:', error);
            }
        });

        function submitForm() {
            var formData = new FormData();
            formData.append('moldId', moldId);
            formData.append('part_name', $('#partname').val());
            formData.append('suplier', $('#suplier').val());
            formData.append('tanggal_pengajuan', $('#tanggal_perbaikan').val());
            formData.append('kondisi_perbaikan', $('#kondisi_perbaikan').val());
            formData.append('keterangan', $('#keterangan').val());
            formData.append('gambar_rusak', $('#gambar_rusak')[0].files[0]);
            $.ajax({
                url: baseUrl + 'submit_perbaikan',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.hasOwnProperty('message')) {
                        showToast(response.message);
                        setTimeout(() => window.location.href = ('<?= base_url('pengajuan/perbaikan') ?>'), 2000);
                    } else if (response.hasOwnProperty('error')) {
                        showToast(response.error, true);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
    });
</script>
<?= $this->endSection() ?>