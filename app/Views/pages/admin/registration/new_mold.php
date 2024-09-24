<?= $this->extend('template/layout'); ?>

<?= $this->section('content'); ?>
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
                                    <h1 class="fs-40 text-white">Register Mold CBI</h1>

                                </div>
                                <div class="col-12 col-lg-4"><img src="<?= base_url('assets/images/custom-15.svg') ?>" alt=""></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-12"></div>

                <div class="col-lg-8 col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                Register New Mold
                            </h4>
                        </div>
                        <!-- /.box-header -->
                        <form class="form" id="registerMoldForm" enctype="multipart/form-data">
                            <div class="box-body">
                                <h4 class="box-title text-info mb-0">
                                    <i class="ti-layout me-15"></i> Mold Specification
                                </h4>
                                <hr class="my-15" />
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="form-label">Nama Mold</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="ITEM" name="ITEM" class="form-control" required placeholder="Nama Mold" required />
                                            <span class="input-group-text"><i class="ti-bag"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Gambar Mold :</label>
                                        <input type="file" class="form-control" required name="Gambar_Mold" id="Gambar_Mold">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Made In</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="MADE_IN" name="MADE_IN" class="form-control" required placeholder="Made In" />
                                            <span class="input-group-text"><i class="ti-flag-alt"></i></span> <!-- Ikon diubah -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Status</label>
                                        <div class="input-group mb-3">
                                            <select id="STATUS" name="STATUS" class="form-select" required>
                                                <option value="ACTIVE">Active</option>
                                                <option value="INACTIVE">In Active</option>
                                                <option value="NEW / INACTIVE">NEW / In Active</option>
                                            </select>
                                            <span class="input-group-text"><i class="ti-reload"></i></span> <!-- Ikon diubah -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Material</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="Material" name="Material" class="form-control" required placeholder="Material" />
                                            <span class="input-group-text"><i class="ti-paint-bucket"></i></span> <!-- Ikon diubah -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Tonase</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="TONNAGE" name="TONNAGE" class="form-control" required placeholder="Tonase" />
                                            <span class="input-group-text"><i class="ti-stats-up"></i></span> <!-- Ikon diubah -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Part</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="PART" name="PART" class="form-control" required placeholder="Part" />
                                            <span class="input-group-text"><i class="ti-package"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Runner</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="RUNNER" name="RUNNER" class="form-control" required placeholder="Runner" />
                                            <span class="input-group-text"><i class="ti-layout"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Cycle Time</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="CYCLE_TIME" name="CYCLE_TIME" class="form-control" required placeholder="Cycle Time" />
                                            <span class="input-group-text"><i class="ti-timer"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Dimensi Mold</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="DIMENSI_MOLD" name="DIMENSI_MOLD" class="form-control" required placeholder="Dimensi Mold" />
                                            <span class="input-group-text"><i class="ti-ruler"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Cavity</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="CAVITY" name="CAVITY" class="form-control" required placeholder="Cavity" />
                                            <span class="input-group-text"><i class="ti-layout-grid3-alt"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Core</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="CORE" name="CORE" class="form-control" required placeholder="Core" />
                                            <span class="input-group-text"><i class="ti-target"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Keterangan</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="KETERANGAN" name="KETERANGAN" class="form-control" required placeholder="Keterangan" />
                                            <span class="input-group-text"><i class="ti-info"></i></span>
                                        </div>
                                    </div><br>
                                    <h4 class="box-title text-info mb-0">
                                        <i class="ti-user me-15"></i> User Mold
                                    </h4>
                                    <hr class="my-15" />
                                    <div class="form-group">
                                        <label class="form-label">Supplier</label>
                                        <div class="input-group mb-3">
                                            <select id="supplier" name="supplier" class="form-select" required>
                                                <option value="">Pilih Supplier</option>
                                                <?php foreach ($suppliers as $supplier) : ?>
                                                    <option value="<?= $supplier['suplier']; ?>" data-user-id="<?= $supplier['id']; ?>">
                                                        <?= $supplier['suplier']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <span class="input-group-text"><i class="ti-user"></i></span>
                                        </div>
                                    </div>

                                    <!-- Input hidden untuk user_id -->
                                    <input type="number" id="user_id" name="user_id" style="visibility:hidden;">
                                    <br>
                                    <h4 class="box-title text-info mb-0">
                                        <i class="ti- me-15"></i> Dokumen Mold
                                    </h4>
                                    <hr class="my-15" />
                                    <div class="form-group">
                                        <label class="form-label">Dokumen Mold 1 :</label>
                                        <input type="file" class="form-control" required name="dokumen_mold" id="dokumen_mold">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Dokumen Mold 2 :</label>
                                        <input type="file" class="form-control" name="dokumen_mold2" id="dokumen_mold2">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Dokumen Mold 3 :</label>
                                        <input type="file" class="form-control" name="dokumen_mold3" id="dokumen_mold3">
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer text-center">

                                    <button type="submit" id="submitBtn" class="btn btn-primary">
                                        <i class="ti-save-alt"></i> Save
                                    </button>
                                </div>
                            </div>
                        </form>


                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </section>
        <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="alertModalLabel">Notif</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalMessage">
                        <!-- Message will be inserted here -->
                    </div>
                    <div class="modal-footer">
                        <button id="modalok" type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content -->

        <!-- Modal -->


    </div>
