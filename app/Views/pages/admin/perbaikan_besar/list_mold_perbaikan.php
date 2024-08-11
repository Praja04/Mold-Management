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
                                                <th>Belum Approved</th>
                                                <th>Sudah Approved</th>
                                                <th>History</th>
                                            </tr>
                                        </thead>

                                        <tbody id="user">
                                            <?php $i = 1;

                                            foreach ($data as $user) : ?>
                                                <tr class="">
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $user['ITEM']; ?></td>
                                                    <td>
                                                        <a href="<?= base_url('perbaikan/besar/no') ?>?namaMold=<?= urlencode($user['ITEM']) ?>" class="btn btn-<?= $user['Hasil_Verifikasi_Count_No'] > 0 ? 'danger' : 'primary' ?> text-white me-0">
                                                            <?= $user['Hasil_Verifikasi_Count_No']; ?>
                                                        </a>
                                                    </td>
                                                    <td><a href="<?= base_url('perbaikan/besar/yes') ?>?namaMold=<?= urlencode($user['ITEM']) ?>" class="btn btn-success text-white me-0">
                                                            <?= $user['Hasil_Verifikasi_Count_Yes']; ?>
                                                        </a></td>
                                                    <td>
                                                        <a class="btn btn-primary text-white me-0" href="<?= base_url('perbaikan/besar/detail') ?>?namaMold=<?= urlencode($user['ITEM']) ?>">Report Perbaikan</a>
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
    });
</script>
<?= $this->endSection() ?>