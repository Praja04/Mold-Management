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
                                                <th>Action</th>

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
                                                            <img src="<?= base_url('uploads/' . $user['gambar_diperbaiki']) ?>" alt="Gambar Perbaikan" class="img-thumbnail" style="max-width: 100px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="<?= base_url('uploads/' . $user['gambar_diperbaiki']) ?>">
                                                        <?php else : ?>
                                                            <p style="color: red;">Belum Upload</p>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php if ($user['dokumen_pendukung'] != null) : ?>
                                                            <button type="button" class="btn btn-link btn-image-modal2" data-pdf="<?= base_url('uploads/' . $user['dokumen_pendukung']); ?>">

                                                                <i class="fa fa-file-pdf-o"></i> Lihat dokumen
                                                            </button>
                                                        <?php else : ?>
                                                            <p style="color: red;">Belum Upload</p>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($user['temporary'] == 'yes'  && $user['permanen'] == 'no') : ?>
                                                            <p class="btn btn-warning">Temporary</p>
                                                        <?php elseif ($user['temporary'] == 'no'  && $user['permanen'] == 'yes') : ?>
                                                            <p class="btn btn-success">Permanen</p>
                                                        <?php else : ?>
                                                            <p style="color: red;">Belum Ditentukan</p>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <button style="margin: 3px;" type="button" class="btn btn-danger btn-delete" data-id="<?= $user['id_perbaikan']; ?>">Delete</button>
                                                        <button style="margin: 3px;" type="button" class="btn btn-warning btn-update" data-id="<?= $user['id_perbaikan']; ?>">Update</button>
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

            <div class="modal  fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this record?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal modal-right fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="updateForm" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateModalLabel">Update Data Perbaikan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="gambar_diperbaiki" class="form-label">Gambar Diperbaiki</label>
                                    <input type="file" class="form-control" id="gambar_diperbaiki" name="gambar_diperbaiki">
                                </div>
                                <div class="mb-3">
                                    <label for="dokumen_pendukung" class="form-label">Dokumen Pendukung</label>
                                    <input type="file" class="form-control" id="dokumen_pendukung" name="dokumen_pendukung">
                                </div>
                                <div class="mb-3">
                                    <label for="status_perbaikan" class="form-label">Status Perbaikan</label>
                                    <select class="form-control" id="status_perbaikan" name="status_perbaikan">
                                        <option value="temporary">Temporary</option>
                                        <option value="permanen">Permanen</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
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
        $('#pdfModal').on('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var pdfSrc = button.getAttribute('data-pdf');
            var modalPdf = document.getElementById('modalPdf');
            modalPdf.src = pdfSrc;
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

        $('.btn-delete').on('click', function() {
            deleteId = $(this).data('id');
            $('#deleteModal').modal('show'); // Show the confirmation modal
        });
        $('.btn-update').on('click', function() {
            updateId = $(this).data('id');
            $('#updateModal').modal('show'); // Show the confirmation modal
        });

        $('#updateForm').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append('id_perbaikan', updateId);

            $.ajax({
                url: '<?= base_url('update/perbaikan'); ?>', // Ubah sesuai dengan route update Anda
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        $('#updateModal').modal('hide');
                        showModal('Data updated successfully.', function() {
                            location.reload();
                        });
                    } else {
                        showModal('Failed to update data.');
                    }
                },
                error: function(xhr, status, error) {
                    showModal('An error occurred: ' + xhr.status + ' ' + xhr.statusText);
                }
            });
        });


        // Handle confirm delete button click in the modal
        $('#confirmDeleteBtn').on('click', function() {
            $.ajax({
                url: '<?= base_url('delete/perbaikan/'); ?>' + deleteId, // Replace 'controllerName' with your actual controller name
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


        function showModal(message, callback) {
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

            $('#modalok').on('click', function() {
                location.reload();
            });
        }

    });
</script>

<?= $this->endSection() ?>