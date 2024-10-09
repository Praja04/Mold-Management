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
                                            </tr>

                                        </thead>
                                        <tbody>
                                            <?php $i = 1;
                                            foreach ($historyPerbaikan as $user) : ?>
                                                <?php if ($user['terima_perbaikan'] == 'no') : ?>
                                                    <tr>
                                                        <td><?= $i++; ?></td>
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
                                                            <button class="btn btn-danger">Pending</button>
                                                        </td>
                                                        <td><?php if ($user['rencana_perbaikan'] != null) : ?>
                                                                <?= $user['rencana_perbaikan'] ?>
                                                            <?php else : ?>
                                                                <p>Belum Approved</p>
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


<?= $this->endSection() ?>