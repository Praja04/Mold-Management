<?= $this->extend('template/layout'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">

            <div class="box">
                <div class="box-header with-border text-center">
                    <h3>Detail Perbaikan Besar Mold <?= $nama_mold ?> </h3>
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
                                                <th>Tanggal Pengajuan</th>
                                                <th>Kondisi Mold</th>
                                                <th>Gambar Kerusakan</th>
                                                <th>Status</th>
                                                <th>Rencana Perbaikan</th>
                                                <th>Gambar Perbaikan</th>
                                                <th>Visit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1;
                                            foreach ($historyPerbaikan as $user) : ?>
                                                <?php if ($user['terima_perbaikan'] == 'yes') : ?>
                                                    <tr>
                                                        <td><?= $i++; ?></td>
                                                        <td><?= $user['tanggal_pengajuan']; ?></td>
                                                        <td><?= $user['kondisi_mold']; ?></td>
                                                        <td>
                                                            <?php if (!empty($user['gambar_rusak'])) : ?>
                                                                <img src="<?= base_url('uploads/' . $user['gambar_rusak']) ?>" alt="Gambar Kerusakan" class="img-thumbnail" style="max-width: 100px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="<?= base_url('uploads/' . $user['gambar_rusak']) ?>">
                                                            <?php else : ?>
                                                                Tidak ada gambar
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-success">Approved</button>
                                                        </td>
                                                        <td>
                                                            <?= $user['rencana_perbaikan'] ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($user['gambar_diperbaiki'] != null) : ?>
                                                                <img src="<?= base_url('uploads/' . $user['gambar_diperbaiki']) ?>" alt="Gambar Kerusakan" class="img-thumbnail" style="max-width: 100px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="<?= base_url('uploads/' . $user['gambar_diperbaiki']) ?>">
                                                               
                                                            <?php else : ?>
                                                                Belum upload
                                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-right" data-id-perbaikan="<?= $user['id_perbaikan'] ?>">Upload Gambar</button>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($user['visit'] != 0) : ?>
                                                                <p>sudah</p>
                                                            <?php else : ?>
                                                                <a class="btn btn-primary verifikasi-btn" data-id="<?= $user['id_perbaikan']; ?>">Verifikasi</a>
                                                            <?php endif; ?>
                                                        </td>

                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal untuk Gambar Kerusakan -->
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
        $('#example5').DataTable({
            "paging": true,
            "searching": true,
            "info": true,
            "lengthChange": true
        });

        $('.verifikasi-btn').on('click', function(e) {
            e.preventDefault();
            var idPerbaikan = $(this).data('id');

            $.ajax({
                url: '<?= base_url('verifikasi_perbaikan_user') ?>',
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

        $('#save-button').on('click', function() {
            const formData = new FormData();
            formData.append('id_perbaikan', $('#id-perbaikan').val());
            formData.append('gambar_diperbaiki', $('#gambar_diperbaiki')[0].files[0]);

            $.ajax({
                url: '<?= base_url('upload_perbaikan_user') ?>',
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

        function showModal(title, message) {
            $('#modalMessage').text(message);
            $('#alertModalLabel').text(title);
            $('#alertModal').modal('show');
        }

        $('#modalok').on('click', function() {
            location.reload();
        });

        $('#imageModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var imageUrl = button.data('image');
            var modal = $(this);
            modal.find('#modalImage').attr('src', imageUrl);
        });
    });
</script>

<?= $this->endSection() ?>