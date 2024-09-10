<?= $this->extend('template/layout'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h3 class="page-title">UserList</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#"><i class="mdi mdi-home-outline"></i></a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">
                                    Data
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Supplier
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <?php $i = 1;
                foreach ($data as $user) : ?>
                <div class="col-12 col-lg-4">
                        <a href="<?= base_url('detail/suplier') ?>?supplier=<?= urlencode($user['suplier']) ?>">
                            <div class="box ribbon-box">
                                <div class="ribbon-two ribbon-two-primary">
                                    <span><?= $user['suplier']; ?></span>
                                </div>
                                <div class="box-header no-border p-0">

                                    <img class="img-fluid" src="<?= base_url() ?>images/avatar/375x200/<?= ($i % 10) == 0 ? 10 : $i % 10; ?>.jpg" alt="" />

                                </div>
                                <div class="box-body">
                                    <div class="text-center">
                                        <h3 class="my-10"><a href="#"><?= $user['username']; ?></a></h3>
                                        <h6 class="user-info mt-0 mb-10 text-fade"><?= $user['address']; ?></h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php $i++;
                endforeach; ?>
            </div>

            <!-- /.content -->
        </section>
        <!-- /.content -->
    </div>
</div>

<script src="<?= base_url() ?>assets/js/jquery-3.7.1.min.js" type="text/javascript"></script>

<?= $this->endSection() ?>