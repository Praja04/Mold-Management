<?= $this->extend('template/layout'); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="container-full">
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="box bg-gradient-primary overflow-hidden pull-up">
            <div class="box-body pe-0 ps-lg-50 ps-15 py-0">
              <div class="row align-items-center">
                <div class="col-12 col-lg-8">
                  <h1 class="fs-40 text-white" id="nama"></h1>
                  <p class="text-white mb-0 fs-20">
                    Cek keadaan mold anda, dan beritahu jika ada kendala.
                  </p>
                </div>
                <div class="col-12 col-lg-4"><img src="<?= base_url('assets/images/custom-15.svg') ?>" alt=""></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="box no-shadow mb-0 bg-transparent">
            <div class="box-header no-border px-0">
              <h4 class="box-title">Your Dashboard Mold</h4>
              <ul class="box-controls pull-right d-md-flex d-none">
              </ul>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 col-12"></div>
        <div class="col-xl-3 col-md-6 col-12">
          <div class="box bg-secondary-light pull-up">
            <div class="box-body">
              <div class="flex-grow-1">
                <div class="d-flex align-items-center pe-2 justify-content-between">
                  <div class="d-flex">
                    <span class="badge badge-primary me-10">Mold CBI</span>
                    <span class="badge badge-primary me-5"><i class="fa fa-product-hunt"></i></span>
                  </div>

                </div>
                <h4 class="mt-25 mb-5" id="total"></h4>
                <p class="text-fade mb-0 fs-12">Total Mold Anda</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 col-12">
          <div class="box bg-secondary-light pull-up">
            <div class="box-body">
              <div class="flex-grow-1">
                <div class="d-flex align-items-center pe-2 justify-content-between">
                  <div class="d-flex">
                    <span class="badge badge-primary me-10">Supplier</span>
                    <span class="badge badge-primary me-5"><i class="fa fa-calendar-o "></i></span>
                  </div>
                  <!-- <div class="dropdown"></div> -->
                </div>
                <h4 class="mt-25 mb-5" id="suplier"></h4>
                <p class="text-fade mb-0 fs-12">Your Company</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-12 col-lg-6 col-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Table Mold Anda</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <div class="text-center row mb-3">
                  <div class="filter-buttons mb-3">
                    <button class="btn btn-primary filter" data-filter="all">All</button>
                    <button class="btn btn-primary filter" data-filter="container">Container</button>
                    <button class="btn btn-primary filter" data-filter="cover">Cover</button>
                    <button class="btn btn-primary filter" data-filter="other">Other</button>
                  </div>
                </div>
                <table id="example5" class="table table-bordered table-striped text-center" style="width:100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Mold</th>
                      <th>Action</th>
                      <th>Jumlah Produksi</th>
                      <!-- <th>Jumlah Dikirim</th> -->
                      <th>Report Harian</th>
                      <th>Perbaikan Besar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 1;
                    foreach ($data as $items) : ?>
                      <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $items['ITEM'] ?></td>
                        <td>
                          <button class="daily-button aksi-button btn btn-primary text-white me-0" style="margin:5px;" data-item="<?= $items['ITEM'] ?>" data-id="<?= $items['NO'] ?>">Report Harian</button>
                          <button class="perbaikan-button aksi-button btn btn-primary text-white me-0" style="margin:5px;" data-item="<?= $items['ITEM'] ?>" data-id="<?= $items['NO'] ?>">Perbaikan Besar</button>
                        </td>
                        <td>
                          <?= number_format($items['jumlah_produk'], 0, ',', '.') ?>
                        </td>
                        <!-- <td>
                          <?= number_format($items['total_jumlah_produk'], 0, ',', '.') ?>
                        </td> -->

                        <td><a class="btn btn-secondary" href="<?= base_url('history/report') ?>?namaMold=<?= urlencode($items['ITEM']) ?>"><span class="ti ti-eye"></a></td>
                        <td><a class="btn btn-info" href="<?= base_url('history/perbaikan') ?>?namaMold=<?= urlencode($items['ITEM']) ?>"><span class="ti ti-eye"></a></td>

                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
</div>
<!-- /.content-wrapper -->


<script src="<?= base_url() ?>assets/js/jquery-3.7.1.min.js" type="text/javascript"></script>
<script>
  const baseUrl = '<?= base_url() ?>';

  $(document).ready(function() {
    // Fetch and display user data

    $('.filter').on('click', function() {
      var filterValue = $(this).data('filter');

      if (filterValue === 'all') {
        table.column(1).search('').draw();
      } else if (filterValue === 'other') {
        table.column(1).search('^(?!.*(Container|Cover)).*$', true, false).draw();
      } else {
        table.column(1).search(filterValue, true, false).draw();
      }
    });

    $.ajax({
      url: baseUrl + 'user/data',
      type: 'GET',
      success: function(data) {
        const user = data.data_user;
        $('#suplier').text(user.suplier);
        $('#nama').text('Welcome ' + user.username + ' !');
        console.log(user.username);

      },
      error: function(xhr, status, error) {
        console.error('Error fetching user data:', status, error);
      }
    });

    // Fetch total molds
    $.ajax({
      url: baseUrl + 'user/total',
      type: 'GET',
      success: function(response) {
        $('#total').text(response.total);
      },
      error: function(error) {
        console.log('Error fetching total molds:', error);
      }
    });

    // Initialize DataTable without search feature
    var table = $('#example5').DataTable({
      "paging": true,
      "searching": true, // Disable search
      "ordering": true,
      "info": true,
      "language": {
        "emptyTable": "No data available in table",
        "info": "Showing _START_ to _END_ of _TOTAL_ entries",
        "infoEmpty": "Showing 0 to 0 of 0 entries",
        "infoFiltered": "(filtered from _MAX_ total entries)",
        "lengthMenu": "Show _MENU_ entries",
        "loadingRecords": "Loading...",
        "processing": "Processing...",
        "zeroRecords": "No matching records found"
      }

    });

    $(document).on('click', '.daily-button', function() {
      var item = $(this).data('item');
      var id = $(this).data('id');
      var url = baseUrl + 'report?item=' + encodeURIComponent(item) + '&id=' + encodeURIComponent(id);
      // Mengarahkan ke URL yang dibuat
      window.location.href = url;
    });

    $(document).on('click', '.perbaikan-button', function() {
      var item = $(this).data('item');
      var id = $(this).data('id');
      var url = baseUrl + 'user/perbaikan?item=' + encodeURIComponent(item) + '&id=' + encodeURIComponent(id);
      window.location.href = url;
    });


  });
</script>


<?= $this->endSection(); ?>