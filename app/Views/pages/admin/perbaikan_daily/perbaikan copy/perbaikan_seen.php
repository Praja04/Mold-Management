<?= $this->extend('template/layout'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">

            <div class="box">
                <div class="box-header with-border text-center">
                    <h3>Report Detail Harian</h3>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example5" class="table table-bordered table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">No</th>
                                                <th rowspan="2">Nama Mold</th>
                                                <th rowspan="2">Jumlah OK</th>
                                                <th rowspan="2">Jumlah NG</th>
                                                <th rowspan="2">Problem Harian</th>
                                                <th rowspan="2">Status</th>
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
                                            <?php $i = 1;
                                            foreach ($historymoldData as $user) : ?>
                                                <?php if ($user['is_seen'] != 'no') : ?>
                                                    <tr>
                                                        <td><?= $i++; ?></td>
                                                        <td><?= $user['nama_mold']; ?></td>
                                                        <td><?= $user['jumlah_ok']; ?></td>
                                                        <td><?= $user['jumlah_ng']; ?></td>
                                                        <td>
                                                            <?php if ($user['problem_harian'] != null) : ?>
                                                                <?= $user['problem_harian']; ?>
                                                            <?php else : ?>
                                                                <p>-</p>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                           Dilihat
                                                        </td>
                                                        <td><?= $user['setup_mesin'] ?></td>
                                                        <td><?= $user['cuci_barel'] ?></td>
                                                        <td><?= $user['cuci_mold'] ?></td>
                                                        <td><?= $user['unfil'] ?></td>
                                                        <td><?= $user['bubble'] ?></td>
                                                        <td><?= $user['crack'] ?></td>
                                                        <td><?= $user['blackdot'] ?></td>
                                                        <td><?= $user['undercut'] ?></td>
                                                        <td><?= $user['belang'] ?></td>
                                                        <td><?= $user['scratch'] ?></td>
                                                        <td><?= $user['ejector_mark'] ?></td>
                                                        <td><?= $user['flashing'] ?></td>
                                                        <td><?= $user['bending'] ?></td>
                                                        <td><?= $user['weldline'] ?></td>
                                                        <td><?= $user['sinkmark'] ?></td>
                                                        <td><?= $user['silver'] ?></td>
                                                        <td><?= $user['flow_material'] ?></td>
                                                        <td><?= $user['bushing'] ?></td>
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