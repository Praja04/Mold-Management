<?= $this->extend('template/layout'); ?>

</style>
<?= $this->section('content'); ?>
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center justify-content-between">
                <!-- Bagian Kiri -->
                <div class="me-auto">
                    <h3 class="page-title">Details</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a><i class="mdi mdi-home-outline"></i></a>
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

                <!-- Bagian Kanan -->

                <div class="list-inline text-end">
                    <div class="form-group">
                        <?php if (empty($detail['dokumen_mold'])) : ?>
                            <button data-bs-toggle="modal" data-bs-target="#modal-dokumen" class="btn btn-info" style="font-size: small;">Upload Dokumen Mold <span id="dokumen" class="mdi mdi-file-document"></span></button>
                        <?php else : ?>
                            <li class="dropdown">
                                <button class="dropdown-toggle btn btn-primary-light px-10" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                                    Dokumen Mold
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="btn-pdf-modal dropdown-item active" data-pdf="<?= base_url('uploads/' . $detail['dokumen_mold']); ?>">Dokumen 1</a>
                                    <a class="btn-pdf-modal dropdown-item active" data-pdf="<?= base_url('uploads/' . $detail['dokumen_mold2']); ?>">Dokumen 2</a>
                                    <a class="btn-pdf-modal dropdown-item active" data-pdf="<?= base_url('uploads/' . $detail['dokumen_mold3']); ?>">Dokumen 3</a>
                                    <a data-bs-toggle="modal" data-id-dokumen="<?= $detail['Id'] ?>" data-bs-target="#modal-update-dokumen" class="dropdown-item active bg-warning text-white">Ubah Dokumen</a>
                                </div>
                            </li>
                        <?php endif; ?>

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
                                    <div class="col-md-8">
                                        <h2 class="box-title mt-0"><?= $moldData[0]['ITEM'] ?></h2>
                                        <span id="update-ITEM" class="btn" data-bs-toggle="modal" data-bs-target="#modal-update-ITEM"> <i class="mdi mdi-lead-pencil mdi-18px"></i></span>
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
                                        <button style="margin-top: 5px;" id="update-gambar-btn" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modal-update-gambar">
                                            <i class="mdi mdi-file-image"></i> Update Gambar
                                        </button>
                                        <button style="margin-top: 5px;" id="update-data-btn" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-update-data">
                                            <i class="mdi mdi-equal-box"></i> Update Data Mold
                                        </button>
                                        <button style="margin-top: 5px;" id="update-status-btn" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-update-status">
                                            <i class="mdi mdi-loop"></i> Update Status
                                        </button>
                                        <button style="margin-top: 5px;" id="delete-btn" type="button" class="btn btn-danger btn-delete" data-id="<?= $moldData[0]['NO'] ?>">
                                            <i class="mdi mdi-delete"></i> Delete Mold
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
                                                    <td>
                                                        <?= $suplierData[0]['suplier']; ?>

                                                    </td>
                                                    <td>
                                                        <button style="margin-left: 15px;" class="btn btn-warning" id="update-suplier-btn" data-bs-toggle="modal" data-bs-target="#modal-suplier" data-id="<?= $moldData[0]['NO'] ?>"><span class="mdi mdi-account-edit mdi-20px"></span>&nbsp;Pindah</button>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>Total Produksi</td>
                                                    <td><?= number_format($jumlah['jumlah_produk'], 0, ',', '.') ?> pcs</td>
                                                    <td>
                                                        <form action="<?= base_url('export-excel/') ?><?= urlencode($moldData[0]['ITEM']) ?>"   method="get" style="display: inline;">
                                                            <button type="submit" class="btn btn-success text-white me-0">
                                                                <span class="mdi mdi-file-excel-box"></span> Export Excel
                                                            </button>
                                                            <select name="tahun" required>
                                                                <?php
                                                                $currentYear = date('Y');
                                                                for ($year = $currentYear; $year >= $currentYear - 10; $year--) {
                                                                    echo "<option value=\"$year\">$year</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Total Perbaikan Harian (Kecil)</td>
                                                    <td>
                                                        <?= number_format($report, 0, ',', '.') ?>
                                                    </td>
                                                    <td>
                                                        <a style="margin-left: 15px;" class="btn btn-primary text-white me-0" href="<?= base_url('daily/detail') ?>?namaMold=<?= urlencode($moldData[0]['ITEM']) ?>"><span class="mdi mdi-calendar-today"></span> harian</a>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>Total Perbaikan Perbaikan Besar</td>
                                                    <td><?= number_format($perbaikan, 0, ',', '.') ?></td>
                                                    <td>
                                                        <a style="margin-left: 15px;" class="btn btn-primary text-white me-0" href="<?= base_url('perbaikan/besar/detail') ?>?namaMold=<?= urlencode($moldData[0]['ITEM']) ?>"><span class="mdi mdi-package-variant"></span> perbaikan</a>
                                                    </td>
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

        <div class="modal center-modal fade" id="modal-update-dokumen" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content" style="height: max-content;">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Dokumen Mold</h5>
                    </div>
                    <div class="modal-body">

                        <form id="dokumen_mold">
                            <input type="hidden" id="update_id_dokumen" name="id_mold">
                            <div class="form-group">
                                <label class="form-label">Dokumen Mold 1 :</label>
                                <input type="file" class="form-control" id="update_dokumen_mold">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Dokumen Mold 2 :</label>
                                <input type="file" class="form-control" id="update_dokumen_mold2">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Dokumen Mold 3 :</label>
                                <input type="file" class="form-control" id="update_dokumen_mold3">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer modal-footer-uniform">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="update-button-dokumen" class="btn btn-primary float-end">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal center-modal fade" id="modal-dokumen" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content" style="height: max-content;">
                    <div class="modal-header">
                        <h5 class="modal-title">Dokumen Pendukung Mold</h5>
                    </div>
                    <div class="modal-body">

                        <?php if (!empty($detail['Gambar_Mold'])) : ?>
                            <form id="upload_dokumen_mold">
                                <input type="hidden" id="id_dokumen" name="id_mold" value="<?= $detail['Id']; ?>">
                                <div class="form-group">
                                    <label class="form-label">Dokumen Mold 1 :</label>
                                    <input type="file" class="form-control" id="dokumen_mold">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Dokumen Mold 2 :</label>
                                    <input type="file" class="form-control" id="dokumen_mold2">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Dokumen Mold 3 :</label>
                                    <input type="file" class="form-control" id="dokumen_mold3">
                                </div>
                            </form>
                        <?php else : ?>
                            <p>Upload Gambar Dahulu</p>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer modal-footer-uniform">
                        <?php if (!empty($detail['Gambar_Mold'])) : ?>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="button" id="save-button-dokumen" class="btn btn-primary float-end">Save changes</button>
                        <?php else : ?>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pdfModalLabel">Dokumen View</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <embed id="pdfViewer" src="" type="application/pdf" width="100%" height="600px">
                    </div>
                </div>
            </div>
        </div>

        <div class="modal center-modal fade" id="modal-suplier" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content" style="height: max-content;">
                    <div class="modal-header">
                        <h5 class="modal-title">Pemindahan Mold</h5>

                    </div>
                    <div class="modal-body">
                        <form id="update-suplier">
                            <input type="hidden" id="id_pindah" name="id_mold">
                            <div class="form-group">
                                <label class="form-label">Pindahkan ke Suplier</label>
                                <select id="suplier" name="suplier" class="form-select">
                                    <option value="">Pilih Supplier</option>
                                    <?php foreach ($suppliers as $supplier) : ?>
                                        <option value="<?= $supplier['suplier']; ?>"><?= $supplier['suplier']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer modal-footer-uniform">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="save-button-suplier" class="btn btn-primary float-end">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal center-modal fade" id="modal-update-ITEM" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content" style="height: max-content;">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Nama Mold</h5>

                    </div>
                    <div class="modal-body">
                        <form id="update-ITEM">
                            <input type="hidden" id="id" name="id_mold" value="<?= $mold['NO']; ?>">

                            <div class="form-group">
                                <label class="form-label">Nama Mold :</label>
                                <input class="form-control" type="text" id="ITEM" name="ITEM" value="<?= $mold['ITEM']; ?>" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer modal-footer-uniform">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="save-button-ITEM" class="btn btn-primary float-end">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

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

        <div class="modal center-modal fade" id="modal-update-status" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content" style="height: max-content;">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Status Mold</h5>

                    </div>
                    <div class="modal-body">
                        <form id="update-status">
                            <input type="hidden" id="id" name="id_mold" value="<?= $mold['NO']; ?>">
                            <div class="form-group">
                                <label class="form-label">Status Mold</label>
                                <select class="form-select" name="status" id="status">
                                    <option value="ACTIVE">Active</option>
                                    <option value="INACTIVE">In Active</option>
                                    <option value="NEW / INACTIVE">NEW / In Active</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer modal-footer-uniform">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="save-button-status" class="btn btn-primary float-end">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal center-modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah yakin menghapus data mold ini <strong>(<?= $moldData[0]['ITEM'] ?>)</strong> ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
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


        <!-- /.content -->
    </div>
</div>

<script src="<?= base_url() ?>assets/js/jquery-3.7.1.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        const baseUrl = "<?= base_url() ?>";

        $('.btn-pdf-modal').on('click', function() {
            var pdfUrl = $(this).data('pdf');
            $('#pdfViewer').attr('src', pdfUrl);
            $('#pdfModal').modal('show');
        });

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
        $('#modal-update-ITEM').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
        });
        $('#modal-dokumen').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
        });
        $('#modal-update-status').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
        });
        $('#modal-suplier').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var idMold = button.data('id');
            var modal = $(this);
            modal.find('#id_pindah').val(idMold);
        });
        $('#modal-update-dokumen').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var idMold = button.data('id-dokumen');
            var modal = $(this);
            modal.find('#update_id_dokumen').val(idMold);
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

        $('#save-button-ITEM').on('click', function() {
            var formData = new FormData();
            formData.append('id', $('#id').val());
            formData.append('ITEM', $('#ITEM').val());

            $.ajax({
                url: baseUrl + 'update/data/ITEM',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.hasOwnProperty('message')) {
                        showToast(response.message);
                        setTimeout(function() {
                            window.location.href = '<?= base_url('products/mold') ?>';
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
        $('#save-button-dokumen').on('click', function() {

            var formData = new FormData();
            formData.append('id', $('#id_dokumen').val());
            formData.append('dokumen_mold', $('#dokumen_mold')[0].files[0]);
            formData.append('dokumen_mold2', $('#dokumen_mold2')[0].files[0]);
            formData.append('dokumen_mold3', $('#dokumen_mold3')[0].files[0]);

            $.ajax({
                url: baseUrl + 'submit/dokumen',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.hasOwnProperty('message')) {
                        $('#modalok').on('click', function() {
                            location.reload(); // Redirect to the specified URL
                        });
                        showModal(response.message);
                    } else if (response.hasOwnProperty('error')) {
                        showModal(response.error, true);
                    }
                },
                error: function(xhr, status, error) {
                    // Display more detailed error message in the UI
                    var errorMessage = 'Error ' + xhr.status + ': ' + xhr.statusText;
                    if (xhr.responseText) {
                        errorMessage += ' - ' + xhr.responseText;
                    }
                    showModal(errorMessage, true);
                }
            });
        });
        $('#update-button-dokumen').on('click', function() {

            var formData = new FormData();
            formData.append('id', $('#update_id_dokumen').val());
            formData.append('dokumen_mold', $('#update_dokumen_mold')[0].files[0]);
            formData.append('dokumen_mold2', $('#update_dokumen_mold2')[0].files[0]);
            formData.append('dokumen_mold3', $('#update_dokumen_mold3')[0].files[0]);

            $.ajax({
                url: baseUrl + 'update/dokumen',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.hasOwnProperty('message')) {
                        $('#modalok').on('click', function() {
                            location.reload(); // Redirect to the specified URL
                        });
                        showModal(response.message);
                    } else if (response.hasOwnProperty('error')) {
                        showModal(response.error, true);
                    }
                },
                error: function(xhr, status, error) {
                    // Display more detailed error message in the UI
                    var errorMessage = 'Error ' + xhr.status + ': ' + xhr.statusText;
                    if (xhr.responseText) {
                        errorMessage += ' - ' + xhr.responseText;
                    }
                    showModal(errorMessage, true);
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

        $('#save-button-status').on('click', function() {
            var formData = new FormData();
            formData.append('id', $('#id').val());
            formData.append('status', $('#status').val())
            $.ajax({
                url: baseUrl + 'update/status/mold',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.hasOwnProperty('message')) {

                        $('#modal-update-status').modal('hide');
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

        $('#save-button-suplier').on('click', function() {
            var formData = new FormData();
            formData.append('id', $('#id_pindah').val());
            formData.append('suplier', $('#suplier').val())
            $.ajax({
                url: baseUrl + 'pemindahan/mold',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.hasOwnProperty('message')) {

                        $('#modal-suplier').modal('hide');
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


        $('.btn-delete').on('click', function() {
            deleteId = $(this).data('id');
            $('#deleteModal').modal('show'); // Show the confirmation modal
        });

        $('#confirmDeleteBtn').on('click', function() {
            $.ajax({
                url: '<?= base_url('delete/mold/'); ?>' + deleteId, // Replace 'controllerName' with your actual controller name
                type: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        $('#deleteModal').modal('hide'); // Hide the modal
                        $('#modalok').on('click', function() {
                            window.location.href = '<?= base_url('products/mold') ?>'; // Redirect to the specified URL
                        });
                        showModal('Data deleted successfully.');

                    } else {
                        showModal(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    showModal('An error occurred: ' + xhr.status + ' ' + xhr.statusText);
                }
            });
        });


        function showModal(message, callback) {
            if (message === 'Data submitted successfully!') {
                $('#modalMessage').text('Data Sudah Diverifikasi');
            } else {
                $('#modalMessage').text(message);
            }
            $('#alertModal').modal('show');

            if (callback) {
                $('#alertModal').on('hidden.bs.modal', function() {
                    callback();
                    $(this).off('hidden.bs.modal'); // Menghapus callback setelah dipanggil agar tidak memicu berkali-kali
                });
            }


        }

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