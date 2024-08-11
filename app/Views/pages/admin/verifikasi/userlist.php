<?= $this->extend('template/layout'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <div class="box">
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
                                                    <td>
                                                        <a class="btn btn-primary text-white me-0" href="<?= base_url('manage/') ?>?supplier=<?= urlencode($user['suplier']) ?>">Verifikasi Mold</a>
                                                        <?php
                                                        // Hitung jumlah notifikasi dengan Hasil_Verifikasi = 0
                                                        $notifCount = 0;
                                                        if (isset($user['notifications']) && is_array($user['notifications'])) {
                                                            foreach ($user['notifications'] as $notif) {
                                                                if ($notif['Hasil_Verifikasi'] == '0') {
                                                                    $notifCount++;
                                                                }
                                                            }
                                                        }
                                                        $btnClass = $notifCount > 0 ? 'btn-danger' : 'btn-warning';
                                                        ?>
                                                        <a class="btn <?= $btnClass ?>" href="<?= base_url('manage/') ?>?supplier=<?= urlencode($user['suplier']) ?>">
                                                                <?= $notifCount ?> Notifikasi
                                                            
                                                        </a>
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