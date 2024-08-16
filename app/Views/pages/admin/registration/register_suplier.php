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
                                    <h1 class="fs-40 text-white">Register Supplier CBI</h1>

                                </div>
                                <div class="col-12 col-lg-4"><img src="<?= base_url('assets/images/custom-15.svg') ?>" alt=""></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-12"></div>
                <div class="col-lg-8 col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Register Supllier Baru</h4>
                        </div>
                        <!-- /.box-header -->
                        <form class="form" method="post" action="<?= base_url('register_action') ?>">
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="form-label">User Name</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="ti-user"></i></span>
                                        <input type="text" id="username" name="username" class="form-control" placeholder="Username" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Password</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="ti-lock"></i></span>
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Role</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="ti-user"></i></span>
                                        <input type="text" id="role" name="role" class="form-control" placeholder="Role" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Suplier</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="ti-lock"></i></span>
                                        <input type="text" id="suplier" name="suplier" class="form-control" placeholder="Supplier" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Address</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="ti-lock"></i></span>
                                        <input type="text" id="address" name="address" class="form-control" placeholder="Address" />
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti-save-alt"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </section>
        <div class="modal fade" id="flashModal" tabindex="-1" role="dialog" aria-labelledby="flashModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="flashModalLabel">
                            <?php if (session()->getFlashdata('sukses')) : ?>
                                Registrasi Berhasil
                            <?php else : ?>
                                Registrasi Gagal
                            <?php endif; ?>
                        </h5>
                        <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Flash data sukses atau gagal akan ditampilkan di sini -->
                        <?php if (session()->getFlashdata('sukses')) : ?>
                            <?= session()->getFlashdata('sukses'); ?>
                        <?php elseif (session()->getFlashdata('gagal')) : ?>
                            <?= session()->getFlashdata('gagal'); ?>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="tutup" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content -->
    </div>
</div>

<script src="<?= base_url() ?>assets/js/jquery-3.7.1.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        <?php if (session()->getFlashdata('sukses') || session()->getFlashdata('gagal')) : ?>
            $('#flashModal').modal('show');
        <?php endif; ?>

        $('#tutup').on('click', function() {
            $('#flashModal').modal('hide');
        });

        $('.close').on('click', function() {
            $('#flashModal').modal('hide');
        });
    });
</script>
<?= $this->endSection() ?>