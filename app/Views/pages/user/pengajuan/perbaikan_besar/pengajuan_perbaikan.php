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
                                    <h1 class="fs-40 text-white">Pengajuan Perbaikan Besar</h1>
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
                        <h3 class="box-title">History Pengajuan Perbaikan Anda</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example5" class="table table-bordered table-striped" style="width:100%">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Mold</th>
                                        <th>Belum Approved</th>
                                        <th>Approved Status Pending</th>
                                        <th>History Report</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php $i = 1;
                                    foreach ($moldCounts as $moldName => $counts) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $moldName; ?></td>
                                            <td>
                                                <?php if ($counts['no'] != 0) : ?>
                                                    <a class="btn btn-danger" href="<?= base_url('perbaikan/notAcc') ?>?namaMold=<?= urlencode($moldName) ?>"><?= $counts['no'] ?></a>
                                                <?php else : ?>
                                                    <a class="btn btn-primary" href="<?= base_url('perbaikan/notAcc') ?>?namaMold=<?= urlencode($moldName) ?>"><?= $counts['no'] ?></a>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-success" href="<?= base_url('perbaikan/Acc') ?>?namaMold=<?= urlencode($moldName) ?>"><?= $counts['yes'] ?></a>
                                            </td>
                                            <td><a class="btn btn-secondary" href="<?= base_url('history/perbaikan') ?>?namaMold=<?= urlencode($moldName) ?>"><span class="ti ti-eye"></a></td>
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
            <!-- Modal untuk upload gambar -->

        </section>
        <!-- /.content -->
    </div>
</div>

<script src="<?= base_url('assets/js/jquery-3.7.1.min.js'); ?>" type="text/javascript"></script>

<script>
    $(document).ready(function() {
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