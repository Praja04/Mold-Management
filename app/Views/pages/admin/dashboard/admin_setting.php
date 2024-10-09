<?= $this->extend('template/layout'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h3 class="page-title">Settings Admin</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#"><i class="mdi mdi-home-outline"></i></a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Admin</li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Settings
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
                <div class="col-12 col-lg-7 col-xl-8">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li>
                                <a class="active" href="#settings" data-bs-toggle="tab">Settings</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="active tab-pane" id="settings">
                                <form class="form-horizontal form-element col-12">
                                    <div class="form-group row">
                                        <div class="col-6">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAdminModal">
                                                Add Admin +
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <table id="dataAdmin" class="table product-overview">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($admin as $data) : ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $data['name']; ?></td>
                                                <td><?= $data['email'] ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-lg-5 col-xl-4">
                    <div class="box box-widget widget-user">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-img bbsr-0 bber-0" style="
                      background: #00baff
                        center center;
                    " data-overlay="5">
                            <h3 class="widget-user-username text-white">
                                <?= $admin_nama ?>
                            </h3>
                        </div>
                        <div class="widget-user-image">
                            <img class="rounded-circle" src="<?= base_url() ?>images/avatar/375x200/1.jpg" alt="User Avatar" />
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="description-block">
                                        <h5 class="description-header"><?= $divisi ?></h5>
                                        <span class="description-text">Divisi</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>

                            </div>
                            <!-- /.row -->
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-body box-profile">
                            <div class="row">
                                <div class="col-12">
                                    <div>
                                        <h3>Profile</h3>
                                        <p>
                                            NPK :<span class="text-gray ps-10"><?= $admin_id ?></span>
                                        </p>
                                        <p>
                                            Role :<span class="text-gray ps-10"><?= $role ?></span>
                                        </p>
                                        <p>
                                            Departement :<span class="text-gray ps-10"><?= $departement ?></span>
                                        </p>
                                        <p>
                                            Section :<span class="text-gray ps-10"><?= $section ?></span>
                                        </p>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>

                </div>

            </div>
            <!-- /.row -->
        </section>
        <div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Remove the action from the form and handle it via JS -->
                    <form id="createAdminForm">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addAdminModalLabel">Add admin for notification gmail</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="inputAddress">Nama</label>
                                <input type="text" class="form-control" name="nama" id="nama" placeholder="Enter Name">
                            </div>
                            <div class="form-group">
                                <label for="inputSupplier">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email">
                            </div>
                            <div class="form-group">
                                <label for="inputSupplier">Role</label>
                                <select class="form-select" name="role" id="role">
                                    <option value="staff">Staff</option>
                                    <option value="kasi">Kasi</option>
                                    <option value="kadept">Kadept</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- /.content -->
    </div>
</div>


<script src="<?= base_url() ?>assets/js/jquery-3.7.1.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/vendor_components/sweetalert/sweetalert2.all.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTables
        var table = $('#dataAdmin').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "pageLength": 5,
        });

        $('#createAdminForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the form from submitting normally
            // Get form data
            var formData = $(this).serialize(); // Collect form data

            $.ajax({
                type: 'POST',
                url: '<?= base_url('add/admin') ?>',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.message) {
                        // Show success message using SweetAlert2
                        $('#addAdminModal').modal('hide');
                        sweetalertUpdate(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    var errorMessage = xhr.responseJSON ? xhr.responseJSON.error : 'An error occurred!';
                    alert(errorMessage);
                }
            });
        });
        function sweetalertUpdate(message) {
            Swal.fire({
                title: "Create Admin!",
                text: message,
                icon: "success",
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Menutup modal sebelum redirect
                    $('#addAdminModal').modal('hide');
                    // Redirect ketika 'ok' di klik
                    window.location.href = '<?= base_url('admin/setting') ?>';
                }
            });
        }
    })
</script>
<?= $this->endSection() ?>