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
                                    <table id="example5" class="table table-bordered table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Mold</th>
                                                <th>Suplier</th>
                                                <th>Tanggal Pengajuan</th>
                                                <th>Kondisi Mold</th>
                                                <th>Gambar Rusak</th>
                                                <th>Status</th>
                                                <th>Keterangan Tambahan</th>

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

                                                    <td>
                                                        <button class="btn btn-danger" data-bs-toggle="modal" data-user-id="<?= $user['user_id'] ?>" data-nama-mold="<?= $user['nama_mold'] ?>" data-bs-target="#modal-right" data-id-perbaikan="<?= $user['id_perbaikan'] ?>">
                                                            <p>Belum Approved</p>
                                                        </button>
                                                    </td>
                                                    <td><?= $user['keterangan']; ?> <?= $user['id_perbaikan'] ?></td>

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
                            <h5 class="modal-title">Approved Perbaikan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="upload-form">
                                <input type="hidden" id="id-perbaikan" name="id_perbaikan">
                                <input type="hidden" id="nama_mold" name="nama_mold">
                                <input type="hidden" id="user_id" name="user_id">
                                <div class="form-group">
                                    <label class="form-label">Rencana Perbaikan:</label>
                                    <textarea class="form-control" rows="4" name="rencana_perbaikan" id="rencana_perbaikan" required placeholder="Isi rencana untuk datang ke suplier"></textarea>

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
            // You can add additional configuration options here if needed
            "paging": true, // Enable pagination
            "searching": true, // Enable search functionality
            "info": true, // Show table information
            "lengthChange": true // Allow the user to change the number of rows displayed
        });
        $('#imageModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var imageUrl = button.data('image');
            var modal = $(this);
            modal.find('#modalImage').attr('src', imageUrl);
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

        $('#modal-right').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var idPerbaikan = button.data('id-perbaikan');
            var namaMold = button.data('nama-mold');
            var userId = button.data('user-id');
            var modal = $(this);
            modal.find('#id-perbaikan').val(idPerbaikan);
            modal.find('#nama_mold').val(namaMold);
            modal.find('#user_id').val(userId);
        });

        // Simpan data dari modal
        $('#save-button').on('click', function() {
            const formData = new FormData();
            formData.append('id_perbaikan', $('#id-perbaikan').val());
            formData.append('nama_mold', $('#nama_mold').val());
            formData.append('rencana_perbaikan', $('#rencana_perbaikan').val());
            formData.append('user_id', $('#user_id').val());

            $.ajax({
                url: '<?= base_url('approved_perbaikan') ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        showModal(response.message, function() {
                            location.reload();
                        });
                    } else {
                        showModal(response.message);
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
                $('#alertModal').modal('hide');
            });
        }
    });
</script>

<?= $this->endSection() ?>