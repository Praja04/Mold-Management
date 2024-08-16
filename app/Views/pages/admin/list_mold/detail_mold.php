<?= $this->extend('template/layout'); ?>

</style>
<?= $this->section('content'); ?>
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h3 class="page-title">Details</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#"><i class="mdi mdi-home-outline"></i></a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">
                                    Product Mold
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Details
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
                <div class="col-lg-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4 col-sm-6">
                                    <div class="box box-body b-1 text-center no-shadow">
                                        <?php if (!empty($detail['Gambar_Mold'])) : ?>
                                            <!-- Image that can be clicked to open the modal -->
                                            <img style="width: 300px; height:400px; cursor: pointer;" src="<?= base_url('uploads/' . $detail['Gambar_Mold']) ?>" id="product-image" class="img-fluid" alt="Gambar Mold" data-bs-toggle="modal" data-bs-target="#imageModal" />
                                        <?php else : ?>
                                            <!-- Empty element if the image does not exist -->
                                            <div id="product-image" class="img-fluid"></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="col-md-8 col-sm-6">
                                    <h2 class="box-title mt-0"><?= $moldData[0]['ITEM'] ?></h2>
                                    <div class="list-inline">
                                        <span class="badge badge-info"><?= $moldData[0]['STATUS'] ?></span>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h6>Keterangan Mold</h6>
                                            <div class="input-group">
                                                <h4> <?= $moldData[0]['KETERANGAN'] ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="gap-items">
                                        <button id="update-data-btn" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modal-update-gambar">
                                            <i class="mdi mdi-file-image"></i> Update Gambar
                                        </button>
                                        <button id="update-data-btn" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-update-data">
                                            <i class="mdi mdi-equal-box"></i> Update Data Mold
                                        </button>
                                    </div>
                                    <hr>
                                    <h4 class="box-title mt-20">Spesifikasi</h4>
                                    <table class="table-no-border">
                                        <?php foreach ($moldData as $mold) : ?>
                                            <tr>
                                                <td class="form-label">Material</td>
                                                <td></td>
                                                <td>: <?= $mold['Material']; ?></td>
                                                <td></td>
                                                <td>
                                                    <p style="visibility: hidden;">----</p>
                                                </td>
                                                <td></td>
                                                <td class="form-label">Tonase</td>
                                                <td></td>
                                                <td>: <?= $mold['TONNAGE']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="form-label">Part</td>
                                                <td></td>
                                                <td>: <?= $mold['PART']; ?></td>
                                                <td></td>
                                                <td>
                                                    <p style="visibility: hidden;">----</p>
                                                </td>
                                                <td></td>
                                                <td class="form-label">Runner</td>
                                                <td></td>
                                                <td>: <?= $mold['RUNNER']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="form-label">Cycle Time</td>
                                                <td></td>
                                                <td>: <?= $mold['CYCLE_TIME']; ?></td>
                                                <td></td>
                                                <td>
                                                    <p style="visibility: hidden;">----</p>
                                                </td>
                                                <td></td>
                                                <td class="form-label">Dimensi</td>
                                                <td></td>
                                                <td>: <?= $mold['DIMENSI_MOLD']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="form-label">Cavity</td>
                                                <td></td>
                                                <td>: <?= $mold['CAVITY']; ?></td>
                                                <td></td>
                                                <td>
                                                    <p style="visibility: hidden;">----</p>
                                                </td>
                                                <td></td>
                                                <td class="form-label">Core</td>
                                                <td></td>
                                                <td>: <?= $mold['CORE']; ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </table>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <h4 class="box-title mt-40">General Info</h4>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>

                                                <tr>
                                                    <td width="390">Supplier</td>
                                                    <td><?= $suplierData[0]['suplier']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Total Produksi</td>
                                                    <td><?= $jumlah['jumlah_produk'] ?> pcs</td>
                                                </tr>
                                                <tr>
                                                    <td>Total Perbaikan Harian (Kecil)</td>
                                                    <td><?= $report ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Total Perbaikan Perbaikan Besar</td>
                                                    <td><?= $perbaikan ?></td>
                                                </tr>


                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Gambar Mold</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <?php if (!empty($detail['Gambar_Mold'])) : ?>
                            <!-- Image that can be clicked to open the modal -->
                            <img src="<?= base_url('uploads/' . $detail['Gambar_Mold']) ?>" class="img-fluid" alt="Gambar Mold" />
                        <?php else : ?>
                            <!-- Empty element if the image does not exist -->
                            <div id="product-image" class="img-fluid"></div>
                        <?php endif; ?>
                        <!-- Display the image inside the modal -->

                    </div>
                </div>
            </div>
        </div>

        <div class="modal center-modal fade" id="modal-update-gambar" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Gambar Mold</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 col-12" id="form1" style="width: 90%;padding-left: 7%;">
                                <!-- Basic Forms -->
                                <div class="box">

                                    <!-- /.box-header -->
                                    <form id="form1-content">
                                        <div class="box-body">
                                            <h4 class="mt-0 mb-20">1. Data Mold:</h4>
                                            <div class="form-group">
                                                <label class="form-label">Supplier:</label>
                                                <input type="text" class="form-control" id="suplier" readonly value="<?= $suplierData[0]['suplier'] ?>">

                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Part Name:</label>
                                                <input type="text" class="form-control" id="items" readonly value="<?= $moldData[0]['ITEM'] ?>">

                                            </div>

                                        </div>
                                    </form>
                                </div>
                                <!-- /.box -->
                            </div>

                            <div class="col-lg-12 col-12" id="form2" style="width: 90%;padding-left: 7%;">
                                <!-- Basic Forms -->
                                <div class="box">
                                    <!-- /.box-header -->
                                    <form id="form2-content">
                                        <div class="box-body">
                                            <h4 class="mt-0 mb-20">2. Gambar Mold:</h4>
                                            <h5 id="namapart"></h5>
                                            <div class="form-group">
                                                <label class="form-label">Gambar Mold:</label>
                                                <input class="form-control" type="file" id="gambar_mold">
                                            </div>
                                            <input type="hidden" id="mold_id" value="<?= $moldData[0]['NO'] ?>">
                                            <input type="hidden" id="user_id" value="<?= $userData[0] ?>">

                                        </div>

                                    </form>
                                </div>
                                <!-- /.box -->
                            </div>

                            <button type="button" class="btn btn-success" id="submitBtn">Submit</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal modal-right fade" id="modal-update-data" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content" style="height: max-content;">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Data Mold</h5>

                    </div>
                    <div class="modal-body">
                        <form id="update-data">
                            <input type="hidden" id="id" name="id_mold" value="<?= $mold['NO']; ?>">

                            <div class="form-group">
                                <label class="form-label">Material :</label>
                                <input class="form-control" type="text" id="material" name="material" value="<?= $mold['Material']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Part :</label>
                                <input class="form-control" type="text" id="part" name="part" value="<?= $mold['PART']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Cycle Time :</label>
                                <input class="form-control" type="text" id="cycle_time" name="cycle_time" value="<?= $mold['CYCLE_TIME']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Cavity :</label>
                                <input class="form-control" type="text" id="cavity" name="cavity" value="<?= $mold['CAVITY']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tonase :</label>
                                <input class="form-control" type="text" id="tonase" name="tonase" value="<?= $mold['TONNAGE']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Runner :</label>
                                <input class="form-control" type="text" id="runner" name="runner" value="<?= $mold['RUNNER']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Dimensi :</label>
                                <input class="form-control" type="text" id="dimensi" name="dimensi" value="<?= $mold['DIMENSI_MOLD']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Core :</label>
                                <input class="form-control" type="text" id="core" name="core" value="<?= $mold['CORE']; ?>" required>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer modal-footer-uniform">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="save-button" class="btn btn-primary float-end">Save changes</button>
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
        const baseUrl = "<?= base_url() ?>";

        $('#product-image').on('click', function() {
            $('#imageModal').modal('show');
        });

        $('#modal-update-gambar').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
        });
        $('#modal-update-data').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
        });

        $('#submitBtn').on('click', function() {
            var formData = new FormData();
            formData.append('moldIdContent', $('#mold_id').val());
            formData.append('user_id', $('#user_id').val());
            formData.append('partname', $('#items').val());
            formData.append('gambar_mold', $('#gambar_mold')[0].files[0]);
            // formData.append('gambar_part', $('#gambar_part')[0].files[0]);
            // formData.append('gambar_runner', $('#gambar_runner')[0].files[0]);
            // formData.append('drawing_produk', $('#drawing_produk')[0].files[0]);

            $.ajax({
                url: baseUrl + 'submit_verifikasi',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.hasOwnProperty('message')) {
                        showToast(response.message);
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else if (response.hasOwnProperty('error')) {
                        showToast(response.error, true);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });

        $('#save-button').on('click', function() {
            var formData = new FormData();
            formData.append('id', $('#id').val());
            formData.append('material', $('#material').val());
            formData.append('part', $('#part').val());
            formData.append('cycle_time', $('#cycle_time').val());
            formData.append('cavity', $('#cavity').val());
            formData.append('tonase', $('#tonase').val());
            formData.append('runner', $('#runner').val());
            formData.append('dimensi', $('#dimensi').val());
            formData.append('core', $('#core').val());
            $.ajax({
                url: baseUrl + 'update/data/mold',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.hasOwnProperty('message')) {
                        showToast(response.message);
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else if (response.hasOwnProperty('error')) {
                        showToast(response.error, true);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });

        function showToast(message, isError = false) {
            var submitToast = $('#submitToast');
            if (submitToast.length) {
                if (isError) {
                    message = 'Invalid input';
                    submitToast.removeClass('bg-success').addClass('bg-danger');
                } else {
                    submitToast.removeClass('bg-danger').addClass('bg-success');
                }
                submitToast.find('.toast-body').html(message);
                submitToast.toast('show');
            } else {
                console.error('Element for toast not found!');
            }
        }

    });
</script>
<?= $this->endSection() ?>