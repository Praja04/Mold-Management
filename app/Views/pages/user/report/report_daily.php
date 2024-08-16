<?= $this->extend('template/layout'); ?>

<?= $this->section('content') ?>

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
                                    <h1 class="fs-40 text-white"> Report Harian Mold</h1>

                                </div>
                                <div class="col-12 col-lg-4"><img src="<?= base_url('assets/images/custom-15.svg') ?>" alt=""></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-12" id="form1" style="width: 90%;padding-left: 7%;">
                    <!-- Basic Forms -->
                    <div class="box">

                        <!-- /.box-header -->
                        <form id="form1-content">
                            <div class="box-body">
                                <h4>Form Report Harian</h4>
                                <h4 class="box-title text-info mb-0"><i class="ti-info me-15"></i> Informasi</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Nama Mold</label>
                                            <?php if ($item) { ?>
                                                <input class="form-control" id="partname" type="text" value="<?= $item ?>" data-id="<?= $id ?>" disabled>
                                            <?php } else { ?>
                                                <select class="form-select" id="partname">
                                                    <option id="partname2"></option>
                                                </select>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Suplier</label>
                                            <input type="text" class="form-control" id="suplier" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Tanggal Report</label>
                                            <input type="date" id="tanggal_report" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Material Produk</label>
                                            <select id="material" class="form-select material" name="material[]" required>
                                                <option value="" disabled selected>Pilih Opsi</option>
                                                <option value="PP Samsung BJ520">PP Samsung BJ520</option>
                                                <option value="PP Hyosung J640">PP Hyosung J640</option>
                                                <option value="PP Basel EP400">PP Basel EP400</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="other-material-container" style="display:none;">
                                        <div class="form-group">
                                            <label class="form-label">Tentukan Materi Lainnya</label>
                                            <input type="text" id="other-material" class="form-control" name="other_material" placeholder="Masukan material lainnya">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <br><br>
                                    <h4 class="box-title text-info mb-0 mt-20"><i class="ti-save me-15"></i>Hasil Produksi </h4>
                                    <hr class="my-15">
                                    <div class="form-group">
                                        <label class="form-label">Jumlah OK Produk</label>
                                        <input id="jumlah_ok" type="number" class="form-control jumlah_ok" name="jumlah_ok[]" required>
                                    </div>
                                    <br><br>
                                    <hr class="my-15">
                                    <div class="form-group">
                                        <label class="form-label">Jumlah NG Produk</label>
                                    </div>
                                    <div id="ng-container">
                                        <div class="ng-item row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Jenis Reject NG</label>
                                                    <select id="jenis_ng" class="form-select jenis_ng" name="jenis_ng[]" required>
                                                        <option value="" disabled selected>Pilih Opsi</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" id="satuan">Jumlah Reject NG</label>
                                                    <input type="number" class="form-control jumlah_ng" name="jumlah_ng[]" required>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary col-md-3" id="addNgBtn">Tambah Reject NG</button>
                                    <div class="col-md-6"></div>
                                    <button type="button" class="btn btn-danger removeNgBtn col-md-3">Hapus</button>

                                </div>
                                <div class="row">
                                    <h4 class="box-title text-info mb-0 mt-20"><i class="ti-save me-15"></i>Report Problem Harian</h4>
                                    <hr class="my-15">
                                    <div class="form-group">
                                        <label class="form-label">Keterangan Problem</label>
                                        <input class="form-control" type="text" id="keterangan_problem" placeholder="jika terjadi problem">
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success" id="submitBtn">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->
                </div>

            </div>
        </section>
    </div>
</div>


<script src="<?= base_url() ?>assets/js/jquery-3.7.1.min.js" type="text/javascript"></script>


<script>
    $(document).ready(function() {
        const baseUrl = '<?= base_url() ?>';
        const maxNgItems = 18;
        let ngCount = 1;
        $('#material').change(function() {
            if ($(this).val() === 'Other') {
                $('#other-material-container').show();
            } else {
                $('#other-material-container').hide();
            }
        });

        function updatejenis(element) {
            $.ajax({
                url: baseUrl + 'jenis/perbaikan',
                type: 'GET',
                success: function(response) {
                    element.empty();
                    element.append('<option value="" disabled selected>Pilih Opsi</option>');
                    if (response.error) {
                        console.error(response.error);
                        return;
                    }

                    response.forEach(item => {
                        $('<option></option>')
                            .val(item.val_jenis)
                            .text(item.jenis_perbaikan)
                            .appendTo(element);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error in AJAX request:', status, error);
                }
            });
        }

        function updateSatuanText(index, jenis_dipilih) {
            if (jenis_dipilih == 'setup_mesin' || jenis_dipilih == 'cuci_barel') {
                $(`.satuan[data-index="${index}"]`).text('Jumlah Reject NG (Kilogram)');
            } else {
                $(`.satuan[data-index="${index}"]`).text('Jumlah Reject NG (Pcs)');
            }
        }

        function initializePartname() {
            $.ajax({
                url: baseUrl + 'user/getsuplier',
                type: 'GET',
                success: function(response) {
                    const data2 = response.data;
                    const select = $('#partname');
                    const suplier = $('#suplier');
                    data2.forEach(item => {
                        $('<option></option>')
                            .val(item.ITEM)
                            .text(item.ITEM)
                            .data('id', item.NO)
                            .appendTo(select);
                        suplier.val(item.suplier);
                    });
                },
                error: function(error) {
                    console.log('Error fetching data:', error);
                }
            });
        }

        $('#partname').change(function() {
            moldId = $(this).find('option:selected').data('id');
            console.log(moldId);
        });

        if ($('#partname').is('input')) {
            moldId = $('#partname').data('id');
        } else {
            moldId = $('#partname').find('option:selected').data('id');
        }

        // const waktuSekarang = new Date();
        // const tahun = waktuSekarang.getFullYear();
        // const bulan = waktuSekarang.getMonth() + 1;
        // const tanggal = waktuSekarang.getDate();
        // $('#tanggal_report').val(`${tanggal}/${bulan}/${tahun}`);

        $('#submitBtn').click(function() {
            const requiredInputs = $('#form1-content [required]');
            let allValid = true;

            requiredInputs.each(function() {
                if (!$(this).val()) {
                    $(this).addClass('is-invalid');
                    allValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            if (allValid) {
                submitForm();
            } else {
                showToast('Please fill out all required fields.', true);
            }
        });

        $('#addNgBtn').click(function() {
            if (ngCount < maxNgItems) {
                const index = ngCount + 1; // Increment for the new item
                const newNgItem = $(`
                <div class="ng-item row" id="ng-item-${index}">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Jenis Reject NG</label>
                            <select class="form-select jenis_ng" name="jenis_ng[]" required data-index="${index}">
                                <option value="" disabled selected>Pilih Opsi</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label satuan" data-index="${index}">Jumlah Reject NG</label>
                            <input type="number" class="form-control" name="jumlah_ng[]" required>
                        </div>
                    </div>
                </div>
            `);
                $('#ng-container').append(newNgItem);
                updatejenis(newNgItem.find('.jenis_ng'));
                ngCount++;
            } else {
                showToast('Maksimal 18 input reject NG', true);
            }
        });

        $(document).on('change', '.jenis_ng', function() {
            const index = $(this).data('index');;
            let jenis_dipilih = $(this).val();
            updateSatuanText(index, jenis_dipilih);
        });

        $(document).on('click', '.removeNgBtn', function() {
            if (ngCount > 1) {
                $('#ng-container .ng-item').last().remove();
                ngCount--;
            } else {
                showToast('Minimal 1 input reject NG harus ada.', true);
            }
        });

        function showToast(message, isError = false) {
            var submitToast = $('#submitToast');
            if (submitToast.length) {
                if (isError) {
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

        function submitForm() {
            const formData = new FormData();
            formData.append('moldId', moldId);
            formData.append('nama_mold', $('#partname').val());
            formData.append('jumlah_ok', $('#jumlah_ok').val());
            let selectedMaterial = $('#material').val();
            if (selectedMaterial === 'Other') {
                selectedMaterial = $('#other-material').val();
            }
            formData.append('material', selectedMaterial);
            formData.append('tanggal_report', $('#tanggal_report').val());
            formData.append('problem_harian', $('#keterangan_problem').val());

            // Daftar kolom yang diperbolehkan dari model ReportModel
            const allowedFields = [
                'setup_mesin',
                'cuci_barel',
                'cuci_mold',
                'unfil',
                'bubble',
                'crack',
                'blackdot',
                'undercut',
                'belang',
                'scratch',
                'ejector_mark',
                'flashing',
                'bending',
                'weldline',
                'sinkmark',
                'silver',
                'flow_material',
                'bushing'
            ];

            // Menyimpan nilai yang diisi
            const dataToSend = {};

            $('.ng-item').each(function() {
                const jenis = $(this).find('.jenis_ng').val();
                const jumlah = $(this).find('input[name="jumlah_ng[]"]').val();

                if (jenis && jumlah) {
                    dataToSend[jenis] = jumlah;
                }
            });

            // Menetapkan nilai 0 untuk jenis yang tidak diisi
            allowedFields.forEach(field => {
                if (!dataToSend.hasOwnProperty(field)) {
                    dataToSend[field] = 0;
                }
            });

            // Tambahkan data ke FormData
            Object.keys(dataToSend).forEach(key => {
                formData.append(key, dataToSend[key]);
            });

            $.ajax({
                url: baseUrl + 'submit/report',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.message) {
                        showToast(response.message);
                        setTimeout(() => window.location.href = ('<?= base_url('dashboard') ?>'), 2000);
                    } else if (response.error) {
                        showToast(response.error, true);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        // Initialize Partname and jenis for existing elements
        initializePartname();
        updatejenis($('#jenis_ng'));
        $('#jenis_ng').change(function() {
            let jenis_dipilih = $('#jenis_ng').val();
            console.log(jenis_dipilih);
            if (jenis_dipilih == 'setup_mesin' || jenis_dipilih == 'cuci_barel') {
                $(`#satuan`).text('Jumlah Reject NG (Kilogram)');
            } else {
                $(`#satuan`).text('Jumlah Reject NG (Pcs)');
            }
            // $('#satuan').text('Jumlah Reject NG (pcs)');
        });
    });
</script>
<?= $this->endSection() ?>