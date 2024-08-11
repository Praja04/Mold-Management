<?= $this->extend('template/layout'); ?>
<?= $this->section('style') ?>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
    }

    .container {
        width: 800px;
        border: 1px solid #000;
        padding: 20px;
    }

    .content2,
    .subject,
    .specifications,
    .results,
    .decision {
        border: 1px solid #000;
        padding: 10px;
        margin-bottom: 10px;
    }

    .header2 {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid #000;
        padding: 10px;
        margin-bottom: 10px;
    }

    .header2 .logo img {
        width: 100px;
    }

    .header2 .title {
        flex-grow: 1;
        text-align: center;
        font-weight: bold;
    }

    .header2 .details {
        text-align: right;
    }

    .clearfix::after {
        content: "";
        clear: both;
        display: table;
    }

    .subject,
    .specifications,
    .results,
    .decision {
        margin-bottom: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }

    table,
    th,
    td {
        border: 1px solid #000;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    .signature-tables {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .signature-table {
        width: 200px;
        border: 1px solid #000;
        text-align: center;
        padding: 10px;
    }

    .footer {
        text-align: center;
        font-size: 12px;
    }

    .modal-body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    .signature-pad {
        border: 1px solid #ccc;
        cursor: crosshair;
    }

    .signature-image {
        margin-top: 10px;
        max-width: 100%;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <?php if ($moldData) : ?>
                <?php if ($moldData['Hasil_Verifikasi'] != 0) : ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="box no-shadow mb-0 bg-transparent">
                                <div class="box-header no-border px-0">
                                    <ul class="box-controls pull-right d-md-flex d-none">
                                        <li class="dropdown">
                                            <button class="dropdown-toggle btn btn-primary-light px-10" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                                                Dokumen Verifikasi
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a style="margin: 5px;" href="<?= base_url('admin/downloadPdf/' . $moldData['Hasil_Verifikasi']) ?>" class="dropdown-item active"><i class="ti-import"></i>Download</a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div><br><br>

                <?php endif; ?>
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h2 class="box-title">Verifikasi Mold</h2>
                            </div>
                            <!-- /.box-header -->
                            <form class="form">
                                <div class="box-body">
                                    <h4 class="box-title text-info mb-0">
                                        <i class="ti-info me-15"></i> Info
                                    </h4>
                                    <hr class="my-15" />
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Part Name</label>
                                                <input type="text" class="form-control text-center" value="<?= $moldData['Part_Name'] ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Tahun Dibuat / Pembuatan</label>
                                                <input type="text" class="form-control text-center" value="<?= $Item['MADE_IN'] ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="form-group" style="visibility: hidden;">
                                            <input class="form-control" type="hidden" class="form-control" id="moldID" name="moldID" value="<?= $moldData['Id'] ?>">
                                            <!-- Set default value for hasilverif -->
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Material</label>
                                                <input type="text" class="form-control text-center" value="<?= $Item['Material'] ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Dimensi Mold</label>
                                                <input type="text" class="form-control text-center" value="<?= $Item['DIMENSI_MOLD'] ?>" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Drawing Produk</label><br>
                                                <button type="button" class="btn btn-link btn-image-modal2" data-pdf="<?= base_url('uploads/' . $moldData['Drawing_Produk']); ?>">

                                                    <i class="fa fa-file-pdf-o"></i> Lihat dokumen
                                                </button>
                                            </div>
                                        </div>
                                    </div><br>
                                    <h4 class="box-title text-info mb-0 mt-20">
                                        <i class="ti-image me-15"></i> Gambar
                                    </h4>
                                    <hr class="my-15" />

                                    <div class="row">
                                        <div class="col-md-4 ">
                                            <img src="<?= base_url() ?>uploads/<?= $moldData['Gambar_Mold'] ?>" style="width: 100%; height:200px;border-radius:10px"></a>
                                            <h4 class="text-center">Gambar Mold</h4>
                                            <p class="text-center">Tonase Mesin : <?= $moldData['Deskripsi_Mold'] ?> Ton</p>
                                        </div>
                                        <div class="col-md-4">
                                            <img src="<?= base_url() ?>uploads/<?= $moldData['Gambar_Part'] ?>" style="width: 100%; height:200px;border-radius:10px"></a>
                                            <h4 class="text-center">Gambar Part</h4>
                                            <p class="text-center">Weight : <?= $moldData['Deskripsi_Part'] ?> gr</p>
                                        </div>
                                        <div class="col-md-4">
                                            <img src="<?= base_url() ?>uploads/<?= $moldData['Gambar_Runner'] ?>" style="width: 100%; height:200px;border-radius:10px"></a>
                                            <h4 class="text-center">Gambar Runner</h4>
                                            <p class="text-center">Weight : <?= $moldData['Deskripsi_Runner'] ?> gr</p>
                                        </div>
                                    </div><br><br>

                                    <h4 class="box-title text-info mb-0 mt-20">
                                        <i class="ti-save me-15"></i> Verifikasi
                                    </h4>
                                    <hr class="my-15" />
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Subject Mold</label>
                                                <input type="text" class="form-control text-center" value="<?= $moldData['Subject_Mold'] ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Tools/Jig</label>
                                                <input type="text" class="form-control text-center" value="<?= $moldData['Subject_Tool'] ?>" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Mesin</label>
                                                <input type="text" class="form-control text-center" value="<?= $moldData['Subject_Mesin'] ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Produk</label>
                                                <input type="text" class="form-control text-center" value="<?= $moldData['Subject_Produk'] ?>" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Proses</label>
                                                <input type="text" class="form-control text-center" value="<?= $moldData['Subject_Proses'] ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Validasi Ke</label>
                                                <input type="text" class="form-control text-center" value="<?= $moldData['Validasi_Ke'] ?>" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Ada kaitan dengan LK3</label>
                                                <input type="text" class="form-control text-center" value="<?= $moldData['LK3'] ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Spesifikasi</label>
                                                <input type="text" class="form-control text-center" value="<?= $moldData['Spesifikasi'] ?>" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <?php if($moldData['Hasil_Verifikasi'] == '0'):?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Nomor Dokumen</label>
                                                <input type="text" class="form-control text-center" id="nomor_dokumen" />
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif;?>
                                </div>
                                <!-- /.box-body -->
                                <?php if ($moldData['Hasil_Verifikasi'] == 0) : ?>
                                    <div class="box-footer">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDiketahui">
                                            Tanda Tangan Diketahui Oleh
                                        </button>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDiperiksa">
                                            Tanda Tangan Diperiksa Oleh
                                        </button>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDibuat">
                                            Tanda Tangan Dibuat Oleh
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </form>
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
                <?php if ($moldData['Hasil_Verifikasi'] == 0) : ?>
                    <div class="button-container">
                        <button id="generate-pdf" class="btn btn-primary" style="visibility: hidden;">Generate PDF</button>
                    </div>
                    <div class="container" id="verifikasi-content">
                        <div class="header2 clearfix">
                            <div class="logo">
                                <img src="<?= base_url() ?>assets/images/logo1.png" alt="Logo" width="100">
                            </div>
                            <div class="title">
                                <p>VERIFIKASI</p>
                            </div>
                            <div class="details">
                                <p>Departemen : Engineering</p>
                                <p id="date_verif">Tanggal : </p>
                                <p id="no_dok">Nomor Dokumen : </p>
                            </div>
                        </div>
                        <div class="subject">
                            <table>
                                <tr>
                                    <th>Item</th>
                                    <th>Baru</th>
                                    <th>Modifikasi</th>
                                </tr>
                                <tr>
                                    <?php if ($moldData['Subject_Mold'] == 'baru') : ?>
                                        <td>Mold</td>
                                        <td><?= $moldData['Subject_Mold'] ?></td>
                                        <td></td>
                                    <?php else : ?>
                                        <td>Mold</td>
                                        <td></td>
                                        <td><?= $moldData['Subject_Mold'] ?></td>
                                    <?php endif; ?>
                                </tr>
                                <tr>
                                    <?php if ($moldData['Subject_Tool'] == 'baru') : ?>
                                        <td>Jig / Tools</td>
                                        <td><?= $moldData['Subject_Tool'] ?></td>
                                        <td></td>
                                    <?php else : ?>
                                        <td>Jig / Tools</td>
                                        <td></td>
                                        <td><?= $moldData['Subject_Tool'] ?></td>
                                    <?php endif; ?>
                                </tr>
                                <tr>
                                    <?php if ($moldData['Subject_Mesin'] == 'baru') : ?>
                                        <td>Mesin</td>
                                        <td><?= $moldData['Subject_Mesin'] ?></td>
                                        <td></td>
                                    <?php else : ?>
                                        <td>Mesin</td>
                                        <td></td>
                                        <td><?= $moldData['Subject_Mesin'] ?></td>
                                    <?php endif; ?>
                                </tr>
                                <tr>
                                    <?php if ($moldData['Subject_Produk'] == 'baru') : ?>
                                        <td>Produk / Komponen</td>
                                        <td><?= $moldData['Subject_Produk'] ?></td>
                                        <td></td>
                                    <?php else : ?>
                                        <td>Produk / Komponen</td>
                                        <td></td>
                                        <td><?= $moldData['Subject_Produk'] ?></td>
                                    <?php endif; ?>
                                </tr>
                                <tr>
                                    <?php if ($moldData['Subject_Proses'] == 'baru') : ?>
                                        <td>Proses / Metode</td>
                                        <td><?= $moldData['Subject_Proses'] ?></td>
                                        <td></td>
                                    <?php else : ?>
                                        <td>Proses / Metode</td>
                                        <td></td>
                                        <td><?= $moldData['Subject_Proses'] ?></td>
                                    <?php endif; ?>
                                </tr>
                            </table>
                        </div>
                        <div class="content2">
                            <p><strong>Nama:</strong> <?= $moldData['Part_Name'] ?></p>
                            <!-- <p><strong>Tipe/Jenis:</strong> DIN 555 MF</p> -->
                            <p><strong>Subcont/Supplier: </strong><?= $moldData['Subcount_Suplier'] ?></p>
                            <p><strong>Verifikasi/validasi ke: </strong><?= $moldData['Validasi_Ke'] ?></p>
                            <p><strong>Ada kaitan dengan LK3: </strong><?= $moldData['LK3'] ?></p>
                        </div>
                        <div class="specifications">
                            <p><strong>Spesifikasi:</strong></p>
                            <p>Material: <?= $Item['Material'] ?></p>
                            <p>Keterangan: <?= $moldData['Spesifikasi'] ?></p>
                        </div>
                        <div class="results">
                            <p><strong>Hasil verifikasi/validasi:</strong></p>
                            <p>Dimensi: <?= $Item['DIMENSI_MOLD'] ?></p>
                            <p>Berat Part: <?= $moldData['Deskripsi_Part'] ?> gr</p>
                            <p>Berat Runner: <?= $moldData['Deskripsi_Runner'] ?> gr</p>
                        </div>
                        <div class="decision">
                            <p><strong>Keputusan (diisi oleh Ka. Dept. Engineering):</strong></p>
                        </div>
                        <div class="signature-tables">
                            <div class="signature-table">
                                <p>Diketahui</p>

                                <div class="diketahui" id="diketahui"></div>
                            </div>
                            <div class="signature-table">
                                <p>Diperiksa</p>

                                <div class="diperiksa" id="diperiksa"></div>
                            </div>
                            <div class="signature-table">
                                <p>Dibuat</p>

                                <div class="dibuat" id="dibuat"></div>
                            </div>

                        </div>

                    </div>

                    <!-- Modal for Diketahui -->
                    <div class="modal fade" id="modalDiketahui" tabindex="-1" aria-labelledby="modalDiketahuiLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalDiketahuiLabel">Tanda Tangan Diketahui</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <canvas id="signature-pad-diketahui" class="signature-pad"></canvas>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="save-diketahui">Save</button>
                                    <button type="button" class="btn btn-primary" id="clear-diketahui">Clear</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Diperiksa -->
                    <div class="modal fade" id="modalDiperiksa" tabindex="-1" aria-labelledby="modalDiperiksaLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalDiperiksaLabel">Tanda Tangan Diperiksa</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <canvas id="signature-pad-diperiksa" class="signature-pad"></canvas>
                                </div>
                                <div class="modal-footer">

                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="save-diperiksa">Save</button>
                                    <button type="button" class="btn btn-primary" id="clear-diperiksa">Clear</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Dibuat -->
                    <div class="modal fade" id="modalDibuat" tabindex="-1" aria-labelledby="modalDibuatLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalDibuatLabel">Tanda Tangan Dibuat</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <canvas id="signature-pad-dibuat" class="signature-pad"></canvas>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="save-dibuat">Save</button>
                                    <button type="button" class="btn btn-primary" id="clear-dibuat">Clear</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>


            <?php else : ?>
                <h1>Data Mold tidak ditemukan</h1>
                <p>Untuk User ini, tidak ada data mold yang tersedia.</p>
            <?php endif; ?>
            <div class="modal fade" id="pdfModal2" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="pdfModalLabel">Dokumen Viewer</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <embed id="pdfViewer2" src="" type="application/pdf" width="100%" height="600px">
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
        </section>



        <!-- /.content -->
    </div>

</div>
<script src="<?= base_url() ?>assets/js/jquery-3.7.1.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/js/html2canvas.min.js"></script>
<script src="<?= base_url() ?>assets/js/signature_pad.min.js"></script>
<script src="<?= base_url() ?>assets/js/jspdf.umd.min.js"></script>
<script src="<?= base_url() ?>assets/js/signature_pad.umd.min.js"></script>
<script>
    $(document).ready(function() {
        var signaturePadDiketahui = new SignaturePad(document.getElementById('signature-pad-diketahui'));
        var signaturePadDiperiksa = new SignaturePad(document.getElementById('signature-pad-diperiksa'));
        var signaturePadDibuat = new SignaturePad(document.getElementById('signature-pad-dibuat'));
        let waktuSekarang = new Date();
        var tahun = waktuSekarang.getFullYear();
        var bulan = waktuSekarang.getMonth() + 1; // Ingat, bulan dimulai dari 0, jadi perlu ditambahkan 1
        var tanggal = waktuSekarang.getDate();
        $('#date_verif').text('Tanggal : ' + tanggal + '/' + bulan + '/' + tahun);

        $('#save-diketahui').on('click', function() {
            var dataUrl = signaturePadDiketahui.toDataURL();
            $('#diketahui').html('<img src="' + dataUrl + '" />');
            $('#modalDiketahui').modal('hide');
        });
        $('#clear-diketahui').on('click', function() {
            var canvas = document.getElementById('signature-pad-diketahui');
            var context = canvas.getContext('2d');
            context.clearRect(0, 0, canvas.width, canvas.height);
            $('#diketahui').empty();
        });


        $('#save-diperiksa').on('click', function() {
            var dataUrl = signaturePadDiperiksa.toDataURL();
            $('#diperiksa').html('<img src="' + dataUrl + '" />');
            $('#modalDiperiksa').modal('hide');
        });
        $('#clear-diperiksa').on('click', function() {
            var canvas = document.getElementById('signature-pad-diperiksa');
            var context = canvas.getContext('2d');
            context.clearRect(0, 0, canvas.width, canvas.height);
            $('#diperiksa').empty();
        });

        $('#save-dibuat').on('click', function() {
            var dataUrl = signaturePadDibuat.toDataURL();
            $('#dibuat').html('<img src="' + dataUrl + '" />');
            $('#modalDibuat').modal('hide');
            $('#generate-pdf').css('visibility', 'visible');
        });

        $('#clear-dibuat').on('click', function() {
            var canvas = document.getElementById('signature-pad-dibuat');
            var context = canvas.getContext('2d');
            context.clearRect(0, 0, canvas.width, canvas.height);
            $('#dibuat').empty();
        });



        $('.btn-image-modal2').on('click', function() {
            var pdfUrl = $(this).data('pdf');
            $('#pdfViewer2').attr('src', pdfUrl);
            $('#pdfModal2').modal('show');
        });

        $('#generate-pdf').on('click', function() {
            html2canvas(document.querySelector("#verifikasi-content"), {
                scale: 1 // Ubah skala jika perlu
            }).then(canvas => {
                const {
                    jsPDF
                } = window.jspdf;
                var doc = new jsPDF('p', 'pt', 'a4');

                var a4Width = 595.28;
                var a4Height = 841.89;

                var imgWidth = a4Width;
                var imgHeight = canvas.height * imgWidth / canvas.width;

                var xOffset = (a4Width - imgWidth) / 2;
                var yOffset = (a4Height - imgHeight) / 2;

                if (imgHeight <= a4Height) {
                    doc.addImage(canvas.toDataURL('image/png'), 'PNG', xOffset, yOffset, imgWidth, imgHeight);
                } else {
                    imgHeight = a4Height;
                    imgWidth = canvas.width * imgHeight / canvas.height;
                    xOffset = (a4Width - imgWidth) / 2;
                    yOffset = 0;

                    doc.addImage(canvas.toDataURL('image/png'), 'PNG', xOffset, yOffset, imgWidth, imgHeight);
                }

                var pdfBlob = doc.output('blob');
                var formData = new FormData();
                formData.append('verifikasi_pdf', pdfBlob, 'verifikasi.pdf');
                formData.append('moldID', $('#moldID').val());

                $.ajax({
                    url: '<?= base_url() ?>admin/updateHasilVerifikasi',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {

                        if (response.status === 'success') {
                            showModal('Success', 'Data Sudah diverifikasi');
                        } else {
                            message = response.message || 'Gagal memverifikasi data.';
                            showModal(message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Gagal mengunggah file:', errorThrown);
                        console.error('Response:', jqXHR.responseText); // Log the response text
                    }
                });
            });
        });

       
        $('#nomor_dokumen').on('change', function() {
            no_dok = $(this).val();
            $('#no_dok').text('Nomor Dokumen : ' + no_dok);
        });

        function showModal(message, callback) {
            if (message = 'Data submitted successfully!') {
                $('#modalMessage').text('Data Sudah Diverifikasi');
                $('#alertModal').modal('show');
            } else {
                $('#modalMessage').text(message);
                $('#alertModal').modal('show');
            }

            if (callback) {
                $('#alertModal').on('hidden.bs.modal', function() {
                    callback();
                    $(this).off('hidden.bs.modal'); // Remove the callback to avoid multiple triggers
                });
            }
            $('#modalok').on('click', function() {
                location.reload();
            });
        }
    });
</script>
<?= $this->endSection() ?>