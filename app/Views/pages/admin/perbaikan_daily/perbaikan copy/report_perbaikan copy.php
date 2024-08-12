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
                                    <h1 class="fs-40 text-white">Perbaikan Daily Mold</h1>

                                </div>
                                <div class="col-12 col-lg-4"><img src="<?= base_url('assets/images/custom-15.svg') ?>" alt=""></div>
                            </div>
                        </div>
                    </div>
                </div>
               
                <div class="col-xl-3 col-md-6 col-12"></div>
                <div class="col-xl-3 col-md-6 col-12">
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
                                <h4 class="mt-25 mb-5"><?= $totalTerima['terima_perbaikan_0'] ?></h4>
                                <p class="text-fade mb-0 fs-12">Total Perbaikan Belum di ACC</p>
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
                                <h4 class="mt-25 mb-5"><?= $totalTerima['terima_perbaikan_1'] ?></h4>
                                <p class="text-fade mb-0 fs-12">Total Perbaikan Sudah di ACC</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>



            <div class="box">
                <div class="box-header with-border">
                    <h3>List Report Perbaikan User</h3>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-separated">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>User</th>
                                                <th>Company or Suplier</th>
                                                <th>Address</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="user">
                                            <?php $i = 1;
                                            foreach ($data as $user) : ?>
                                                <tr class="">
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $user['username']; ?></td>
                                                    <td><?= $user['suplier']; ?></td>
                                                    <td><?= $user['address'] ?></td>
                                                    <td><a class="btn btn-primary text-white me-0" href="<?= base_url('perbaikan/user/') ?><?= $user['id'] ?>">Perbaikan</a>
                                                        <?php if (isset($perbaikanCounts[$user['id']]) && $perbaikanCounts[$user['id']] != 0) : ?>
                                                            <a class="btn btn-danger text-white me-0">
                                                                <?= $perbaikanCounts[$user['id']] ?>
                                                            </a>
                                                        <?php else : ?>
                                                            <a class="btn btn-primary text-white me-0">
                                                                <?= isset($perbaikanCounts[$user['id']]) ? $perbaikanCounts[$user['id']] : 0; ?>
                                                            </a>
                                                        <?php endif; ?>
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

<?= $this->endSection() ?>