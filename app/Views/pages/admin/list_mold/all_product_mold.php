<?= $this->extend('template/layout'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <div class="container-full">
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h3 class="page-title">Products</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#"><i class="mdi mdi-home-outline"></i></a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">
                                    Mold
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    PT.CBI
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
                <div class="col-12 col-lg-12">
                    <div class="box">
                        <div class="box-header bg-primary">
                            <h4 class="box-title">List Mold PT.CBI</h4>
                        </div>

                        <div class="box-body">
                            <div class="table-responsive">
                                <div class="text-center row mb-3">
                                    <div class="filter-buttons mb-3">
                                        <button class="btn btn-primary filter" data-filter="all">All</button>
                                        <button class="btn btn-primary filter" data-filter="container">Container</button>
                                        <button class="btn btn-primary filter" data-filter="cover">Cover</button>
                                        <button class="btn btn-primary filter" data-filter="other">Other</button>
                                        <?php
                                        // Extract distinct suppliers from the $molds array
                                        $distinctSuppliers = array_unique(array_column($molds, 'suplier'));
                                        ?>
                                        <select style="margin-top: 9px;" id="supplierFilter" class="form-control">
                                            <option value="all">All Suppliers</option>
                                            <?php foreach ($distinctSuppliers as $supplier) : ?>
                                                <option value="<?= htmlspecialchars($supplier) ?>"><?= htmlspecialchars($supplier) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <table id="moldTable" class="table product-overview">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Gambar</th>
                                            <th>Nama Mold</th>
                                            <th>Supplier</th>
                                            <th>Made In</th>
                                            <th>Material</th>
                                            <th>Dimensi Mold</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($molds as $mold) : ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td>
                                                    <?php if (!empty($mold['Gambar_Mold'])) : ?>
                                                        <a href="<?= base_url('detail/mold') ?>?namaMold=<?= urlencode($mold['ITEM']) ?>">
                                                            <img src="<?= base_url('uploads/' . $mold['Gambar_Mold']) ?>" alt="" style="width: 80px; height:60px;" />
                                                        </a>
                                                    <?php else :  ?>
                                                        Belum ada gambar
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= $mold['ITEM']; ?></td>
                                                <td><?= $mold['suplier']; ?></td>
                                                <td><?= $mold['MADE_IN'] ?></td>
                                                <td><?= $mold['Material'] ?></td>
                                                <td><?= $mold['DIMENSI_MOLD'] ?></td>
                                                <td>
                                                    <?php if ($mold['STATUS'] == 'ACTIVE') : ?>
                                                        <p class="badge badge-success"><?= $mold['STATUS'] ?></p>
                                                    <?php elseif ($mold['STATUS'] == 'NEW / INACTIVE') : ?>
                                                        <p class="badge badge-warning"><?= $mold['STATUS'] ?></p>
                                                    <?php else : ?>
                                                        <p class="badge badge-danger"><?= $mold['STATUS'] ?></p>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= $mold['KETERANGAN'] ?></td>
                                                <td><a href="<?= base_url('detail/mold') ?>?namaMold=<?= urlencode($mold['ITEM']) ?>" class=" btn btn-secondary"><span class="ti ti-eye"></a></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </section>

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

        // Filter button click event
        $('.filter').on('click', function() {
            var filterValue = $(this).data('filter');

            if (filterValue === 'all') {
                // Show all rows
                table.column(2).search('').draw();
            } else if (filterValue === 'other') {
                // Filter out rows that contain 'Container' or 'Cover'
                table.column(2).search('^(?!.*(Container|Cover)).*$', true, false).draw();
            } else {
                // Filter rows that contain the specific word (Container or Cover)
                table.column(2).search(filterValue, true, false).draw();
            }
        });
        // Filter2 button click event
        $('#supplierFilter').on('change', function() {
            var filterValue = $(this).val();

            if (filterValue === 'all') {
                // Show all rows
                table.column(3).search('').draw(); // Column 2 for Supplier
            } else {
                // Filter rows by selected supplier
                table.column(3).search('^' + filterValue + '$', true, false).draw(); // Column 2 for Supplier
            }
        });


    });
</script>

<?= $this->endSection() ?>