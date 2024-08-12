<?= $this->extend('template/layout'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">

            <div class="box">
                <div class="box-header with-border text-center">
                    <h3>Pengirimian Hasil Produksi Mold</h3>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <button id="mark-all-as-seen" class="btn btn-success">Tandai Semua Sebagai Dilihat</button>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example5" class="table table-bordered table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Mold</th>
                                                <th>Jumlah yang akan Dikirim</th>
                                                <th>Tandai Dilihat</th>
                                            </tr>
                                            
                                        </thead>
                                        <tbody>
                                            <?php $i = 1;
                                            foreach ($moldData as $user) : ?>
                                                <tr>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $user['nama_mold']; ?></td>
                                                    <td><?= $user['jumlah_produk']; ?></td>
                                                  
                                                    <td>
                                                        <button class="mark-as-seen btn btn-primary" data-id="<?= $user['id']; ?>">Tandai</button>
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

    });
</script>

<script>
    $(document).ready(function() {

        // Handle individual "mark as seen" button clicks
        $(document).on('click', '.mark-as-seen', function() {
            var button = $(this);
            var id = button.data('id');

            $.ajax({
                url: '<?= base_url('update_is_seen') ?>',
                type: 'POST',
                data: {
                    id: id,
                    is_seen: 'yes'
                },
                success: function(response) {
                    if (response.success) {
                        showModal('Success', 'Data sudah dibaca');
                    } else {
                        showModal('Failed', 'Failed to update.');
                    }
                },
                error: function() {
                    showModal('Error', 'Something went wrong.');
                }
            });
        });

        // Handle "mark all as seen" button click
        $('#mark-all-as-seen').click(function() {
            var ids = [];
            $('#example5 tbody .mark-as-seen').each(function() {
                ids.push($(this).data('id'));
            });

            $.ajax({
                url: '<?= base_url('update_all_is_seen') ?>',
                type: 'POST',
                data: {
                    ids: ids
                },
                success: function(response) {
                    if (response.success) {
                        showModal('Success', 'Semua data sudah dibaca');
                    } else {
                        showModal('Failed', 'Failed to update all.');
                    }
                },
                error: function() {
                    showModal('Error', 'Something went wrong.');
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
    });
</script>


<?= $this->endSection() ?>