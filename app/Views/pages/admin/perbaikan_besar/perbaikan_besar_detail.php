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
                                                        <img src="<?= base_url('uploads/' . $user['gambar_rusak']) ?>" alt="Gambar Kerusakan" class="img-thumbnail" style="max-width: 100px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="<?= base_url('uploads/' . $user['gambar_rusak']) ?>">
                                                    </td>  
                                                    <td>
                                                        <?php if ($user['terima_perbaikan'] != 'no') : ?>
                                                            <p style="color: green;">Approved</p>
                                                        <?php else : ?>
                                                            <p style="color: red;">Belum Approved</p>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= $user['keterangan']; ?></td>
                                                    <td><?= $user['rencana_perbaikan']; ?></td>
                                                    <td>
                                                        <?php if ($user['visit'] != 0) : ?>
                                                            <p style="color: green;">Sudah Datang</p>
                                                        <?php else : ?>
                                                            <p style="color: red;">Belum Datang</p>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($user['gambar_diperbaiki'] != null) : ?>
                                                            <img src="<?= base_url('uploads/' . $user['gambar_diperbaiki']) ?>" alt="Gambar Kerusakan" class="img-thumbnail" style="max-width: 100px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="<?= base_url('uploads/' . $user['gambar_diperbaiki']) ?>">
                                                        <?php else : ?>
                                                            <p style="color: red;">Belum Datang</p>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php if ($user['dokumen_pendukung'] != null) : ?>
                                                            <button type="button" class="btn btn-link btn-image-modal2" data-pdf="<?= base_url('uploads/' . $user['dokumen_pendukung']); ?>">

                                                                <i class="fa fa-file-pdf-o"></i> Lihat dokumen
                                                            </button>
                                                        <?php else : ?>
                                                            <p style="color: red;">Belum Datang</p>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td> <?php if ($user['temporary'] == 'yes'  && $user['permanen'] == 'no') : ?>
                                                            <p class="btn btn-warning">Temporary</p>
                                                        <?php elseif ($user['temporary'] == 'no'  && $user['permanen'] == 'yes') : ?>
                                                            <p class="btn btn-success">Permanen</p>
                                                        <?php else : ?>
                                                            <p style="color: red;">Belum Datang</p>
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
        $('.btn-image-modal2').on('click', function() {
            var pdfUrl = $(this).data('pdf');
            $('#pdfViewer2').attr('src', pdfUrl);
            $('#pdfModal2').modal('show');
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Handle individual "mark as seen" button clicks


        function showModal(message, callback) {
            if (message = 'Data submitted successfully!') {
                $('#modalMessage').text('Data Sudah Diverifikasi');
                $('#alertModal').modal('show');
            } else {
                $('#modalMessage').text(message);
                $('#alertModal').modal('show');
            }

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