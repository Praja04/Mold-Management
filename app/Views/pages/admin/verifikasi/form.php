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
                                    <select class="form-select" id="suplier">
                                        <option value="">Pilih Item</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Part Name:</label>
                                    <select class="form-select" id="items">
                                        <option value="">Pilih Item</option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label class="form-label">Detail Mold</label>
                                    <textarea id="outputTextarea" class="form-control" rows="3" placeholder="..." disabled></textarea>
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
                                    <label class="form-label">Tanggal Update:</label>
                                    <input class="form-control" type="date" id="tanggal_update">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Posisi Mold:</label>
                                    <input class="form-control" type="text" id="posisi_mold">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Gambar Mold:</label>
                                    <input class="form-control" type="file" id="gambar_mold">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Deskripsi Mold:</label>
                                    <input class="form-control" type="text" id="dimensi_mold" disabled><br>
                                    <input class="form-control" type="text" id="deskripsi_mold" placeholder="Tonase...">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Gambar Part:</label>
                                    <input class="form-control" type="file" id="gambar_part">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Deskripsi Part (gr):</label>
                                    <input class="form-control" type="text" id="deskripsi_part" placeholder="Berat Part...">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Gambar Runner:</label>
                                    <input class="form-control" type="file" id="gambar_runner">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Deskripsi Runner (gr):</label>
                                    <input class="form-control" type="text" id="deskripsi_runner" placeholder="Berat Runner...">
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
                    <!-- /.box -->
                </div>

                <div class="col-lg-12 col-12" id="form4" style="width: 90%;padding-left: 7%;">
                    <!-- Basic Forms -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Form Mold</h4>
                        </div>
                        <!-- /.box-header -->
                        <form id="form4-content">
                            <div class="box-body">
                                <h4 class="mt-0 mb-20">4. Verifikasi Mold:</h4>
                                <h5 id="namapart3"></h5>
                                <div class="form-group">
                                    <label class="form-label" for="subject_mold">Mold</label>
                                    <select class="form-select" name="subject_mold" id="subject_mold">
                                        <option value="baru">Baru</option>
                                        <option value="modifikasi">Modifikasi</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="tools">Jig/Tools</label>
                                    <select class="form-select" name="tools" id="tools">
                                        <option value="baru">Baru</option>
                                        <option value="modifikasi">Modifikasi</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="mesin">Mesin</label>
                                    <select class="form-select" name="mesin" id="mesin">
                                        <option value="baru">Baru</option>
                                        <option value="modifikasi">Modifikasi</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="produk">Produk</label>
                                    <select class="form-select" name="produk" id="produk">
                                        <option value="baru">Baru</option>
                                        <option value="modifikasi">Modifikasi</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="proses">Proses</label>
                                    <select class="form-select" name="proses" id="proses">
                                        <option value="baru">Baru</option>
                                        <option value="modifikasi">Modifikasi</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="subcount">Subcount / Suplier</label>
                                    <input class="form-control" type="text" class="form-control" name="subcount" id="subcount" placeholder="Subcount / Suplier" disabled>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="verif_ke">Verifikasi Ke </label>
                                    <input class="form-control" type="number" class="form-control" name="verif_ke" id="verif_ke" placeholder="verifikasi ke">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="lk3">Ada kaitan dengan LK3</label>
                                    <select class="form-select" name="lk3" id="lk3">
                                        <option value="Iya">Iya</option>
                                        <option value="Tidak">Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="spek">Spesifikasi</label>
                                    <textarea class="form-control" rows="3" id="spek" name="spek" placeholder="Spesifikasi"></textarea>
                                </div>
                                <div class="form-group" style="visibility: hidden;">
                                    <label class="form-label" for="hasilverif">Hasil Verifikasi</label>
                                    <input class="form-control" type="hidden" class="form-control" id="hasilverif" name="hasilverif" value="0">
                                    <!-- Set default value for hasilverif -->
                                </div>

                            </div>
                            <!-- /.box-body -->

                        </form>
                    </div>
                    <!-- /.box -->
                </div>

                <div class="col-lg-12 col-12" id="form5" style="width: 90%;padding-left: 7%;">
                    <!-- Basic Forms -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Form Mold</h4>
                        </div>
                        <!-- /.box-header -->
                        <form id="form5-content">
                            <div class="box-body">
                                <h4 class="mt-0 mb-20">5. Lampiran Dimensi:</h4>
                                <h5 id="namapart4"></h5>
                                <div class="form-group">
                                    <label class="form-label">Gambar :</label>
                                    <div class="c-inputs-stacked" style="padding-bottom:10%;">
                                        <input name="group1" type="radio" id="radio_1" value="Vertikal">
                                        <label style="padding-left: 25px; padding-right: 20%;" for="radio_1" class="me-30"><img width="100px" src="<?= base_url() . 'assets/images/dimensi_vertikal.png' ?>" alt=""> Vertikal</label>
                                        <input name="group1" type="radio" id="radio_2" value="Horizontal">
                                        <label style="padding-left: 25px; padding-right: 20%;" for="radio_2" class="me-30"><img width="100px" src="<?= base_url() . 'assets/images/dimensi_horizontal.png' ?>" alt=""> Horizontal </label>
                                    </div>
                                    <div class="box-body">

                                        <div class="table-responsive">
                                            <table id="example1" class="table table-bordered table-separated">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>1</th>
                                                        <th>2</th>
                                                        <th>3</th>
                                                        <th>4</th>
                                                        <th>5</th>
                                                        <th>6</th>
                                                    </tr>

                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>T1</td>
                                                        <td><input style="width : 50px" type="text" id="t1-1"></td>
                                                        <td><input style="width : 50px" type="text" id="t1-2"></td>
                                                        <td><input style="width : 50px" type="text" id="t1-3"></td>
                                                        <td><input style="width : 50px" type="text" id="t1-4"></td>
                                                        <td><input style="width : 50px" type="text" id="t1-5"></td>
                                                        <td><input style="width : 50px" type="text" id="t1-6"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>T2</td>
                                                        <td><input style="width : 50px" type="text" id="t2-1"></td>
                                                        <td><input style="width : 50px" type="text" id="t2-2"></td>
                                                        <td><input style="width : 50px" type="text" id="t2-3"></td>
                                                        <td><input style="width : 50px" type="text" id="t2-4"></td>
                                                        <td><input style="width : 50px" type="text" id="t2-5"></td>
                                                        <td><input style="width : 50px" type="text" id="t2-6"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>T3</td>
                                                        <td><input style="width : 50px" type="text" id="t3-1"></td>
                                                        <td><input style="width : 50px" type="text" id="t3-2"></td>
                                                        <td><input style="width : 50px" type="text" id="t3-3"></td>
                                                        <td><input style="width : 50px" type="text" id="t3-4"></td>
                                                        <td><input style="width : 50px" type="text" id="t3-5"></td>
                                                        <td><input style="width : 50px" type="text" id="t3-6"></td>
                                                    </tr>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                    <!-- checkbox -->
                                </div>
                            </div>

                            <!-- /.box-body -->
                        </form>
                    </div>
                    <!-- /.box -->
                </div>


                <div class="col-lg-12 col-12" id="form6" style="width: 90%;padding-left: 7%;">
                    <!-- Basic Forms -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Form Mold</h4>
                        </div>
                        <!-- /.box-header -->
                        <form id="form6-content">
                            <div class="box-body">
                                <h4>6. Lampiran Visual</h4>
                                <h4 class="box-title text-info mb-0"><i class="ti-info me-15"></i> Informasi</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Part Name</label>
                                            <input type="text" id="namapart5" class="form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Suplier</label>
                                            <input type="text" class="form-control" id="suplier2" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Tanggal Trial</label>
                                            <input type="date" class="form-control" id="tanggal_trial_lampiran_visual">
                                        </div>
                                    </div>

                                </div>
                                <h4 class="box-title text-info mb-0 mt-20"><i class="ti-save me-15"></i> Requirements</h4>
                                <hr class="my-15">
                                <div class="form-group">
                                    <label class="form-label">Item</label>
                                    <input type="text" class="form-control" id="item_lampiran_visual">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">STD</label>
                                    <input type="text" class="form-control" id="std_lampiran_visual">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Actual</label>
                                    <input type="text" class="form-control" id="actual_lampiran_visual">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Remark</label>
                                    <input type="text" class="form-control" id="remark_lampiran_visual">
                                </div>
                                <button type="button" class="btn btn-success" id="submitBtn">Submit</button>
                            </div>

                            <!-- /.box-body -->
                        </form>
                    </div>
                    <!-- /.box -->
                </div>

                <!-- <div class="col-lg-12 col-12" id="form7" style="width: 90%;padding-left: 7%;">
                    
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Form Mold</h4>
                        </div>
                        <form id="form7-content">
                            <div class="box-body">
                                <h4>7. History Perbaikan Mold</h4>
                                <h4 class="box-title text-info mb-0"><i class="ti-info me-15"></i> Informasi</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Part Name</label>
                                            <input type="text" id="namapart6" class="form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Suplier</label>
                                            <input type="text" class="form-control" id="suplier3" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Tanggal update</label>
                                            <input type="date" id="tanggal_update_perbaikan" class="form-control">
                                        </div>
                                    </div>

                                </div>
                                <h4 class="box-title text-info mb-0 mt-20"><i class="ti-save me-15"></i> Requirements</h4>
                                <hr class="my-15">
                                <div class="form-group">
                                    <label class="form-label">Item</label>
                                    <input type="text" class="form-control" id="item_history_perbaikan">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Kondisi Sekarang</label>
                                    <input type="text" class="form-control" id="kondisi_history_perbaikan">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Rencana Perbaikan</label>
                                    <input type="text" class="form-control" id="rencana_perbaikan">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">PIC</label>
                                    <input type="text" class="form-control" id="pic_history_perbaikan">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Tanggal Selesai</label>
                                    <input type="date" class="form-control" id="tanggal_history_perbaikan">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Keterangan</label>
                                    <input type="text" class="form-control" id="keterangan_history_perbaikan">
                                </div>
                                <button type="button" class="btn btn-success" id="submitBtn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div> -->

            </div>
        </section>
    </div>
