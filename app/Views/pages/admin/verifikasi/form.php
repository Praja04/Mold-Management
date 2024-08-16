<?= $this->extend('template/layout'); ?>

<?= $this->section('content') ?>

<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12 col-12" id="form1" style="width: 90%;padding-left: 7%;">
                    <!-- Basic Forms -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Form Mold</h4>
                        </div>
                        <!-- /.box-header -->
                        <form id="form1-content">
                            <div class="box-body">
                                <h4 class="mt-0 mb-20">1. Data Mold:</h4>
                                <div class="form-group">
                                    <label class="form-label">Supplier:</label>
                                    <input type="text" class="form-control" id="suplier" readonly>

                                </div>
                                <div class="form-group">
                                    <label class="form-label">Part Name:</label>
                                    <input type="text" class="form-control" id="items" readonly>

                                </div>

                            </div>
                        </form>
                    </div>
                    <!-- /.box -->
                </div>

                <div class="col-lg-12 col-12" id="form2" style="width: 90%;padding-left: 7%;">
                    <!-- Basic Forms -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Form Mold</h4>
                        </div>
                        <!-- /.box-header -->
                        <form id="form2-content">
                            <div class="box-body">
                                <h4 class="mt-0 mb-20">2. History Mold:</h4>
                                <h5 id="namapart"></h5>
                                <div class="form-group">
                                    <label class="form-label">Gambar Mold:</label>
                                    <input class="form-control" type="file" id="gambar_mold">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Gambar Part:</label>
                                    <input class="form-control" type="file" id="gambar_part">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Gambar Runner:</label>
                                    <input class="form-control" type="file" id="gambar_runner">
                                </div>
                            </div>

                        </form>
                    </div>
                    <!-- /.box -->
                </div>

                <div class="col-lg-12 col-12" id="form3" style="width: 90%;padding-left: 7%;">
                    <!-- Basic Forms -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Form Mold</h4>
                        </div>
                        <!-- /.box-header -->
                        <form id="form3-content">
                            <div class="box-body">
                                <h4 class="mt-0 mb-20">3. Drawing Produk:</h4>
                                <h5 id="namapart2"></h5>
                                <div class="form-group">
                                    <label class="form-label">Lampiran Drawing (pdf):</label>
                                    <input class="form-control" type="file" id="drawing_produk">
                                </div>

                            </div>
                            <!-- /.box-body -->
                        </form>
                    </div>
                    <button type="button" class="btn btn-success" id="submitBtn">Submit</button>
                    <br><br><!-- /.box -->
                </div>
            </div>
        </section>
    </div>
</div>


<script src="<?= base_url() ?>/assets/js/jquery-3.7.1.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTable without search feature
        var table = $('#example1').DataTable({
            "paging": false,
            "searching": false,
            "lengthChange": false,
            "ordering": true,
            "info": false,
            "language": {
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "Showing 0 to 0 of 0 entries",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "lengthMenu": "Show _MENU_ entries",
                "loadingRecords": "Loading...",
                "processing": "Processing...",
                "zeroRecords": "No matching records found"
            }
        });

        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }
        const suplier = getQueryParam('suplier');
        const namaMold = getQueryParam('nama_mold');
        const idMold = getQueryParam('id_mold');
        const user_id = getQueryParam('user_id');

        if (suplier) {
            $('#suplier').val(suplier);
            $('#suplier2').val(suplier);
            $('#subcount').val(suplier);
        }
        if (namaMold) {
            $('#items').val(namaMold);
            $('#namapart5').val(namaMold);

        }
    });
</script>

<script type="text/javascript">
    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    const suplier = getQueryParam('suplier');
    const namaMold = getQueryParam('nama_mold');
    const idMold = getQueryParam('id_mold');
    const user_id = getQueryParam('user_id');
    const baseUrl = '<?= base_url() ?>';
    let moldId = idMold;
    let suplierId = user_id;
    $(document).ready(function() {

        initializeDocument();
    });

    function initializeDocument() {
        $('#submitBtn').on('click', function() {
            submitForm();
        });
    }


    function showToast(message, isError = false) {
        var submitToast = $('#submitToast');
        if (submitToast.length) {
            if (isError) {
                message = 'Invalid input';
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



    function submitForm() {
        var formData = new FormData();
        formData.append('moldIdContent', moldId);
        formData.append('user_id', suplierId);
        formData.append('partname', $('#items').val());
        formData.append('gambar_mold', $('#gambar_mold')[0].files[0]);
        formData.append('gambar_part', $('#gambar_part')[0].files[0]);
        formData.append('gambar_runner', $('#gambar_runner')[0].files[0]);
        formData.append('drawing_produk', $('#drawing_produk')[0].files[0]);

        $.ajax({
            url: baseUrl + 'submit_verifikasi',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.hasOwnProperty('message')) {
                    showToast(response.message);
                    $('#form1-content')[0].reset();
                    $('#form2-content')[0].reset();
                    $('#form3-content')[0].reset();
                    setTimeout(function() {
                        window.location.href = ('<?= base_url('detail/mold') ?>')
                    }, 2000);
                } else if (response.hasOwnProperty('error')) {
                    showToast(response.error, true);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }
</script>
<?= $this->endSection() ?>