<?= $this->extend('template/layout'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">


            <div class="box">
                <div class="box-header with-border text-center">
                    <h3>History Report Harian</h3>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example6" class="table table-bordered table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">No</th>
                                                <th rowspan="2">Nama Mold</th>
                                                <th rowspan="2">Jumlah OK</th>
                                                <th rowspan="2">Jumlah NG</th>
                                                <th rowspan="2">Problem Harian</th>
                                                <th colspan="18" class="text-center">Jenis Reject</th>
                                            </tr>
                                            <tr>
                                                <th>Set Up Mesin</th>
                                                <th>Cuci Barel</th>
                                                <th>Cuci Mold</th>
                                                <th>Unfil</th>
                                                <th>Bubble</th>
                                                <th>Crack</th>
                                                <th>Blackdot</th>
                                                <th>Undercut</th>
                                                <th>Belang</th>
                                                <th>Scratch</th>
                                                <th>Ejector Mark</th>
                                                <th>Flashing</th>
                                                <th>Bending</th>
                                                <th>Weldline</th>
                                                <th>Sinkmark</th>
                                                <th>Silver</th>
                                                <th>Flow Material</th>
                                                <th>Bushing</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($historymoldData) && is_iterable($historymoldData) && !empty($historymoldData)) : ?>
                                                <?php $i = 1; ?>
                                                <?php foreach ($historymoldData as $user) : ?>
                                                    <tr>
                                                        <td><?= $i++; ?></td>
                                                        <td><?= esc($user['nama_mold']); ?></td>
                                                        <td><?= esc($user['jumlah_ok']); ?></td>
                                                        <td><?= esc($user['jumlah_ng']); ?></td>
                                                        <td>
                                                            <?= $user['problem_harian'] != null ? esc($user['problem_harian']) : '<p>-</p>' ?>
                                                        </td>
                                                        
                                                        <td><?= esc($user['setup_mesin']); ?></td>
                                                        <td><?= esc($user['cuci_barel']); ?></td>
                                                        <td><?= esc($user['cuci_mold']); ?></td>
                                                        <td><?= esc($user['unfil']); ?></td>
                                                        <td><?= esc($user['bubble']); ?></td>
                                                        <td><?= esc($user['crack']); ?></td>
                                                        <td><?= esc($user['blackdot']); ?></td>
                                                        <td><?= esc($user['undercut']); ?></td>
                                                        <td><?= esc($user['belang']); ?></td>
                                                        <td><?= esc($user['scratch']); ?></td>
                                                        <td><?= esc($user['ejector_mark']); ?></td>
                                                        <td><?= esc($user['flashing']); ?></td>
                                                        <td><?= esc($user['bending']); ?></td>
                                                        <td><?= esc($user['weldline']); ?></td>
                                                        <td><?= esc($user['sinkmark']); ?></td>
                                                        <td><?= esc($user['silver']); ?></td>
                                                        <td><?= esc($user['flow_material']); ?></td>
                                                        <td><?= esc($user['bushing']); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    No data available
                                                </tr>
                                            <?php endif; ?>
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
        // $('#example5').DataTable({
        //     // You can add additional configuration options here if needed
        //     "paging": true, // Enable pagination
        //     "searching": true, // Enable search functionality
        //     "info": true, // Show table information
        //     "lengthChange": true // Allow the user to change the number of rows displayed
        // });
        $('#example6').DataTable({
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
                        showModal('Failed to update.');
                    }
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
                        $('#example1 tbody .mark-as-seen').each(function() {
                            showModal('Success', 'Semua data sudah dibaca');
                        });
                    } else {
                        showModal('Failed to update all.');
                    }
                }
            });
        });


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