</div>


<script src="<?=base_url()?>/assets/js/jquery-3.7.1.min.js" type="text/javascript"></script>
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
    });
</script>

<script type="text/javascript">
   const baseUrl = '<?=base_url()?>';
   let moldId = '';
    let suplierId = ''
    $(document).ready(function() {
        let moldId = '';
        let suplierId = '';
        initializeDocument();
    });

    function initializeDocument() {
        loadSuppliers();
        handleSupplierChange();
        handleItemChange();
        $('#submitBtn').on('click', function() {
            submitForm();
        });
    }

    function loadSuppliers() {

        $.ajax({
            url: baseUrl +'usermold',
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
            url: baseUrl + 'supplier/items',
            type: 'GET',
            data: {
                supplier: selectedSupplier
            },
            success: function(response) {
                console.log(response);
                const itemsSelect = $('#items');
                itemsSelect.empty();
                itemsSelect.append('<option value="">Pilih Item</option>');

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
            },
            error: function(xhr, status, error) {
                console.error('Error in AJAX request:', status, error);
            }
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

    function handleSupplierChange() {
        $('#suplier').on('change', function() {
            const selectedSupplier = $(this).val();
            var selectedOption = $(this).find('option:selected');
            suplierId = selectedOption.data('id');
            $('#suplier2').val(selectedSupplier);
            //      $('#suplier3').val(selectedSupplier);
            $('#subcount').val(selectedSupplier);
            console.log('Selected Supplier ID:', suplierId);
            updateItemsDropdown(selectedSupplier);
        });
    }

    function handleItemChange() {
        $('#items').on('change', function() {
            var selectedOption2 = $(this).find('option:selected');
            var madeIn = selectedOption2.data('made-in');
            var status = selectedOption2.data('status');
            var material = selectedOption2.data('material');
            var dimensi = selectedOption2.data('dimensi');
            moldId = selectedOption2.data('id');
            console.log('Selected Items ID:', moldId);
            if (selectedOption2.val()) {
                $('#namapart').text('Part Name: ' + selectedOption2.val());
                $('#namapart2').text('Part Name: ' + selectedOption2.val());
                $('#namapart3').text('Part Name: ' + selectedOption2.val());
                $('#namapart4').text('Part Name: ' + selectedOption2.val());
                $('#namapart5').val(selectedOption2.val());
                //  $('#namapart6').val(selectedOption2.val());
                var dimensiMold = 'Ukuran Dimensi Mold: ' + dimensi;
                var combinedText = 'Made In: ' + madeIn + '\n' + 'Status: ' + status + '\n' + 'Material: ' + material;
                $('#dimensi_mold').val(dimensiMold);
                $('#outputTextarea').val(combinedText);
            } else {
                $('#additionalContent').hide();
                $('#madeInContent').text('');
            }
        });
    }

    function submitForm() {
        var formData = new FormData();
        formData.append('moldIdContent', moldId);
        formData.append('user_id', suplierId);
        formData.append('partname', $('#items').val());
        formData.append('gambar_mold', $('#gambar_mold')[0].files[0]);
        formData.append('deskripsi_mold', $('#deskripsi_mold').val());
        formData.append('gambar_part', $('#gambar_part')[0].files[0]);
        formData.append('deskripsi_part', $('#deskripsi_part').val());
        formData.append('gambar_runner', $('#gambar_runner')[0].files[0]);
        formData.append('deskripsi_runner', $('#deskripsi_runner').val());
        formData.append('tanggal_update', $('#tanggal_update').val());
        formData.append('posisi_mold', $('#posisi_mold').val());
        formData.append('drawing_produk', $('#drawing_produk')[0].files[0]);
        formData.append('subject_mold', $('#subject_mold').val());
        formData.append('tools', $('#tools').val());
        formData.append('mesin', $('#mesin').val());
        formData.append('produk', $('#produk').val());
        formData.append('proses', $('#proses').val());
        formData.append('subcount', $('#subcount').val());
        formData.append('verif_ke', $('#verif_ke').val());
        formData.append('lk3', $('#lk3').val());
        formData.append('spek', $('#spek').val());
        formData.append('hasilverif', '0');

        // Form 5
        var gambarLampiranDimensi = $('input[name="group1"]:checked').val();
        formData.append('lampiran_dimensi', gambarLampiranDimensi);
        formData.append('t1-1', $('#t1-1').val());
        formData.append('t1-2', $('#t1-2').val());
        formData.append('t1-3', $('#t1-3').val());
        formData.append('t1-4', $('#t1-4').val());
        formData.append('t1-5', $('#t1-5').val());
        formData.append('t1-6', $('#t1-6').val());
        formData.append('t2-1', $('#t2-1').val());
        formData.append('t2-2', $('#t2-2').val());
        formData.append('t2-3', $('#t2-3').val());
        formData.append('t2-4', $('#t2-4').val());
        formData.append('t2-5', $('#t2-5').val());
        formData.append('t2-6', $('#t2-6').val());
        formData.append('t3-1', $('#t3-1').val());
        formData.append('t3-2', $('#t3-2').val());
        formData.append('t3-3', $('#t3-3').val());
        formData.append('t3-4', $('#t3-4').val());
        formData.append('t3-5', $('#t3-5').val());
        formData.append('t3-6', $('#t3-6').val());

        // Form 6
        formData.append('tanggal_trial_lampiran_visual', $('#tanggal_trial_lampiran_visual').val());
        formData.append('item_lampiran_visual', $('#item_lampiran_visual').val());
        formData.append('std_lampiran_visual', $('#std_lampiran_visual').val());
        formData.append('actual_lampiran_visual', $('#actual_lampiran_visual').val());
        formData.append('remark_lampiran_visual', $('#remark_lampiran_visual').val());

        // Form 7
        // formData.append('item_history_perbaikan', $('#item_history_perbaikan').val());
        // formData.append('kondisi_history_perbaikan', $('#kondisi_history_perbaikan').val());
        // formData.append('rencana_perbaikan', $('#rencana_perbaikan').val());
        // formData.append('pic_history_perbaikan', $('#pic_history_perbaikan').val());
        // formData.append('tanggal_history_perbaikan', $('#tanggal_history_perbaikan').val());
        // formData.append('keterangan_history_perbaikan', $('#keterangan_history_perbaikan').val());

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
                    $('#form4-content')[0].reset();
                    $('#form5-content')[0].reset();
                    $('#form6-content')[0].reset();
                    // $('#form7-content')[0].reset();
                    setTimeout(function() {
                        location.reload();
                    }, 6000);
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