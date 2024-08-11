<?= $this->extend('template/layout'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">

            <div class="box">
                <a href="<?= base_url('userlist') ?>">Back</a>
                <div class="box-header with-border">
                    <h3>List of CBI Mold Users</h3>
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
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        // Sort data
                                        usort($data, function ($a, $b) {
                                            return $b['Hasil_Verifikasi_Count'] <=> $a['Hasil_Verifikasi_Count'];
                                        });
                                        ?>
                                        <tbody id="user">
                                            <?php $i = 1;

                                            foreach ($data as $user) : ?>
                                                <tr class="">
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $user['ITEM']; ?></td>
                                                    <td>
                                                        <a style="margin: 5px;" class="btn btn-primary text-white me-0" href="<?= base_url('mold/verif/') ?>?namaMold=<?= urlencode($user['ITEM']) ?>">Verifikasi</a>

                                                        <?php if ($user['Hasil_Verifikasi_Count'] > 0) : ?>

                                                            <a style="margin: 5px;" class="btn btn-danger text-white me-0">
                                                                <?= $user['Hasil_Verifikasi_Count']; ?>
                                                            </a>
                                                        <?php else : ?>

                                                            <a style="margin: 5px;" class="btn btn-primary text-white me-0">
                                                                <?= $user['Hasil_Verifikasi_Count']; ?>
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