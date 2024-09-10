<?= $this->extend('template/layout'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h3 class="page-title">Profile</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#"><i class="mdi mdi-home-outline"></i></a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">User</li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Profile
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
                                <a class="active" href="#mold" data-bs-toggle="tab">List Mold</a>
                            </li>
                            <li>
                                <a href="#settings" data-bs-toggle="tab">Setting Akun</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="active tab-pane" id="mold">
                                <table id="moldTable" class="table product-overview">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Gambar</th>
                                            <th>Nama Mold</th>
                                            <th>Made In</th>
                                            <th>Status</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($data_mold['data'] as $mold) : ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td>
                                                    <?php if (!empty($mold['Gambar_Mold'])) : ?>
                                                        <a href="<?= base_url('detail/mold') ?>?namaMold=<?= urlencode($mold['ITEM']) ?>">
                                                            <img src="<?= base_url('uploads/' . $mold['Gambar_Mold']) ?>" alt="Gambar Mold" />
                                                        </a>
                                                    <?php else : ?>
                                                        Belum ada gambar
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= $mold['ITEM']; ?></td>
                                                <td><?= $mold['MADE_IN'] ?></td>
                                                <td>
                                                    <?php if ($mold['STATUS'] == 'ACTIVE') : ?>
                                                        <p class="badge badge-success"><?= $mold['STATUS'] ?></p>
                                                    <?php elseif ($mold['STATUS'] == 'NEW / INACTIVE') : ?>
                                                        <p class="badge badge-warning"><?= $mold['STATUS'] ?></p>
                                                    <?php else : ?>
                                                        <p class="badge badge-danger"><?= $mold['STATUS'] ?></p>
                                                    <?php endif; ?>
                                                </td>
                                                <td><a href="<?= base_url('detail/mold') ?>?namaMold=<?= urlencode($mold['ITEM']) ?>" class="btn btn-secondary"><span class="ti ti-eye"></span></a></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.tab-pane -->


                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="settings">
                                <form class="form-horizontal form-element col-12">
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-label">Update Data Address & Supplier</label>
                                        <div class="col-6">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateDataModal">
                                                Update
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-label">Change Password</label>
                                        <div class="col-6">
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                                Change Password
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 form-label">Delete Akun</label>
                                        <div class="col-6">
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                                Delete Account
                                            </button>
                                        </div>
                                    </div>

                                </form>

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
                                Suplier <?= $data_profil['suplier'] ?>
                            </h3>
                        </div>
                        <div class="widget-user-image">
                            <img class="rounded-circle" src="<?= base_url() ?>images/avatar/375x200/1.jpg" alt="User Avatar" />
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="description-block">
                                        <h5 class="description-header"><?= $data_mold['total'] ?></h5>
                                        <span class="description-text">Jumlah Mold</span>
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
                                        <p>
                                            Address :<span class="text-gray ps-10"><?= $data_profil['address'] ?></span>
                                        </p>
                                        <p>
                                            Username :<span class="text-gray ps-10"><?= $data_profil['username'] ?></span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="pb-15">
                                        <p class="mb-10">Activity</p>
                                        <div class="user-social-acount">
                                            <a class="btn btn-primary" href="<?= base_url('list/mold/daily') ?>?supplier=<?= urlencode($data_profil['suplier']) ?>"> <i class="mdi mdi-calendar-today"> harian</i></a>
                                            <a class="btn btn-primary" href="<?= base_url('mold/perbaikan/besar') ?>?supplier=<?= urlencode($data_profil['suplier']) ?>"> <i class="mdi mdi-package-variant"> perbaikan</i> </a>

                                        </div>
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

        <div class="modal fade" id="updateDataModal" tabindex="-1" aria-labelledby="updateDataModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" action="<?= base_url('user/updateAddressSupplier') ?>">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateDataModalLabel">Update Address & Supplier</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="username" value="<?= esc($data_profil['username']) ?>">
                            <div class="form-group">
                                <label for="inputAddress">Address</label>
                                <input type="text" class="form-control" name="address" id="inputAddress" placeholder="Enter new address" value="<?= esc($data_profil['address']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputSupplier">Supplier</label>
                                <input type="text" class="form-control" name="supplier" id="inputSupplier" placeholder="Enter new supplier" value="<?= esc($data_profil['suplier']) ?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for Delete Account -->
        <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <?php if ($data_mold['data'] == null) : ?>
                        <form method="post" action="<?= base_url('user/deleteAccount') ?>">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteAccountModalLabel">Delete Account</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="username" value="<?= esc($data_profil['username']) ?>">
                                <p>Are you sure you want to delete this account? This action cannot be undone.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">Delete</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    <?php else : ?>
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteAccountModalLabel">Delete Account</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="username" value="<?= esc($data_profil['username']) ?>">
                            <p>Pindahkan mold dahulu,sebelum delete!</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Modal for Change Password -->
        <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" action="<?= base_url('user/changePassword') ?>">
                        <div class="modal-header">
                            <h5 class="modal-title" id="changePasswordModalLabel">Change Password for <?= esc($data_profil['username']) ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Input hidden untuk mengirim username -->
                            <input type="hidden" name="username" value="<?= esc($data_profil['username']) ?>">
                            <input type="hidden" name="suplier" value="<?= esc($data_profil['suplier']) ?>">
                            <div class="form-group">
                                <label for="newPassword">New Password</label>
                                <input type="password" class="form-control" name="new_password" id="newPassword" placeholder="Enter new password" required>
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">Confirm New Password</label>
                                <input type="password" class="form-control" name="confirm_password" id="confirmPassword" placeholder="Confirm new password" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-warning">Change Password</button>
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
<script>
    $(document).ready(function() {
        // Initialize DataTables
        var table = $('#moldTable').DataTable({
            "paging": true, // Enable pagination
            "searching": true, // Enable search
            "ordering": true, // Enable sorting
            "info": true, // Show information about the table
            "pageLength": 5, // Default number of rows per page

        });
    })
</script>
<?= $this->endSection() ?>

