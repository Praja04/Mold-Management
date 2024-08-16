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
                                    <h1 class="fs-40 text-white">Register Mold CBI</h1>

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
                            <h4 class="box-title">
                                Register New Mold
                            </h4>
                        </div>
                        <!-- /.box-header -->
                        <form class="form" method="post" action="<?= base_url('register/action/mold') ?>">
                            <div class="box-body">
                                <h4 class="box-title text-info mb-0">
                                    <i class="ti-layout me-15"></i> Mold Specification
                                </h4>
                                <hr class="my-15" />
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="form-label">Nama Mold</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="ITEM" name="ITEM" class="form-control" placeholder="Nama Mold" />
                                            <span class="input-group-text"><i class="ti-bag"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Made In</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="MADE_IN" name="MADE_IN" class="form-control" placeholder="Made In" />
                                            <span class="input-group-text"><i class="ti-flag-alt"></i></span> <!-- Ikon diubah -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Status</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="STATUS" name="STATUS" class="form-control" placeholder="Status" />
                                            <span class="input-group-text"><i class="ti-reload"></i></span> <!-- Ikon diubah -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Material</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="Material" name="Material" class="form-control" placeholder="Material" />
                                            <span class="input-group-text"><i class="ti-paint-bucket"></i></span> <!-- Ikon diubah -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Tonase</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="TONNAGE" name="TONNAGE" class="form-control" placeholder="Tonase" />
                                            <span class="input-group-text"><i class="ti-stats-up"></i></span> <!-- Ikon diubah -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Part</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="PART" name="PART" class="form-control" placeholder="Part" />
                                            <span class="input-group-text"><i class="ti-package"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Runner</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="RUNNER" name="RUNNER" class="form-control" placeholder="Runner" />
                                            <span class="input-group-text"><i class="ti-layout"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Cycle Time</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="CYCLE_TIME" name="CYCLE_TIME" class="form-control" placeholder="Cycle Time" />
                                            <span class="input-group-text"><i class="ti-timer"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Dimensi Mold</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="DIMENSI_MOLD" name="DIMENSI_MOLD" class="form-control" placeholder="Dimensi Mold" />
                                            <span class="input-group-text"><i class="ti-ruler"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Cavity</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="CAVITY" name="CAVITY" class="form-control" placeholder="Cavity" />
                                            <span class="input-group-text"><i class="ti-layout-grid3-alt"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Core</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="CORE" name="CORE" class="form-control" placeholder="Core" />
                                            <span class="input-group-text"><i class="ti-target"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Keterangan</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="KETERANGAN" name="KETERANGAN" class="form-control" placeholder="Keterangan" />
                                            <span class="input-group-text"><i class="ti-info"></i></span>
                                        </div>
                                    </div><br>
                                    <h4 class="box-title text-info mb-0">
                                        <i class="ti-user me-15"></i> User Mold
                                    </h4>
                                    <hr class="my-15" />
                                    <div class="form-group">
                                        <label class="form-label">Supplier</label>
                                        <div class="input-group mb-3">
                                            <select id="supplier" name="supplier" class="form-select">
                                                <option value="">Pilih Supplier</option>
                                                <?php foreach ($suppliers as $supplier) : ?>
                                                    <option value="<?= $supplier['suplier']; ?>"><?= $supplier['suplier']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <span class="input-group-text"><i class="ti-user"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer text-center">

                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti-save-alt"></i> Save
                                    </button>
                                </div>
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