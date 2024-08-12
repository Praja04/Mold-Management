<?= $this->extend('template/layout'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">

            <div class="box">
                <div class="box-header with-border">
                    <h3>List Mold User</h3>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example5" class="table table-bordered table-separated text-center">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Mold</th>
                                                <th>Total Produksi</th>
                                                <th>Pengiriman Belum Approved</th>
                                                <th>Pengiriman Sudah Approved</th>
                                                <th>History Report</th>
                                                <th>Update Data Hasil Produksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="user">
                                            <?php $i = 1;

                                            foreach ($data as $user) : ?>
                                                <tr class="">
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $user['ITEM']; ?></td>
                                                    <td><?= $user['Total_Produk'] ?></td>
                                                    <td>
                                                        <a href=" <?= base_url('daily/detail/no') ?>?namaMold=<?= urlencode($user['ITEM']) ?>" class="btn btn-<?= $user['Hasil_Verifikasi_Count_No'] > 0 ? 'danger' : 'primary' ?> text-white me-0">
                                                            <?= $user['Hasil_Verifikasi_Count_No']; ?>
                                                        </a>

                                                    </td>
                                                    <td>
                                                        <a href="<?= base_url('daily/detail/yes') ?>?namaMold=<?= urlencode($user['ITEM']) ?>" class="btn btn-success text-white me-0">
                                                            <?= $user['Hasil_Verifikasi_Count_Yes']; ?>
                                                        </a>

                                                    </td>
                                                    <td>
                                                        <a class="btn btn-primary text-white me-0" href="<?= base_url('daily/detail') ?>?namaMold=<?= urlencode($user['ITEM']) ?>">Report Daily</a>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-right" data-id-mold="<?= $user['id'] ?>">
                                                            <p>Update</p>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal modal-right fade" id="modal-right" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Update Hasil Produksi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="upload-form">
                                    <input type="hidden" id="id-mold" name="id_perbaikan">
                                    <div class="form-group">
                                        <label class="form-label">Jumlah Produksi:</label>
                                        <input type="number" class="form-control" id="jumlah" required placeholder="Isi jumlah Produksi yang benar">


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
            </div>
        </section>
        <!-- /.content -->
    </div>
</div>
<script src="<?= base_url() ?>assets/js/jquery-3.7.1.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {


        // Menginisialisasi DataTables setelah sorting
        $('#example5').DataTable({
            "paging": true, // Enable pagination
            "searching": true, // Enable search functionality
            "info": true, // Show table information
            "lengthChange": true // Allow the user to change the number of rows displayed
        });

        $('#modal-right').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var idmold = button.data('id-mold');
            var modal = $(this);
            modal.find('#id-mold').val(idmold);
        });

        // Simpan data dari modal
        $('#save-button').on('click', function() {
            const formData = new FormData();
            formData.append('id_mold', $('#id-mold').val());
            formData.append('jumlah', $('#jumlah').val());

            $.ajax({
                url: '<?= base_url('update/hasilproduksi') ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success') {
                        showModal(response.message);
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

        function showModal(message) {
            $('#modalMessage').text(message);
            $('#alertModal').modal('show');
        }

        $('#modalok').on('click', function() {
            location.reload();
        });
    });
</script>
<?= $this->endSection() ?>