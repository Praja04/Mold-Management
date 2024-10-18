<?= $this->extend('template/layout'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">

            <div class="box">
                <div class="box-header with-border text-center">
                    <h3>Detail Report Perbaikan Besar</h3>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example5" class="table table-bordered table-striped text-center" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Mold</th>
                                                <th>Suplier</th>
                                                <th>Tanggal Pengajuan</th>
                                                <th>Kondisi Mold</th>
                                                <th>Gambar Rusak</th>
                                                <th>Keterangan Tambahan</th>
                                                <th>Rencana Perbaikan</th>
                                                <th>Visit</th>
                                                <th>Gambar Perbaikan</th>
                                                <th>Dokumen Pendukung</th>
                                                <th>Status Perbaikan</th>

                                            </tr>

                                        </thead>
                                        <tbody>
                                            <?php $i = 1;
                                            foreach ($moldData as $user) : ?>
                                                <tr>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $user['nama_mold']; ?></td>
                                                    <td><?= $user['suplier']; ?></td>
                                                    <td><?= $user['tanggal_pengajuan']; ?></td>
                                                    <td><?= $user['kondisi_mold']; ?></td>
                                                    <td>
                                                        <?php if (pathinfo($user['gambar_rusak'], PATHINFO_EXTENSION) === 'pdf') : ?>
                                                            <!-- Tampilkan tombol untuk membuka PDF dalam modal -->
                                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pdfModal" data-pdf="<?= base_url('uploads/' . $user['gambar_rusak']) ?>">
                                                                Lihat PDF
                                                            </button>
                                                        <?php else : ?>
                                                            <!-- Jika file adalah gambar, tampilkan gambar -->
                                                            <img src="<?= base_url('uploads/' . $user['gambar_rusak']) ?>" alt="Gambar Kerusakan" class="img-thumbnail" style="max-width: 100px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="<?= base_url('uploads/' . $user['gambar_rusak']) ?>">
                                                        <?php endif; ?>
                                                    </td>

                                                    <td><?= $user['keterangan']; ?></td>
                                                    <td><?= $user['rencana_perbaikan']; ?></td>
                                                    <td>
                                                        <?php if ($user['visit'] != 0) : ?>
                                                            <p>sudah</p>
                                                        <?php else : ?>
                                                            <a class="btn btn-primary verifikasi-btn" data-id="<?= $user['id_perbaikan']; ?>">Verifikasi</a>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($user['visit'] != 0) : ?>
                                                            <?php if ($user['gambar_diperbaiki'] != null) : ?>
                                                                <img src="<?= base_url('uploads/' . $user['gambar_diperbaiki']) ?>" alt="Gambar Kerusakan" class="img-thumbnail" style="max-width: 100px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="<?= base_url('uploads/' . $user['gambar_diperbaiki']) ?>">

                                                            <?php else : ?>
                                                                Belum upload
                                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-right" data-id-perbaikan="<?= $user['id_perbaikan'] ?>">Upload Gambar</button>
                                                            <?php endif; ?>
                                                        <?php else : ?>
                                                            Belum Visit
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($user['gambar_diperbaiki'] != null) : ?>
                                                            <?php if ($user['dokumen_pendukung'] != null) : ?>

                                                                <button type="button" class="btn btn-link btn-image-modal2" data-pdf="<?= base_url('uploads/' . $user['dokumen_pendukung']); ?>">

                                                                    <i class="fa fa-file-pdf-o"></i> Lihat dokumen
                                                                </button>

                                                            <?php else : ?>
                                                                Belum upload
                                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-left" data-id-perbaikan-dokumen="<?= $user['id_perbaikan'] ?>">Upload Dokumen</button>
                                                            <?php endif; ?>
                                                        <?php else : ?>
                                                            Belum Upload Gambar
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($user['dokumen_pendukung'] != null) : ?>
                                                            <?php if ($user['temporary'] != null && $user['permanen'] != null) : ?>

                                                                <?php if ($user['temporary'] == 'yes'  && $user['permanen'] == 'no') : ?>
                                                                    <p class="btn btn-warning">Temporary</p>
                                                                <?php elseif ($user['temporary'] == 'no'  && $user['permanen'] == 'yes') : ?>
                                                                    <p class="btn btn-success">Permanen</p>
                                                                <?php endif; ?>
                                                            <?php else : ?>
                                                                <a style="margin: 5px;" class="btn btn-warning status-temporary-btn" data-id="<?= $user['id_perbaikan']; ?>">Temporary</a>
                                                                <a style="margin: 5px;" class="btn btn-success status-permanen-btn" data-id="<?= $user['id_perbaikan']; ?>">Permanen</a>
                                                            <?php endif; ?>
                                                        <?php else : ?>
                                                            Belum Upload
                                                        <?php endif; ?>
                                                    </td>
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

            <div class="modal modal-right fade" id="modal-right" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Gambar Perbaikan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="upload-form">
                                <input type="hidden" id="id-perbaikan" name="id_perbaikan">
                                <div class="form-group">
                                    <label class="form-label">Gambar Perbaikan:</label>
                                    <input type="file" class="form-control" id="gambar_diperbaiki" required>

                                </div>
                            </form>
                        </div>
                        <div class="modal-footer modal-footer-uniform">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="button" id="save-button" class="btn btn-primary float-end">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal modal-left fade" id="modal-left" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Dokumen Pendukung</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="upload-form">
                                <input type="hidden" id="id-perbaikan-dokumen" name="id_perbaikan">
                                <div class="form-group">
                                    <label class="form-label">Dokumen Pendukung:</label>
                                    <input type="file" class="form-control" id="dokumen_pendukung" required>

                                </div>
                            </form>
                        </div>
                        <div class="modal-footer modal-footer-uniform">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="button" id="save-button-dokumen" class="btn btn-primary float-end">Save changes</button>
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

            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="imageModalLabel">Gambar Kerusakan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img id="modalImage" src="" class="img-fluid" alt="Gambar Kerusakan">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="pdfModal2" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="pdfModalLabel">Dokumen Viewer</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <embed id="pdfViewer2" src="" type="application/pdf" width="100%" height="600px">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal untuk PDF -->
            <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="pdfModalLabel">PDF Kerusakan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <iframe id="modalPdf" src="" style="width: 100%; height: 500px;" frameborder="0"></iframe>
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
        $('#example5').DataTable({

            "paging": true,
            "searching": true,
            "info": true,
            "lengthChange": true
        });
        $('#imageModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var imageUrl = button.data('image');
            var modal = $(this);
            modal.find('#modalImage').attr('src', imageUrl);
        });
        $('.btn-image-modal2').on('click', function() {
            var pdfUrl = $(this).data('pdf');
            $('#pdfViewer2').attr('src', pdfUrl);
            $('#pdfModal2').modal('show');
        });
        $('#pdfModal').on('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var pdfSrc = button.getAttribute('data-pdf');
            var modalPdf = document.getElementById('modalPdf');
            modalPdf.src = pdfSrc;
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.verifikasi-btn').on('click', function(e) {
            e.preventDefault();
            var idPerbaikan = $(this).data('id');

            $.ajax({
                url: '<?= base_url('verifikasi_perbaikan_admin') ?>',
                type: 'POST',
                data: {
                    id_perbaikan: idPerbaikan
                },
                success: function(response) {
                    if (response.success) {
                        showModal('Success', response.message);
                    } else {
                        showModal('Failed', response.message);
                    }
                },
                error: function() {
                    showModal('Error', 'Terjadi kesalahan.');
                }
            });
        });
        $('.status-temporary-btn').on('click', function(e) {
            e.preventDefault();
            var idPerbaikan = $(this).data('id');

            $.ajax({
                url: '<?= base_url('status_temporary_admin') ?>',
                type: 'POST',
                data: {
                    id_perbaikan: idPerbaikan
                },
                success: function(response) {
                    if (response.success) {
                        showModal('Success', response.message);
                    } else {
                        showModal('Failed', response.message);
                    }
                },
                error: function() {
                    showModal('Error', 'Terjadi kesalahan.');
                }
            });
        });
        $('.status-permanen-btn').on('click', function(e) {
            e.preventDefault();
            var idPerbaikan = $(this).data('id');

            $.ajax({
                url: '<?= base_url('status_permanen_admin') ?>',
                type: 'POST',
                data: {
                    id_perbaikan: idPerbaikan
                },
                success: function(response) {
                    if (response.success) {
                        showModal('Success', response.message);
                    } else {
                        showModal('Failed', response.message);
                    }
                },
                error: function() {
                    showModal('Error', 'Terjadi kesalahan.');
                }
            });
        });

        $('#modal-right').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var idPerbaikan = button.data('id-perbaikan');
            var modal = $(this);
            modal.find('#id-perbaikan').val(idPerbaikan);
        });
        $('#modal-left').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var idPerbaikan = button.data('id-perbaikan-dokumen');
            var modal = $(this);
            modal.find('#id-perbaikan-dokumen').val(idPerbaikan);
        });

        // Simpan data dari modal
        $('#save-button-dokumen').on('click', function() {
            const formData = new FormData();
            formData.append('id_perbaikan', $('#id-perbaikan-dokumen').val());
            formData.append('dokumen_pendukung', $('#dokumen_pendukung')[0].files[0]);

            $.ajax({
                url: '<?= base_url('upload_dokumen_admin') ?>',
                type: 'POST',
                data: formData,
                processData: false, // Untuk menangani file upload
                contentType: false, // Agar form tidak diproses sebagai URL-encoded
                dataType: 'json', // Mengharapkan respons JSON dari server
                success: function(response) {
                    if (response.success) {
                        // Tampilkan modal dengan pesan sukses dari server
                        showModal(response.message);
                    } else {
                        // Tampilkan modal dengan pesan error dari server (misalnya ukuran atau format file salah)
                        showModal(response.error || response.message); // Gunakan 'error' jika ada, atau 'message' jika tidak ada
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    // Tampilkan pesan error jika terjadi masalah di sisi server
                    showModal('Terjadi kesalahan saat mengirim data.');
                }
            });


        });
        // Simpan data dari modal
        $('#save-button').on('click', function() {
            const formData = new FormData();
            formData.append('id_perbaikan', $('#id-perbaikan').val());
            formData.append('gambar_diperbaiki', $('#gambar_diperbaiki')[0].files[0]);

            $.ajax({
                url: '<?= base_url('upload_perbaikan_admin') ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        showModal('Success', response.message);
                    } else {
                        showModal('Failed', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    showModal('Terjadi kesalahan saat mengirim data.');
                }
            });
        });

        function showModal(message, callback) {
            $('#modalMessage').text(message);
            $('#alertModal').modal('show');

            if (callback) {
                $('#alertModal').on('hidden.bs.modal', function() {
                    callback();
                    $(this).off('hidden.bs.modal'); // Remove the callback to avoid multiple triggers
                });
            }
            $('#modalok').on('click', function() {
                location.reload();
            });
        }
    });
</script>

<?= $this->endSection() ?>