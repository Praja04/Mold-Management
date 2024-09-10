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
                                    <h1 class="fs-40 text-white">Report Harian Mold</h1>

                                </div>
                                <div class="col-12 col-lg-4"><img src="<?= base_url('assets/images/custom-15.svg') ?>" alt=""></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 col-12"></div>
                <!-- <div class="col-xl-3 col-md-6 col-12">
                    <div class="box bg-secondary-light pull-up">
                        <div class="box-body">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center pe-2 justify-content-between">
                                    <div class="d-flex">
                                        <span class="badge badge-primary me-15">Active</span>
                                        <span class="badge badge-primary me-5"><i class="fa fa-lock"></i></span>
                                        <span class="badge badge-primary"><i class="fa fa-clock-o"></i></span>
                                    </div>

                                </div>
                                <h4 class="mt-25 mb-5"><?= $totalTerima['is_seen_0'] ?></h4>
                                <p class="text-fade mb-0 fs-12">Total Report Belum Dibaca</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="box bg-secondary-light pull-up">
                        <div class="box-body">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center pe-2 justify-content-between">
                                    <div class="d-flex">
                                        <span class="badge badge-dark me-15">Finished</span>
                                    </div>

                                </div>
                                <h4 class="mt-25 mb-5"><?= $totalTerima['is_seen_1'] ?></h4>
                                <p class="text-fade mb-0 fs-12">Total Report Sudah Dibaca</p>
                            </div>
                        </div>
                    </div>
                </div> -->

            </div>



            <div class="box">
                <div class="box-header with-border">
                    <h3>List Report Harian User</h3>
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
                                                <th>User</th>
                                                <th>Suplier</th>
                                                <!-- <th>Belum Dibaca</th> -->
                                                <th>All Report</th>
                                            </tr>
                                        </thead>
                                        <tbody id="user">
                                            <?php $i = 1;
                                            foreach ($data as $user) : ?>
                                                <tr class="">
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $user['username']; ?></td>
                                                    <td><?= $user['suplier']; ?></td>
                                                    <!-- <td>
                                                        <?php if ($perbaikanCounts[$user['id']] != 0) : ?>
                                                            <a href="<?= base_url('list/mold/daily') ?>?supplier=<?= urlencode($user['suplier']) ?>" class="btn btn-danger text-white me-0">
                                                                <?= $perbaikanCounts[$user['id']] ?>
                                                            </a>
                                                        <?php else : ?>
                                                            <a class="btn btn-primary text-white me-0">
                                                                <?= $perbaikanCounts[$user['id']] ?>
                                                            </a>
                                                        <?php endif; ?>

                                                    </td>
                                                     -->
                                                    <td>
                                                        <a class="btn btn-secondary me-0" href="<?= base_url('list/mold/daily') ?>?supplier=<?= urlencode($user['suplier']) ?>"><span class="ti ti-eye"></a>

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
        $('#example5').DataTable({
            // You can add additional configuration options here if needed
            "paging": true, // Enable pagination
            "searching": true, // Enable search functionality
            "info": true, // Show table information
            "lengthChange": true // Allow the user to change the number of rows displayed
        });
    });
</script>

<?= $this->endSection() ?>