</div>

<script src="<?= base_url() ?>assets/js/jquery-3.7.1.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        let user_id = '';


        $(document).on('change', '.jenis_ng', function() {
            const index = $(this).data('index');
            let jenis_dipilih = $(this).val();
            updateSatuanText(index, jenis_dipilih);
        });

        $('#supplier').on('change', function() {
            var data = $(this).find('option:selected');
            user_id = data.data('user-id');
            $('#user_id').val(user_id);

        });
        $('#tutup').on('click', function() {
            $('#flashModal').modal('hide');
        });

        $('.close').on('click', function() {
            $('#flashModal').modal('hide');
        });

        $('#submitBtn').click(function(e) {
            e.preventDefault(); // Mencegah form submit langsung

            const requiredInputs = $('#registerMoldForm [required]');
            let allValid = true;

            // Loop melalui setiap input yang bersifat required
            requiredInputs.each(function() {
                if (!$(this).val()) {
                    // Jika input tidak terisi, tambahkan kelas is-invalid dan tanda seru
                    $(this).addClass('is-invalid');
                    $(this).parent().find('.input-group-text').html('<i class="ti-alert"></i>'); // Tanda seru
                    allValid = false;
                } else {
                    // Jika input terisi, hapus kelas is-invalid dan kembalikan ikon aslinya
                    $(this).removeClass('is-invalid');
                    let originalIcon = $(this).parent().find('.input-group-text').data('original-icon');
                    $(this).parent().find('.input-group-text').html('<i class="' + originalIcon + '"></i>');
                }
            });

            if (allValid) {
                // Jika semua valid, jalankan fungsi submitForm
                submitForm();
            } else {
                // Tampilkan pesan peringatan jika ada yang belum terisi
                showToast('Tolong isi semua inputan! ', true);
            }
        });

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

        function submitForm() {

            var formData = new FormData();
            formData.append('user_id', user_id);
            formData.append('ITEM', $('#ITEM').val());
            formData.append('MADE_IN', $('#MADE_IN').val());
            formData.append('STATUS', $('#STATUS').val());
            formData.append('Material', $('#Material').val());
            formData.append('TONNAGE', $('#TONNAGE').val());
            formData.append('PART', $('#PART').val());
            formData.append('RUNNER', $('#RUNNER').val());
            formData.append('CYCLE_TIME', $('#CYCLE_TIME').val());
            formData.append('DIMENSI_MOLD', $('#DIMENSI_MOLD').val());
            formData.append('CAVITY', $('#CAVITY').val());
            formData.append('CORE', $('#CORE').val());
            formData.append('KETERANGAN', $('#KETERANGAN').val());
            formData.append('supplier', $('#supplier').val());
            formData.append('Gambar_Mold', $('#Gambar_Mold')[0].files[0]);
            formData.append('dokumen_mold', $('#dokumen_mold')[0].files[0]);
            // Menambahkan dokumen_mold2 dan dokumen_mold3
            formData.append('dokumen_mold2', $('#dokumen_mold2')[0].files[0] || null);
            formData.append('dokumen_mold3', $('#dokumen_mold3')[0].files[0] || null);
            $.ajax({
                url: "<?= base_url('register/action/mold') ?>", // URL untuk proses form
                type: "POST", // Metode pengiriman
                data: formData,
                contentType: false, // Agar jQuery tidak memproses data
                processData: false, // Agar jQuery tidak memproses data
                success: function(response) {
                    // Cek apakah sukses atau gagal
                    if (response.hasOwnProperty('message')) {
                        console.log(user_id);

                        $('#modalok').on('click', function() {
                            window.location.href = '<?= base_url('products/mold') ?>'; // Redirect to the specified URL
                        });
                        showModal(response.message);
                    } else if (response.hasOwnProperty('error')) {
                        showModal(response.error, true);
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error);
                    console.log('text:', xhr);
                    alert('Terjadi kesalahan saat pengiriman data.');
                }
            });
        }

        function showModal(message, callback) {
            if (message === 'Data submitted successfully!') {
                $('#modalMessage').text('Data Sudah Diverifikasi');
            } else {
                $('#modalMessage').text(message);
            }
            $('#alertModal').modal('show');

            if (callback) {
                $('#alertModal').on('hidden.bs.modal', function() {

                    $(this).off('hidden.bs.modal'); // Menghapus callback setelah dipanggil agar tidak memicu berkali-kali
                });
            }
        }

    });
</script>
<?= $this->endSection() ?>