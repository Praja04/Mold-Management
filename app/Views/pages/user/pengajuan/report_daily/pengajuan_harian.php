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
                                    <h1 class="fs-40 text-white">Pengajuan Report Harian</h1>

                                </div>
                                <div class="col-12 col-lg-4"><img src="<?= base_url('assets/images/custom-15.svg') ?>" alt=""></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-6 col-12">
                <div class="box">
                    <div class="box-header with-border text-center">
                        <h3 class="box-title">History Report Harian Anda</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example5" class="table table-bordered table-striped" style="width:100%">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Mold</th>
                                        <th>Total Hasil Produksi</th>
                                        <th>Total Dikirim</th>
                                        <th>Report</th>
                                        <th>Kirim Produk</th>
                                    </tr>
                                </thead>

                                <tbody class="text-center">
                                    <?php $i = 1;
                                    foreach ($moldCounts as $moldName => $counts) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $moldName; ?></td>
                                            <td><?= $counts['jumlah_produk']; ?></td>
                                            <td><?= $counts['jumlah_dikirim']?></td>
                                            <td><a class="btn btn-secondary" href="<?= base_url('history/report') ?>?namaMold=<?= urlencode($moldName) ?>"><span class="ti ti-eye"></a></td>
                                            <td>
                                                <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modal-right" data-nama-mold="<?= $moldName; ?>"><span class="ti ti-truck"></button>
                                            </td>

                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>

            <div class="modal modal-right fade" id="modal-right" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Transaksi Hasil Produksi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="upload-form">
                                <input type="hidden" id="nama-mold" name="nama-mold">
                                <div class="form-group">
                                    <label class="form-label">Jumlah Yang Dikirim (pcs):</label>
                                    <input type="number" class="form-control" id="jumlah_produk" required>
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

<script src="<?= base_url('assets/js/jquery-3.7.1.min.js'); ?>" type="text/javascript"></script>

<script>
    $(document).ready(function() {

        $('#modal-right').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var namaMold = button.data('nama-mold');
            var modal = $(this);
            modal.find('#nama-mold').val(namaMold);
        });
        $('#save-button').on('click', function() {
            const formData = new FormData();
            formData.append('nama_mold', $('#nama-mold').val());
            formData.append('jumlah_produk', $('#jumlah_produk').val());

            $.ajax({
                url: '<?= base_url('kirim/produk') ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success') {
                        showModal('Success', response.message);
                    } else if (response.status === 'error') {
                        showModal('Error', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    showModal('Error', 'Terjadi kesalahan saat mengirim data.');
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
        var table = $('#example5').DataTable({
            "order": [], // Default no sorting
            "columnDefs": [{
                "targets": [2], // Target the 'Belum Dibaca' column
                "orderData": [2, 3] // Order by 'Belum Dibaca' first, then 'Dibaca'
            }],
            "paging": true,
            "searching": false, // Disable search
            "ordering": true,
            "info": true,
            "language": {
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "Showing 0 to 0 of 0 entries",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "lengthMenu": "Show _MENU_ entries",
                "loadingRecords": "Loading...",
                "processing": "Processing...",
                "zeroRecords": "No matching records found"
            }
        });
        $.fn.dataTable.ext.order['custom-no-sort'] = function(settings, col) {
            return this.api().rows().nodes().toArray().sort(function(a, b) {
                var aValue = parseInt($(a).data('no'), 10);
                var bValue = parseInt($(b).data('no'), 10);
                // Sort so that rows with non-zero 'Belum Dibaca' appear first
                return (bValue === 0 && aValue !== 0) ? 1 : (aValue === 0 && bValue !== 0) ? -1 : bValue - aValue;
            });
        };

        // Apply custom sorting
        table.order([2, 'desc']).draw();
    });
</script>

<?= $this->endSection(); ?>