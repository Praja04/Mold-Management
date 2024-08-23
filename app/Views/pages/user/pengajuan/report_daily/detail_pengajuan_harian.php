<?= $this->extend('template/layout'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">

            <div class="box">
                <div class="box-header with-border text-center">
                    <h3>Report Harian Detail</h3>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example5" class="text-center table table-bordered table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Mold</th>
                                                <th>Jumlah OK</th>
                                                <th>Jumlah NG</th>
                                                <th>Problem Harian</th>
                                                <th>Tanggal Report</th>
                                                <th>Action</th>
                                                <!-- <th >Status</th> -->
                                            </tr>

                                        </thead>
                                        <tbody>
                                            <?php $i = 1;
                                            foreach ($historyReport as $user) : ?>
                                                <tr>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $user['nama_mold']; ?></td>
                                                    <td><?= $user['jumlah_ok']; ?></td>
                                                    <td><?= $user['jumlah_ng']; ?></td>
                                                    <td>
                                                        <?php if ($user['problem_harian'] != null) : ?>
                                                            <?= $user['problem_harian']; ?>
                                                        <?php else : ?>
                                                            <p>-</p>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= $user['tanggal_pengajuan'] ?></td>
                                                    <td>
                                                        <button data-bs-toggle="modal" data-bs-target="#modal-right" data-id="<?= $user['id'] ?>" data-id-mold="<?= $user['id_mold'] ?>" data-nama-mold="<?= $user['nama_mold']; ?>" data-tanggal="<?= $user['tanggal_pengajuan'] ?>" data-problem="<?= $user['problem_harian'] ?>" class="btn btn-warning" style="margin: 3px;">Update</button>
                                                        <button id="delete-btn" style="margin:3px;" type="button" class="btn btn-danger btn-delete" data-id="<?= $user['id'] ?>">
                                                            Delete
                                                        </button>
                                                    </td>
                                                    <!-- <td>
                                                        <?php if ($user['is_seen'] != 'no') : ?>
                                                            <button class="btn btn-success">Telah Dilihat</button>
                                                        <?php else : ?>
                                                            <button class="btn btn-danger">Belum dilihat</button>
                                                        <?php endif; ?>
                                                    </td> -->
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="box">
                <div class="box-header with-border text-center">
                    <h3>Report Transaksi Produk
                    </h3>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example6" class="table table-bordered table-striped text-center" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Mold</th>
                                                <th>Jumlah dikirim</th>
                                                <th>Tanggal Dikirim</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            <?php $i = 1;
                                            foreach ($transaksiReport as $user) : ?>
                                                <tr>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $user['nama_mold']; ?></td>
                                                    <td><?= $user['jumlah_produk']; ?></td>
                                                    <td><?= $user['created_at']; ?></td>


                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal center-modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah yakin menghapus data ini ?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal modal-right fade" id="modal-right" tabindex="-1">
                <div class="modal-dialog" style="width:600px;">
                    <div class="modal-content" style="height: max-content;">
                        <div class="modal-header">
                            <h5 class="modal-title">Update Produksi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="form1-content">
                                <div class="box-body">
                                    <input type="hidden" id="id" name="id">
                                    <input type="hidden" id="id_mold" name="id_mold">
                                    <h4>Form Report Harian</h4>
                                    <h4 class="box-title text-info mb-0"><i class="ti-info me-15"></i> Informasi</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Nama Mold</label>
                                                <input class="form-control" id="nama_mold" type="text" disabled>
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
                                                <input type="date" id="tanggal_report" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Material Produk</label>
                                                <select id="material" class="form-select material" name="material[]" required>
                                                    <option value="" disabled selected>Pilih Opsi</option>
                                                    <option value="PP Samsung BJ520">PP Samsung BJ520</option>
                                                    <option value="PP Hyosung J640">PP Hyosung J640</option>
                                                    <option value="PP Basel EP400">PP Basel EP400</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6" id="other-material-container" style="display:none;">
                                            <div class="form-group">
                                                <label class="form-label">Tentukan Materi Lainnya</label>
                                                <input type="text" id="other-material" class="form-control" name="other_material" placeholder="Masukan material lainnya">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <br><br>
                                        <h4 class="box-title text-info mb-0 mt-20"><i class="ti-save me-15"></i>Hasil Produksi </h4>
                                        <hr class="my-15">
                                        <div class="form-group">
                                            <label class="form-label">Jumlah OK Produk</label>
                                            <input id="jumlah_ok" type="number" class="form-control jumlah_ok" name="jumlah_ok[]" required>
                                        </div>
                                        <br><br>
                                        <hr class="my-15">
                                        <div class="form-group">
                                            <label class="form-label">Jumlah NG Produk</label>
                                        </div>
                                        <div id="ng-container">
                                            <div class="ng-item row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Jenis Reject NG</label>
                                                        <select id="jenis_ng" class="form-select jenis_ng" name="jenis_ng[]" required>
                                                            <option value="" disabled selected>Pilih Opsi</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" id="satuan">Jumlah Reject NG</label>
                                                        <input type="number" class="form-control jumlah_ng" name="jumlah_ng[]" required>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary col-md-3" id="addNgBtn">Tambah Reject NG</button>
                                        <div class="col-md-6"></div>
                                        <button type="button" class="btn btn-danger removeNgBtn col-md-3">Hapus</button>

                                    </div>
                                    <div class="row">
                                        <h4 class="box-title text-info mb-0 mt-20"><i class="ti-save me-15"></i>Report Problem Harian</h4>
                                        <hr class="my-15">
                                        <div class="form-group">
                                            <label class="form-label">Keterangan Problem</label>
                                            <input class="form-control" type="text" id="keterangan_problem" placeholder="jika terjadi problem">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer modal-footer-uniform">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="button" id="submitBtn" class="btn btn-primary float-end">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

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


        </section>
        <!-- /.content -->
    </div>
</div>

<script src="<?= base_url() ?>assets/js/jquery-3.7.1.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {

        $('#modal-right').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var namaMold = button.data('nama-mold');
            var id = button.data('id');
            var id_mold = button.data('id-mold');
            var tanggal = button.data('tanggal');
            var problem = button.data('problem');
            var modal = $(this);
            modal.find('#nama_mold').val(namaMold);
            modal.find('#tanggal_report').val(tanggal);
            modal.find('#keterangan_problem').val(problem);
            modal.find('#id').val(id);
            modal.find('#id_mold').val(id_mold);
            console.log(id_mold);
        });
        $('#example5').DataTable({
            // You can add additional configuration options here if needed
            "paging": true, // Enable pagination
            "searching": true, // Enable search functionality
            "info": true, // Show table information
            "lengthChange": true // Allow the user to change the number of rows displayed
        });
        $('#example6').DataTable({
            // You can add additional configuration options here if needed
            "paging": true, // Enable pagination
            "searching": true, // Enable search functionality
            "info": true, // Show table information
            "lengthChange": true // Allow the user to change the number of rows displayed
        });

        $('.btn-delete').on('click', function() {
            deleteId = $(this).data('id');
            $('#deleteModal').modal('show'); // Show the confirmation modal

            $('#modalok').on('click', function() {
                location.reload();
            });
        });

        $('#confirmDeleteBtn').on('click', function() {
            $.ajax({
                url: '<?= base_url('delete/report/'); ?>' + deleteId, // Replace 'controllerName' with your actual controller name
                type: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        $('#deleteModal').modal('hide'); // Hide the modal
                        showModal('Data deleted successfully.');

                    } else {
                        showModal('Failed to delete data.');
                    }
                },
                error: function(xhr, status, error) {
                    showModal('An error occurred: ' + xhr.status + ' ' + xhr.statusText);
                }
            });
        });

        const baseUrl = '<?= base_url() ?>';
        const maxNgItems = 18;
        let ngCount = 1;
        $('#material').change(function() {
            if ($(this).val() === 'Other') {
                $('#other-material-container').show();
            } else {
                $('#other-material-container').hide();
            }
        });

        function updatejenis(element) {
            $.ajax({
                url: baseUrl + 'jenis/perbaikan',
                type: 'GET',
                success: function(response) {
                    element.empty();
                    element.append('<option value="" disabled selected>Pilih Opsi</option>');
                    if (response.error) {
                        console.error(response.error);
                        return;
                    }

                    response.forEach(item => {
                        $('<option></option>')
                            .val(item.val_jenis)
                            .text(item.jenis_perbaikan)
                            .appendTo(element);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error in AJAX request:', status, error);
                }
            });
        }

        function updateSatuanText(index, jenis_dipilih) {
            if (jenis_dipilih == 'setup_mesin' || jenis_dipilih == 'cuci_barel') {
                $(`.satuan[data-index="${index}"]`).text('Jumlah Reject NG (Kilogram)');
            } else {
                $(`.satuan[data-index="${index}"]`).text('Jumlah Reject NG (Pcs)');
            }
        }

        function initializePartname() {
            $.ajax({
                url: baseUrl + 'user/getsuplier',
                type: 'GET',
                success: function(response) {
                    const data2 = response.data;
                    const select = $('#nama_mold');
                    const suplier = $('#suplier');
                    data2.forEach(item => {
                        $('<option></option>')
                            .val(item.ITEM)
                            .text(item.ITEM)
                            .data('id', item.NO)
                            .appendTo(select);
                        suplier.val(item.suplier);
                    });
                },
                error: function(error) {
                    console.log('Error fetching data:', error);
                }
            });
        }

        $('#nama_mold').change(function() {
            moldId = $(this).find('option:selected').data('id');
            console.log(moldId);
        });

        if ($('#nama_mold').is('input')) {
            moldId = $('#nama_mold').data('id');
        } else {
            moldId = $('#nama_mold').find('option:selected').data('id');
        }



        $('#submitBtn').click(function() {
            const requiredInputs = $('#form1-content [required]');
            let allValid = true;
            id = $('#id').val();
            requiredInputs.each(function() {
                if (!$(this).val()) {
                    $(this).addClass('is-invalid');
                    allValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            if (allValid) {
                submitForm(id);
                $('#modalok').on('click', function() {
                    location.reload();
                });
            } else {
                showModal('Please fill out all required fields.', true);
                $('#modalok').on('click', function() {
                    $('#alertModal').modal('hide')
                });
            }
        });

        $('#addNgBtn').click(function() {
            if (ngCount < maxNgItems) {
                const index = ngCount + 1; // Increment for the new item
                const newNgItem = $(`
                <div class="ng-item row" id="ng-item-${index}">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Jenis Reject NG</label>
                            <select class="form-select jenis_ng" name="jenis_ng[]" required data-index="${index}">
                                <option value="" disabled selected>Pilih Opsi</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label satuan" data-index="${index}">Jumlah Reject NG</label>
                            <input type="number" class="form-control" name="jumlah_ng[]" required>
                        </div>
                    </div>
                </div>
            `);
                $('#ng-container').append(newNgItem);
                updatejenis(newNgItem.find('.jenis_ng'));
                ngCount++;
            } else {
                showModal('Maksimal 18 input reject NG', true);
            }
        });

        $(document).on('change', '.jenis_ng', function() {
            const index = $(this).data('index');;
            let jenis_dipilih = $(this).val();
            updateSatuanText(index, jenis_dipilih);
        });

        $(document).on('click', '.removeNgBtn', function() {
            if (ngCount > 1) {
                $('#ng-container .ng-item').last().remove();
                ngCount--;
            } else {
                showModal('Minimal 1 input reject NG harus ada.', true);
            }
        });

        function showModal(message, isError = false) {
            if (message === 'Data submitted successfully!') {
                $('#modalMessage').text('Data Sudah Diverifikasi');
            } else {
                $('#modalMessage').text(message);
            }
            $('#alertModal').modal('show');

            if (callback) {
                $('#alertModal').on('hidden.bs.modal', function() {
                    callback();
                    $(this).off('hidden.bs.modal'); // Menghapus callback setelah dipanggil agar tidak memicu berkali-kali
                });
            }

        }

        function submitForm(id) {
            const formData = new FormData();
            formData.append('moldId', $('#id_mold').val());
            formData.append('nama_mold', $('#nama_mold').val());
            formData.append('jumlah_ok', $('#jumlah_ok').val());
            let selectedMaterial = $('#material').val();
            if (selectedMaterial === 'Other') {
                selectedMaterial = $('#other-material').val();
            }
            formData.append('material', selectedMaterial);
            formData.append('tanggal_report', $('#tanggal_report').val());
            formData.append('problem_harian', $('#keterangan_problem').val());

            // Daftar kolom yang diperbolehkan dari model ReportModel
            const allowedFields = [
                'setup_mesin',
                'cuci_barel',
                'cuci_mold',
                'unfil',
                'bubble',
                'crack',
                'blackdot',
                'undercut',
                'belang',
                'scratch',
                'ejector_mark',
                'flashing',
                'bending',
                'weldline',
                'sinkmark',
                'silver',
                'flow_material',
                'bushing'
            ];

            // Menyimpan nilai yang diisi
            const dataToSend = {};

            $('.ng-item').each(function() {
                const jenis = $(this).find('.jenis_ng').val();
                const jumlah = $(this).find('input[name="jumlah_ng[]"]').val();

                if (jenis && jumlah) {
                    dataToSend[jenis] = jumlah;
                }
            });

            // Menetapkan nilai 0 untuk jenis yang tidak diisi
            allowedFields.forEach(field => {
                if (!dataToSend.hasOwnProperty(field)) {
                    dataToSend[field] = 0;
                }
            });

            // Tambahkan data ke FormData
            Object.keys(dataToSend).forEach(key => {
                formData.append(key, dataToSend[key]);
            });

            $.ajax({
                url: baseUrl + 'update/report/' + id,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.message) {
                        $('#modal-right').modal('hide');
                        showModal(response.message);
                    } else if (response.error) {
                        showModal(response.error, true);
                    }
                },
                error: function(xhr, status, error) {
                    showModal('Terjadi kesalahan saat memproses permintaan.', true);
                }
            });
        }

        // Initialize Partname and jenis for existing elements
        initializePartname();
        updatejenis($('#jenis_ng'));
        $('#jenis_ng').change(function() {
            let jenis_dipilih = $('#jenis_ng').val();
            console.log(jenis_dipilih);
            if (jenis_dipilih == 'setup_mesin' || jenis_dipilih == 'cuci_barel') {
                $(`#satuan`).text('Jumlah Reject NG (Kilogram)');
            } else {
                $(`#satuan`).text('Jumlah Reject NG (Pcs)');
            }
            // $('#satuan').text('Jumlah Reject NG (pcs)');
        });
    });
</script>

<?= $this->endSection() ?>