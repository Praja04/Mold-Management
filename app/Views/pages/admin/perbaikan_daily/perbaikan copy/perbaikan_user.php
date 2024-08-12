<?= $this->extend('template/layout'); ?>

<?= $this->section('content') ?>

<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
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
            <a href="<?= base_url('report_perbaikan') ?>">
                Back To List Perbaikan
            </a>
            <div class="box">
                <div class="box-header with-border">
                    <h3>Perbaikan Mold User</h3>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example10" class="table table-bordered table-separated">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Mold</th>
                                                <th>Tanggal Pengajuan</th>
                                                <th>Kondisi Mold</th>
                                                <th>Rencana Perbaikan</th>
                                                <th>Keterangan</th>
                                                <th>Gambar Kerusakan</th>
                                                <th>Dokumen Pendukung</th>
                                                <th>Terima Perbaikan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="user">
                                            <?php $i = 1;
                                            foreach ($data as $user) : ?>
                                                <tr class="">
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $user['nama_mold']; ?></td>
                                                    <td><?= $user['tanggal_pengajuan'] ?></td>
                                                    <td><?= $user['kondisi_mold']; ?></td>
                                                    <td><?= $user['rencana_perbaikan'] ?></td>
                                                    <td><?= $user['keterangan'] ?></td>
                                                    <td> <button type="button" class="btn btn-link btn-image-modal2" data-pdf="<?= base_url('uploads/' . $user['dokumen_pendukung']); ?>">
                                                            <i class="fa fa-file-pdf-o"></i> Lihat dokumen
                                                        </button>
                                                    </td>
                                                    <td> <button type="button" class="btn btn-link btn-image-modal" data-pdf="<?= base_url('uploads/' . $user['gambar_rusak']); ?>">
                                                            <i class="fa fa-image "></i> Lihat Gambar
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <button type="submit" class="btn btn-success pull-right" onclick="ubahHasilVerifikasi(<?= $user['id_perbaikan'] ?>)">Accepted</button>
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

            <div class="box">
                <div class="box-header with-border">
                    <h3>History Perbaikan Mold User</h3>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example200" class="table table-bordered table-separated">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Mold</th>
                                                <th>Tanggal Pengajuan</th>
                                                <th>Kondisi Mold</th>
                                                <th>Rencana Perbaikan</th>
                                                <th>Gambar Kerusakan</th>
                                                <th>Dokumen Pendukung</th>
                                                <th>Terima Perbaikan</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="user">
                                            <?php $i = 1;
                                            foreach ($All_data as $user) : ?>
                                                <tr class="">
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $user['nama_mold']; ?></td>
                                                    <td><?= $user['tanggal_pengajuan'] ?></td>
                                                    <td><?= $user['kondisi_mold']; ?></td>
                                                    <td><?= $user['rencana_perbaikan'] ?></td>
                                                    <td> <button type="button" class="btn btn-link btn-image-modal2" data-pdf="<?= base_url('uploads/' . $user['dokumen_pendukung']); ?>">
                                                            <i class="fa fa-file-pdf-o"></i> Lihat dokumen
                                                        </button>
                                                    </td>
                                                    <td> <button type="button" class="btn btn-link btn-image-modal" data-pdf="<?= base_url('uploads/' . $user['gambar_rusak']); ?>">
                                                            <i class="fa fa-image "></i> Lihat Gambar
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <?php if ($user['terima_perbaikan'] != 0) {
                                                            echo ('<button class="btn btn-success-light">Sudah Acc</button>');
                                                        } else {
                                                            echo ('<button class="btn btn-danger-light">Belum Acc</button>');
                                                        } ?>
                                                    </td>
                                                    <td><?= $user['keterangan'] ?></td>
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

            <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="pdfModalLabel">Image Viewer</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <embed id="pdfViewer" src="" type="application/pdf" width="100%" height="600px">
                        </div>
                    </div>
                </div>
            </div>

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
        </section>
    </div>
</div>
<script src="<?= base_url() ?>assets/js/jquery-3.7.1.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $('.btn-image-modal').on('click', function() {
            var pdfUrl = $(this).data('pdf');
            $('#pdfViewer').attr('src', pdfUrl);
            $('#pdfModal').modal('show');
        });
        $('.btn-image-modal2').on('click', function() {
            var pdfUrl = $(this).data('pdf');
            $('#pdfViewer2').attr('src', pdfUrl);
            $('#pdfModal2').modal('show');
        });
        // Inisialisasi DataTables untuk tabel kedua dengan fitur pencarian dan pengaturan jumlah baris yang ditampilkan
        $('#example200').DataTable({
            "paging": true, // Mengaktifkan pagination
            "lengthChange": true, // Mengaktifkan opsi untuk mengubah jumlah baris yang ditampilkan
            "searching": true, // Mengaktifkan pencarian
            "ordering": true, // Mengaktifkan pengurutan
            "info": true, // Mengaktifkan informasi footer
            "autoWidth": false // Menonaktifkan pengaturan otomatis lebar kolom
        });
    });

    function ubahHasilVerifikasi(moldID) {
        $.ajax({
            url: '<?php echo base_url('perbaikan/acc/') ?>' + moldID,
            type: 'POST',
            success: function(response) {
                if (response.success === true) {
                    location.reload();
                } else {
                    alert('Gagal mengubah hasil verifikasi!');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
</script>

<?= $this->endSection() ?>